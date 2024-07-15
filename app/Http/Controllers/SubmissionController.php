<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AssignmentApproved;
use App\Notifications\AssignmentRejected;
use Illuminate\Support\Facades\Notification;

class SubmissionController extends Controller
{
    /**
     * Approve the specified submission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $submission = Submission::findOrFail($id);
            $submission->timestamps = false;
            $submission->is_approve = (bool) true;
            $submission->approval_detail = 'approved';
            $submission->approved_at = Carbon::now()->toDateTimeString();
            $submission->save();

            $task = Task::findOrFail($submission->task_id);
            $task->timestamps = false;
            $task->resolved_at = $submission->created_at;
            $task->save();

            try {
                $assignees = User::where('id', $task->assignee_id)->get();
                Notification::send($assignees, new AssignmentApproved($task->assignment, $task));
            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to approve submission');
        }

        return redirect()->back()->with('success', 'submission has been approved');
    }

    /**
     * Reject the specified submission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'detail' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $submission = Submission::findOrFail($id);
            $submission->timestamps = false;
            $submission->is_approve = (bool) false;
            $submission->approval_detail = $request->detail;
            $submission->approved_at = Carbon::now()->toDateTimeString();
            $submission->save();

            $assignees = User::where('id', $submission->task->assignee_id)->get();
            Notification::send($assignees, new AssignmentRejected($submission->task->assignment, $submission->task));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to reject submission');
        }

        return redirect()->back()->with('success', 'submission has been rejected');
    }

    /**
     * Display a listing of the submissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $submissions = Submission::latest()->whereHas('task', function ($query) {
            return $query->whereHas('assignment', function ($query) {
                return $query->where('taskmaster_id', Auth::User()->id);
            });
        })->get();

        return view('app.taskscore.assignments.subordinate-submissions', [
            'submissions' => $submissions,
        ]);
    }
}
