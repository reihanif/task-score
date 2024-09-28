<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskService
{

    public function createTask(Collection $data)
    {
        $task = new Task();
        $task->uuid = $task->generateUniqueId();
        $task->assignee_id = $data['assignee'];
        $task->assignment_id = $data['assignment'];
        $task->description = $data['description'];
        $task->difficulty = $data['difficulty'];
        $task->due = $data['due'];
        $task->started_at = $data['started_at'] ?? Carbon::now()->toDateTimeString();
        $task->save();

        return $task;
    }
}
