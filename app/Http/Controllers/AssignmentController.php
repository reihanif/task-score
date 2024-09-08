<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\Task;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\RecurrencePattern;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewAssignment;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AssignmentResolved;
use App\Notifications\AssignmentSubmitted;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAssignmentTaskmaster;
use App\Notifications\AssignmentSubmittedAssignee;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the unresolved assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAssignment()
    {
        $categories = $this->getCategories();
        $user = Auth::User();
        $superiors = $user->position->superior?->users ?? [];

        return view('app.taskscore.assignments.my-assignments', [
            'unresolved_assignments' => $user->unresolvedAssignments,
            'pending_assignments' => $user->pendingAssignments,
            'resolved_assignments' => $user->resolvedAssignments,
            'categories' => $categories,
            'superiors' => $superiors
        ]);
    }

    /**
     * Display a listing of the resolved assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function resolved()
    {
        $assignments = Assignment::where('assigned_to', Auth::User()->id)->where('resolved_at', '!=', null)->orderBy('created_at')->get();

        return view('app.taskscore.assignments.resolved', [
            'assignments' => $assignments,
        ]);
    }

    /**
     * Show list of subordinate assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function subordinateAssignment()
    {
        $user = Auth::user();

        $assignees = $this->getUserSubordinates($user);
        $assignments = $this->getUserAssignments($user);
        $categories = $this->getCategories();

        return view('app.taskscore.assignments.subordinate-assignments', [
            'assignees' => $assignees,
            'assignments' => $assignments,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'subject' => 'required|unique:assignments,subject|max:255',
            'description' => 'required|max:2000',
        ]);

        if ($request->category == 'Lainnya') {
            $type = ucwords($request->category_other);
        } else {
            $type = $request->category;
        }

        DB::beginTransaction();

        try {
            $assignment = new Assignment();
            $assignment->taskmaster_id = Auth::User()->id;
            $assignment->type = $type;
            $assignment->subject = $request->subject;
            $assignment->description = $request->description;
            $assignment->is_recurring = $request->is_recurring ? true : false;
            $assignment->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $client_original_name = $attachment->getClientOriginalName();
                    $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                    $extension = $attachment->getClientOriginalExtension();
                    $unique_filename = $filename . '_' . time() . '.' . $extension;

                    $path = $attachment->storeAs('public/assignment/' . $assignment->id . '/attachments', $unique_filename);

                    $file = new File();
                    $file->name = $filename;
                    $file->path = $path;
                    $file->extension = $extension;
                    $file->size = $attachment->getSize();
                    $file->type = 'attachment';
                    $file->fileable_id = $assignment->id;
                    $file->fileable_type = Assignment::class;
                    $file->save();
                }
            }

            $tasks = new Collection;
            $assignees_name = '';

            foreach ($request->assignees as $key => $assignee) {
                if ($request->difficulty == 'basic') {
                    $due = Carbon::now()->addDays(1);
                } else if ($request->difficulty == 'intermediate') {
                    $due = Carbon::now()->addDays(2);
                } else if ($request->difficulty == 'advanced') {
                    $due = Carbon::now()->addDays(3);
                }

                $task = new Task();
                $task->uuid = $task->generateUniqueId();
                $task->assignee_id = $assignee;
                $task->assignment_id = $assignment->id;
                $task->description = $request->details[$key];
                $task->difficulty = $request->difficulty;
                $task->due = $due;
                $task->save();

                $assignees_name .= $task->assignee->name . ' ';
                $tasks->push($task);
            }

            if ($request->is_recurring) {
                $recurrence_end_date = null;
                if ($request->recurrence_end_date) {
                    $recurrence_end_date = new Carbon($request->recurrence_end_date);
                }
                RecurrencePattern::create([
                    'assignment_id' => $assignment->id,
                    'recurrence_type' => $request->repeat,
                    'day_of_week' => $request->day_of_weeks,
                    'day_of_month' => $request->day_of_month,
                    'time' => $request->time,
                    'recurrence_end_date' => $recurrence_end_date
                ]);
            }

            // Send notifications
            foreach ($tasks as $task) {
                $assignees = User::where('id', $task->assignee_id)->get();
                Notification::send($assignees, new NewAssignment($assignment, $task));
            }

            $taskmasters = User::where('id', $assignment->taskmaster_id)->get();
            Notification::send($taskmasters, new NewAssignmentTaskmaster($assignment, $assignees_name));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the error appropriately
            return redirect()->back()->withErrors('Create assignment failed');
        }

        return redirect()->back()->with('success', 'Assignment created successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMyAssignment(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'subject' => 'required|unique:assignments,subject|max:255',
            'description' => 'required|max:2000',
        ]);

        if ($request->category == 'Lainnya') {
            $type = ucwords($request->category_other);
        } else {
            $type = $request->category;
        }

        DB::beginTransaction();

        try {
            $assignment = new Assignment();
            $assignment->taskmaster_id = $request->taskmaster;
            $assignment->type = $type;
            $assignment->subject = $request->subject;
            $assignment->description = $request->description;
            $assignment->is_recurring = $request->is_recurring ? true : false;
            $assignment->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $client_original_name = $attachment->getClientOriginalName();
                    $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                    $extension = $attachment->getClientOriginalExtension();
                    $unique_filename = $filename . '_' . time() . '.' . $extension;

                    $path = $attachment->storeAs('public/assignment/' . $assignment->id . '/attachments', $unique_filename);

                    $file = new File();
                    $file->name = $filename;
                    $file->path = $path;
                    $file->extension = $extension;
                    $file->size = $attachment->getSize();
                    $file->type = 'attachment';
                    $file->fileable_id = $assignment->id;
                    $file->fileable_type = Assignment::class;
                    $file->save();
                }
            }

            if ($request->difficulty == 'basic') {
                $due = Carbon::now()->addDays(1);
            } else if ($request->difficulty == 'intermediate') {
                $due = Carbon::now()->addDays(2);
            } else if ($request->difficulty == 'advanced') {
                $due = Carbon::now()->addDays(3);
            }

            $task = new Task();
            $task->uuid = $task->generateUniqueId();
            $task->assignee_id = Auth::User()->id;
            $task->assignment_id = $assignment->id;
            $task->difficulty = $request->difficulty;
            $task->due = $due;
            $task->save();

            if ($request->is_recurring) {
                $recurrence_end_date = null;
                if ($request->recurrence_end_date) {
                    $recurrence_end_date = new Carbon($request->recurrence_end_date);
                }
                RecurrencePattern::create([
                    'assignment_id' => $assignment->id,
                    'recurrence_type' => $request->repeat,
                    'day_of_week' => $request->day_of_weeks,
                    'day_of_month' => $request->day_of_month,
                    'time' => $request->time,
                    'recurrence_end_date' => $recurrence_end_date
                ]);
            }

            // Send notifications
            $assignees = User::where('id', $task->assignee_id)->get();
            Notification::send($assignees, new NewAssignment($assignment, $task));

            $taskmasters = User::where('id', $assignment->taskmaster_id)->get();
            Notification::send($taskmasters, new NewAssignmentTaskmaster($assignment, Auth::User()->name));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the error appropriately
            return redirect()->back()->withErrors('Create assignment failed');
        }

        return redirect()->back()->with('success', 'Assignment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        $task = $request->task ? Task::findOrFail($request->task) : null;

        return view('app.taskscore.assignments.show', [
            'assignment' => $assignment,
            'assignee_task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|unique:assignments,subject,' . $id,
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $assignment = Assignment::findOrFail($id);
            $assignment->subject = $request->subject;
            $assignment->description = $request->description;
            $assignment->save();

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Update assignment failed');
        }

        return redirect()->back()->with('success', 'Assignment updated successfully');
    }

    /**
     * Update the task due.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDue(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $task = Task::findOrFail($id);
            if ($request->timetable) {
                $task->due = $task->due->addMinutes($request->timetable);
            } elseif ($request->date && $request->time) {
                $date = $request->date;
                $time = $request->time;
                $task->due = Carbon::parse("$date $time");
            }
            $task->save();

            // Execute database update
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to update due');
        }

        return redirect()->back()->with('success', 'Assignment ' . $task->uuid . ' due has been updated');
    }

    /**
     * Resolve the specified assignment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resolve(Request $request, $id)
    {
        $request->validate([
            'resolution' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $task = Task::findOrFail($id);
            $assignment = Assignment::findOrFail($task->assignment_id);

            $submission = new Submission();
            $submission->task_id = $id;
            $submission->detail = $request->resolution;
            $submission->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $client_original_name = $attachment->getClientOriginalName();
                    $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                    $extension = $attachment->getClientOriginalExtension();
                    $unique_filename = $filename . '_' . time() . '.' . $extension;

                    $path = $attachment->storeAs('public/assignment/' . $assignment->id . '/attachments', $unique_filename);

                    $file = new File();
                    $file->name = $filename;
                    $file->path = $path;
                    $file->extension = $extension;
                    $file->size = $attachment->getSize();
                    $file->type = 'submisison';
                    $file->fileable_id = $submission->id;
                    $file->fileable_type = Submission::class;
                    $file->save();
                }
            }

            $taskmasters = User::where('id', $assignment->taskmaster_id)->get();
            Notification::send($taskmasters, new AssignmentSubmitted($assignment, $task));
            Notification::send($task->assignee, new AssignmentSubmittedAssignee($assignment, $task));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Resolve assignment failed');
        }

        return redirect()->back()->with('success', $assignment->subject . ' has been resolved');
    }

    /**
     * Close the specified assignment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($id)
    {
        try {
            $assignment = Assignment::findOrFail($id);
            $assignment->timestamps = false;
            $assignment->status = 'closed';
            $assignment->closed_at = Carbon::now()->toDateTimeString();
            $assignment->save();
        } catch (\Exception $e) {
            // Handle the error appropriately
            return redirect()->back()->withErrors('Close assignment failed');
        }

        return redirect()->back()->with('success', $assignment->subject . ' has been closed');
    }

    /**
     * Open the specified assignment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function open($id)
    {
        try {
            $assignment = Assignment::findOrFail($id);
            $assignment->timestamps = false;
            $assignment->status = 'open';
            $assignment->closed_at = null;
            $assignment->save();
        } catch (\Exception $e) {
            // Handle the error appropriately
            return redirect()->back()->withErrors('Open assignment failed');
        }

        return redirect()->back()->with('success', $assignment->subject . ' has been opened');
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $assignment = Assignment::findOrFail($id);
            $assignment->timestamps = false;
            $assignment->delete();
        } catch (\Exception $e) {
            // Handle the error appropriately
            return redirect()->back()->withErrors('Delete assignment failed');
        }

        return redirect()->route('taskscore.assignment.subordinate-assignments')->with('success', $assignment->subject . ' has been deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getUserSubordinates($user)
    {
        return $user->allSubordinates()->get();
    }

    private function getUserAssignments($user)
    {
        // Initialize the query
        $query = Assignment::query();

        if (is_null($user->position_id)) {
            // If user has no position, fetch assignments directly assigned to them
            $query->where('taskmaster_id', $user->id);
        } else {
            // If user has a position, fetch assignments for subordinates
            $assigneeIds = $user->allSubordinates()->pluck('id');
            $query->whereHas('taskmaster', function ($query) use ($user) {
                $query->where('position_id', $user->position_id);
            })->whereHas('tasks', function ($query) use ($assigneeIds) {
                $query->whereIn('assignee_id', $assigneeIds);
            });
        }

        // Order assignments by creation date and get results
        return $query->orderBy('created_at', 'desc')->get();
    }

    private function getCategories()
    {
        // Default types of assignments
        $defaultTypes = [
            'Memorandum',
            'Surat',
            'Surat Keputusan',
            'Surat Perintah',
            'Surat Edaran',
            'Presentasi',
            'Rapat',
            'Perjalanan Dinas',
            'SP3',
            'Berita Acara',
            'Sales Order'
        ];

        // Extract and filter assignment types
        $assignmentTypes = Assignment::pluck('type')->filter(function ($type) {
            return $type !== 'Lainnya';
        })->unique()->toArray();

        // Combine and sort categories, adding 'Lainnya' at the end
        return collect($defaultTypes)
            ->merge($assignmentTypes)
            ->sort()
            ->values()
            ->push('Lainnya')
            ->unique();
    }
}
