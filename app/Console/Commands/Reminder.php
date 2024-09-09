<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Notifications\AssigneeReminder;
use App\Notifications\AssigneeReminderOverdue;
use App\Notifications\TaskmasterApprovalReminder;
use App\Notifications\TaskmasterReminderUpcoming;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled notifications to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $users = User::all();

        foreach ($users as $user) {
            $tasks = $user->unresolvedAssignments;
            $unapproved_tasks = $user->delegatedTasks()->whereHas('latestSubmission', function($query) {
                return $query->whereNull('is_approve');
            })->get();
            $total = 0;

            foreach ($tasks as $task) {
                $notify = false;
                $notify_taskmaster = false;
                $overdue = false;

                if ($task->due->isFuture()) {
                    $task->assignment;
                    if ($task->due->diffInHours($now) < 25) {
                        switch ($now->format('H:i')) {
                            case '07:30':
                                $notify = true;
                                $notify_taskmaster = true;
                                break;
                            case '13:00':
                                $notify = true;
                                $notify_taskmaster = true;
                                break;
                            case '15:00':
                                $notify = true;
                                $notify_taskmaster = true;
                                break;
                        }
                    }
                }

                if ($task->due->isPast()) {
                    $overdue = true;
                    switch ($now->format('H:i')) {
                        case '11:00':
                            $notify = true;
                            break;
                    }
                }

                if ($notify) {
                    if ($overdue) {
                        $user->notify(new AssigneeReminderOverdue($task));
                    } else {
                        $user->notify(new AssigneeReminder($task));
                    }

                    $total++;
                }

                if ($notify_taskmaster) {
                    $task->assignment->taskmaster->notify(new TaskmasterReminderUpcoming($task));
                }
            }

            foreach ($unapproved_tasks as $unapproved_task) {
                $notify = false;

                switch ($now->format('H:i')) {
                    case '07:30':
                        $notify = true;
                        break;
                    case '13:30':
                        $notify = true;
                        break;
                }

                if ($notify) {
                    $user->notify(new TaskmasterApprovalReminder($unapproved_task));

                    $total++;
                }
            }

            if($total > 0) {
                Log::channel('notify:reminder')->info($total . ' notifications sent to ' . $user->email);
            }
        }
    }
}
