<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TimeExtension;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TimeExtensions\TimeExtensionRequest;
use App\Notifications\TimeExtensions\TimeExtensionApproved;
use App\Notifications\TimeExtensions\TimeExtensionRejected;

class TimeExtensionController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'justification' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $task = Task::findOrFail($id);

            $extension_request = new TimeExtension();
            $extension_request->task_id = $task->id;
            $extension_request->body = $request->justification;
            $extension_request->save();

            $task->assignee->notify(new TimeExtensionRequest($task));
            Notification::send($task->assignment->taskmaster->permitted_users, new TimeExtensionRequest($task));
            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to send time extension request');
        }

        return redirect()->back()->with('success', 'Time extension request sent');
    }

    public function reject(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $extension_request = TimeExtension::findOrFail($id);
            $extension_request->is_approve = false;
            $extension_request->approver_id = auth()->id();
            $extension_request->approved_at = Carbon::now()->toDateTimeString();
            $extension_request->save();

            $task = $extension_request->task;

            $task->assignee->notify(new TimeExtensionRejected($task));
            Notification::send($task->assignment->taskmaster->permitted_users, new TimeExtensionRejected($task));
            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to reject time extension request');
        }

        return redirect()->back()->with('success', 'Time extension request rejected');
    }

    public function approve(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $extension_request = TimeExtension::findOrFail($id);
            $extension_request->is_approve = true;
            $extension_request->approver_id = auth()->id();
            $extension_request->approved_at = Carbon::now()->toDateTimeString();
            $extension_request->save();

            $task = $extension_request->task;
            if ($request->timetable && $task->due->isFuture()) {
                $task->due = $task->due->addMinutes($request->timetable);
            }

            if ($request->timetable && $task->due->isPast()) {
                $task->due = $extension_request->created_at->addMinutes($request->timetable);
            }

            if ($request->date && $request->time) {
                $date = $request->date;
                $time = $request->time;
                $task->due = Carbon::parse("$date $time");
            }
            $task->save();

            $task->assignee->notify(new TimeExtensionApproved($task));
            Notification::send($task->assignment->taskmaster->permitted_users, new TimeExtensionApproved($task));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to send time extension request');
        }

        return redirect()->back()->with('success', 'Time extension request approved');
    }
}
