<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Assignment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecurrenceAssignment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurrence:assignment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Assignment based on recurring assignment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $assignments = Assignment::where('is_recurring', true)->get();
        $now = Carbon::now();
        $total = 0;

        foreach ($assignments as $assignment) {
            $recurrence = $assignment->recurrence;
            $replicate_assignment = false;

            if($now->format('H:i:00') === $recurrence->time && $assignment->created_at->day !== $now->day) {
                if(is_null($recurrence->recurrence_end_date) || $now->lessThan($recurrence->recurrence_end_date)) {
                    list($hour, $minute) = explode(':', $recurrence->time->format('H:i'));

                    switch($recurrence->recurrence_type) {
                        case('daily'):
                            $replicate_assignment = true;
                            break;
                        case('weekly'):
                            if (in_array($now->dayOfWeekIso, $recurrence->day_of_week)) {
                                $replicate_assignment = true;
                            }
                            break;
                        case('monthly'):
                            $next_month = Carbon::now()->addMonth()->startOfMonth();
                            $last_day_of_next_month = $next_month->copy()->endOfMonth();

                            if ($recurrence->day_of_month > $last_day_of_next_month->day) {
                                $next_month_date = $last_day_of_next_month->setTime($hour, $minute);
                            } else {
                                $next_month_date = $next_month->addDays($recurrence->day_of_month - 1)->setTime($hour, $minute);
                            }

                            if (Carbon::now()->diffInDays($next_month_date, false) <= 30 && $assignment->latestTask->created_at->diffInDays($next_month_date, false) > 30 ) {
                                $replicate_assignment = true;
                                $due = $next_month_date;
                            }


                            // if ($now->day == $recurrence->day_of_month) {
                            //     $replicate_assignment = true;
                            // } elseif ($recurrence->day_of_month > $now->endOfMonth()->day && $now->day == $now->endOfMonth()->day) {
                            //     $replicate_assignment = true;
                            // }
                            break;
                    }

                }
            }

            if($replicate_assignment) {
                foreach($assignment->tasks as $task) {
                    $newTask = $task->replicate();
                    $newTask->uuid = $task->generateUniqueId();
                    $newTask->due = $due;
                    $newTask->save();
                }
                $total++;
            }
        }

        if($total > 0) {
            Log::channel('recurrence')->info('generated ' . $total . ' recurring assignments');
        }
    }
}
