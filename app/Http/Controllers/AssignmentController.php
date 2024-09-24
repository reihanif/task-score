<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Services\TaskService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\AssignmentService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Assignments\AssignmentCreated;
use App\Notifications\Assignments\AssignmentSubmitted;

class AssignmentController extends Controller
{
    protected $assignmentService;
    protected $fileService;
    protected $taskService;

    public function __construct(AssignmentService $assignmentService, FileService $fileService, TaskService $taskService)
    {
        $this->assignmentService = $assignmentService;
        $this->fileService = $fileService;
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the unresolved assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAssignment()
    {
        $categories = $this->getCategories();
        $user = auth()->user();
        $superiors = User::whereIn('position_id', $user->position?->superiors->pluck('id') ?? [])->get();

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
        $assignments = Assignment::where('assigned_to', auth()->id())->where('resolved_at', '!=', null)->orderBy('created_at')->get();

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
        $user = auth()->user();

        $assignees = $user->subordinates;
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
            'type' => 'required|max:255',
            'subject' => 'required|unique:assignments,subject|max:255',
            'description' => 'required',
            'difficulty' => 'nullable|string|in:basic,intermediate,advanced|max:255',
            'assignees' => 'array',
            'assignees.*.id' => 'required|uuid',
            'type_other' => Rule::requiredIf($request->type == 'Lainnya'),
            'ocurrence_type' => 'required|string'
        ]);

        $request->merge([
            'taskmaster' => auth()->user()->position_id,
            'creator' => auth()->id(),
            'due' => $this->calculateDueDate(collect($request)),
            'type' => $request->type == 'Lainnya' ? ucwords($request->type_other) : $request->type,
            'is_recurring' => $request->ocurrence_type == 'recurring' ? true : false,
        ]);

        DB::beginTransaction();

