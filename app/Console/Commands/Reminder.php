<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\AssigneeReminder;

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
            $tasks = $user->unresolvedAssignments();
            $total = 0;

            foreach ($tasks as $task) {
                $notify = false;
                if ($task->due->isFuture()) {
                    $task->assignment;
                    if ($task->due->diffInHours($now) < 25) {
                        switch ($now->format('H:i')) {
                            case '07:30':
                                $notify = true;
                                break;
                            case '13:00':
                                $notify = true;
                                break;
                            case '15:00':
                                $notify = true;
                                break;
                        }
                    }
                }

                if ($task->due->isPast()) {
                    switch ($now->format('H:i')) {
                        case '11:00':
                            $notify = true;
                            break;
                    }
                }

                if ($notify) {
                    $user->notify(new AssigneeReminder($task->assignment, $task));
                    $total++;
                }
            }

            if($total > 0) {
                info($total . ' notifications sent to ' . $user->email);
            }
        }
    }
}
