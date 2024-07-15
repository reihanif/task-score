<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\Task;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewAssignment;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AssignmentResolved;
use App\Notifications\AssignmentSubmitted;
use Illuminate\Support\Facades\Notification;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the unresolved assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAssignment()
    {
        return view('app.taskscore.assignments.my-assignments', [
            'unresolved_assignments' => Auth::User()->unresolvedAssignments(),
            'pending_assignments' => Auth::User()->pendingAssignments(),
            'resolved_assignments' => Auth::User()->resolvedAssignments,
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subordinateAssignment()
    {
        $assignees = Auth::User()->subordinates();

        $assignments = Assignment::where('taskmaster_id', Auth::User()->id)->orderBy('created_at')->get();
        $types = $assignments->map(function ($assignment) {
            return collect($assignment->toArray())
                ->only(['type'])
                ->all();
        })->flatten()->unique();

        return view('app.taskscore.assignments.subordinate-assignments', [
            'assignees' => $assignees,
            'assignments' => $assignments,
            'types' => $types
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
            'subject' => 'required|unique:assignments,subject',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $assignment = new Assignment();
            $assignment->taskmaster_id = Auth::User()->id;
            $assignment->type = $request->category;
            $assignment->subject = $request->subject;
            $assignment->description = $request->description;
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

            foreach ($request->assignees as $key => $assignee) {
                // if (array_key_exists($key, $request->timetables)) {
                //     $due = Carbon::now()->addMinutes($request->timetables[$key]);
                // } elseif (array_key_exists($key, $request->dates) && array_key_exists($key, $request->times)) {
                //     $date = $request->dates[$key];
                //     $time = $request->times[$key];
                //     $due = Carbon::parse("$date $time");
                // }

                if ($request->due_type == 'category') {
                    $due = Carbon::createFromFormat('d/m/Y H:i',  $request->duedate);
                } elseif ($request->due_type == 'difficulty') {
                    $due = Carbon::now()->addDays($request->difficulty);
                }

                $task = new Task();
                $task->uuid = $task->generateUniqueId();
                $task->assignee_id = $assignee;
                $task->assignment_id = $assignment->id;
                $task->description = $request->details[$key];
                $task->due = $due;
                $task->save();

                $tasks->push($task);
            }

            // Send notifications
            foreach ($tasks as $task) {
                $assignees = User::where('id', $task->assignee_id)->get();
                Notification::send($assignees, new NewAssignment($assignment, $task));
            }

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Create assignment failed');
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
        $assignees = User::where('id', '!=', Auth::User()->id)->whereNotNull('position_id')->whereHas('position', function ($query) {
            $query->where('path', 'LIKE', '%' . Auth::User()->position?->id . '%');
        })->get()->sortBy('name');

        $task = null;

        if ($request->task) {
            $task = Task::findOrFail($request->task);
        }

        $assignment = Assignment::findOrFail($id);

        return view('app.taskscore.assignments.show', [
            'assignment' => $assignment,
            'assignee_task' => $task,
            'assignees' => $assignees
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

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Resolve assignment failed');
        }

        return redirect()->back()->with('success', $assignment->subject . 'has been resolved');
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

        return redirect()->back()->with('success', $assignment->subject . 'has been closed');
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

        return redirect()->back()->with('success', $assignment->subject . 'has been opened');
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
}