        try {
            $assignment = $this->assignmentService->createAssignment(collect($request));
            $tasks = $this->createTasks($request, $assignment);

            if ($request->hasFile('attachments')) {
                $this->handleAttachments($request->file('attachments'), $assignment);
            }

            // Send notifications
            foreach ($tasks as $task) {
                $task->assignee->notify(new AssignmentCreated($task));
            }
            Notification::send($assignment->taskmaster->permitted_users, new AssignmentCreated($tasks->first()));

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
            'type' => 'required|max:255',
            'subject' => 'required|unique:assignments,subject|max:255',
            'description' => 'required',
            'difficulty' => 'nullable|string|in:basic,intermediate,advanced|max:255',
            'type_other' => Rule::requiredIf($request->type == 'Lainnya'),
        ]);

        // Merge necessary values into request
        $request->merge([
            'creator' => auth()->id(),
            'due' => $due,
            'type' => $request->type == 'Lainnya' ? ucwords($request->type_other) : $request->type,
            'is_recurring' => $request->ocurrence_type == 'recurring' ? true : false,
        ]);

        DB::beginTransaction();

        try {
            // Create assignment
            $assignment = $this->assignmentService->createAssignment(collect($request));

            // Handle file attachments, if any
            if ($request->hasFile('attachments')) {
                $this->handleAttachments($request->file('attachments'), $assignment);
            }

            // Create the task and assign it to the current user
            $task = $this->taskService->createTask(collect([
                'assignee' => auth()->id(),
                'assignment' => $assignment->id,
                'description' => null,
                'difficulty' => $request->difficulty,
                'due' => $request->due,
            ]));

            // Send notification to the assignee
            $task->assignee->notify(new AssignmentCreated($task));

            // Send notification to the taskmaster
            Notification::send($assignment->taskmaster->permitted_users, new AssignmentCreated($task));

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
        $recurrence = $assignment->recurrence;
        list($hour, $minute) = explode(':', $recurrence->time->format('H:i'));

        $next_month = Carbon::now()->addMonth()->startOfMonth();
        $last_day_of_next_month = $next_month->copy()->endOfMonth();

        if ($recurrence->day_of_month > $last_day_of_next_month->day) {
            $next_month_date = $last_day_of_next_month->setTime($hour, $minute);
        } else {
            $next_month_date = $next_month->addDays($recurrence->day_of_month - 1)->setTime($hour, $minute);
        }

        if (Carbon::now()->diffInDays($next_month_date, false) <= 30 && $assignment->latestTask->created_at->diffInDays($next_month_date, false) < 30 ) {
            $replicate_assignment = true;
            $due = $next_month_date;
        }

        dd($replicate_assignment, $due);

        $task = $request->task ? Task::findOrFail($request->task) : null;
        $categories = $this->getCategories();

        return view('app.taskscore.assignments.show', [
            'assignment' => $assignment,
            'assignee_task' => $task,
            'categories' => $categories
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
            'type' => 'required|max:255',
            'type_other' => Rule::requiredIf($request->type == 'Lainnya'),
            'description' => 'required',
        ]);
        $request->merge([
            'type' => $request->type == 'Lainnya' ? ucwords($request->type_other) : $request->type,
        ]);

        DB::beginTransaction();

        try {
            $assignment = Assignment::findOrFail($id);
            $assignment->subject = $request->subject;
            $assignment->type = $request->type;
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
            $submission = new Submission();
            $submission->task_id = $id;
            $submission->detail = $request->resolution;
            $submission->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileable = [
                        'path' => 'public/assignment/' . $submission->task->assignment->id . '/attachments',
                        'type' => 'submission',
                        'fileable_id' => $submission->id,
                        'fileable_type' => Submission::class,
                    ];
                    $this->fileService->storeFile($file, $fileable);
                }
            }

            Notification::send($submission->task->assignment->taskmaster->permitted_users, new AssignmentSubmitted($submission->task));
            $submission->task->assignee->notify(new AssignmentSubmitted($submission->task));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the error appropriately
            return redirect()->back()->withErrors('Resolve assignment failed');
        }

        return redirect()->back()->with('success', $submission->task->assignment->subject . ' has been resolved');
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

    private function getUserAssignments($user)
    {
        // Initialize the query
        $query = Assignment::query();

        if (is_null($user->position_id)) {
            // If user has no position, fetch assignments directly assigned to them
            $query->where('creator_id', $user->id);
        } else {
            // If user has a position, fetch assignments for subordinates
            $assigneeIds = $user->allSubordinates()->pluck('id');
            $query->where('taskmaster_id', $user->position_id)->whereHas('tasks', function ($query) use ($assigneeIds) {
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

    private function calculateDueDate(Collection $data)
    {
        switch ($data['ocurrence_type']) {
            case('one-time'):
                $due = $this->calculateOneTimeDue($data['difficulty']);
                break;
            case('recurring'):
                $due = $this->calculateRecurringDue($data);
                break;
        }

        return $due;
    }

    private function calculateOneTimeDue(string $difficulty)
    {
        $days = match ($difficulty) {
            'basic' => 1,
            'intermediate' => 2,
            'advanced' => 3,
            default => 0,
        };

        return Carbon::now()->addDays($days);
    }

    private function calculateRecurringDue(Collection $data)
    {
        switch($data['repeat']) {
            case('daily'):
                $due = Carbon::now()->addDay();
                break;
            case('weekly'):
                $today = Carbon::now()->dayOfWeekIso;
                $day_of_weeks = $data['day_of_weeks'];
                $filtered_day_of_weeks = array_filter($day_of_weeks, function($day) use ($today) {
                    return $day > $today;
                });
                $next_week_day = !empty($filtered_day_of_weeks) ? min($filtered_day_of_weeks) : min($day_of_weeks);

                $daysMap = [
                    1 => Carbon::MONDAY,
                    2 => Carbon::TUESDAY,
                    3 => Carbon::WEDNESDAY,
                    4 => Carbon::THURSDAY,
                    5 => Carbon::FRIDAY,
                    6 => Carbon::SATURDAY,
                    7 => Carbon::SUNDAY,
                ];

                $due = Carbon::now()->next($daysMap[$next_week_day]);
                break;
            case('monthly'):
                $day_of_month = $data['day_of_month'];
                $today = Carbon::now();

                if ($today->day >= $day_of_month) {
                    $due = $today->addMonth()->day($day_of_month);
                } else {
                    $due = $today->day($day_of_month);
                }
                break;
        }
        list($hour, $minute) = explode(':', $data['time']);
        return $due->setTime($hour, $minute);
    }

    private function createTasks(Request $request, $assignment)
    {
        $tasks = collect();

        foreach ($request->assignees as $assignee) {
            $task = $this->taskService->createTask(collect([
                'assignee' => $assignee['id'],
                'assignment' => $assignment->id,
                'description' => $assignee['description'],
                'difficulty' => $request->difficulty,
                'due' => $request->due,
            ]));

            $tasks->push($task);
        }

        return $tasks;
    }

    private function handleAttachments($files, $assignment)
    {
        foreach ($files as $file) {
            $fileable = [
                'path' => 'public/assignment/' . $assignment->id . '/attachments',
                'type' => 'attachment',
                'fileable_id' => $assignment->id,
                'fileable_type' => Assignment::class,
            ];
            $this->fileService->storeFile($file, $fileable);
        }
    }
}
