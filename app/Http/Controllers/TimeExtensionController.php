<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TimeExtension;
use App\Notifications\TimeExtensionRequest;
use App\Notifications\TimeExtensionApproved;
use App\Notifications\TimeExtensionRejected;
use Illuminate\Support\Facades\Notification;

class TimeExtensionController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'justification' => 'required',
        ]);

        $task = Task::findOrFail($id);
        $assignment = $task->assignment;

        $extension_request = new TimeExtension();
        $extension_request->task_id = $task->id;
        $extension_request->body = $request->justification;
        $extension_request->save();

        $taskmaster = User::where('id', $assignment->taskmaster_id)->get();
        Notification::send($taskmaster, new TimeExtensionRequest($assignment, $task));

        return redirect()->back()->with('success', 'Time extension request sent');
    }

    public function reject(Request $request, $id)
    {
        $extension_request = TimeExtension::findOrFail($id);
        $extension_request->is_approve = (bool) false;
        $extension_request->approved_at = Carbon::now()->toDateTimeString();
        $extension_request->save();

        $task = $extension_request->task;
        $assignment = $task->assignment;

        $assignees = User::where('id', $task->assignee_id)->get();
        Notification::send($assignees, new TimeExtensionRejected($assignment, $task));

        return redirect()->back()->with('success', 'Time extension request rejected');
    }

    public function approve(Request $request, $id)
    {
        $extension_request = TimeExtension::findOrFail($id);
        $extension_request->is_approve = (bool) true;
        $extension_request->approved_at = Carbon::now()->toDateTimeString();
        $extension_request->save();

        $task = $extension_request->task;
        if ($request->timetable) {
            $task->due = $task->due->addMinutes($request->timetable);
        } elseif ($request->date && $request->time) {
            $date = $request->date;
            $time = $request->time;
            $task->due = Carbon::parse("$date $time");
        }
        $task->save();

        $assignees = User::where('id', $task->assignee_id)->get();
        Notification::send($assignees, new TimeExtensionApproved($task->assignment, $task));

        return redirect()->back()->with('success', 'Time extension request approved');
    }
}
