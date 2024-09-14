<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Submission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class SubmissionService
{
    public function approve(Collection $data)
    {
        return $this->handleApproval($data, true);
    }

    public function reject(Collection $data)
    {
        return $this->handleApproval($data, false);
    }

    public function rollback($id)
    {
        $submission = Submission::findOrFail($id);
        foreach($submission->attachments as $file) {
            Storage::delete($file->path);
        }
        $submission->delete();

        return $submission;
    }

    public function handleApproval(Collection $data, bool $is_approved)
    {
        $submission = Submission::findOrFail($data['id']);
        $submission->timestamps = false;
        $submission->is_approve = $is_approved;
        $submission->approval_detail = $data['detail'];
        $submission->approver_id = $data['approver_id'];
        $submission->approved_at = Carbon::now()->toDateTimeString();
        $submission->save();

        if ($is_approved) {
            $task = Task::findOrFail($submission->task_id);
            $task->timestamps = false;
            $task->resolved_at = $submission->created_at;
            $task->save();
        }

        return $submission;
    }
}
