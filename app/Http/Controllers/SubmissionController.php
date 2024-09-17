<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Assignments\AssignmentApproved;
use App\Notifications\Assignments\AssignmentRejected;
use App\Services\SubmissionService;

class SubmissionController extends Controller
{
    protected $submissionService;

    public function __construct(SubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    /**
     * Approve the specified submission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'detail' => 'string|nullable'
        ]);
        $request->merge([
            'id' => $id,
            'approver_id' => auth()->id(),
        ]);

        DB::beginTransaction();

        try {
            $submission = $this->submissionService->approve(collect($request));

            $submission->task->assignee->notify(new AssignmentApproved($submission->task));
            Notification::send($submission->task->assignment->taskmaster->permitted_users, new AssignmentApproved($submission->task));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to approve submission');
        }

        return redirect()->back()->with('success', 'Submission has been approved');
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
            'detail' => 'required|string'
        ]);
        $request->merge([
            'id' => $id,
            'approver_id' => auth()->id(),
        ]);

        DB::beginTransaction();

        try {
            $submission = $this->submissionService->reject(collect($request));

            $submission->task->assignee->notify(new AssignmentRejected($submission->task));
            Notification::send($submission->task->assignment->taskmaster->permitted_users, new AssignmentRejected($submission->task));

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Failed to reject submission');
        }

        return redirect()->back()->with('success', 'Submission has been rejected');
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
                return $query->where('creator_id', auth()->id());
            });
        })->get();

        return view('app.taskscore.assignments.subordinate-submissions', [
            'submissions' => $submissions,
        ]);
    }

    /**
     * Remove the specified submission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rollback($id)
    {
        DB::beginTransaction();

        try {
            $this->submissionService->rollback($id);

            // Execute database data remove
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->withErrors('Rollback submission failed');
        }

        return redirect()->back()->with('success', 'Submission has been canceled and rolled back');
    }
}
