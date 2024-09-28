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
        $assignments = Assignment::with(['recurrence', 'latestTask', 'tasks'])->where('is_recurring', true)->get();
        $now = Carbon::now();
        $total = 0;

        $arr_day_of_weeks = [
            1 => Carbon::MONDAY,
            2 => Carbon::TUESDAY,
            3 => Carbon::WEDNESDAY,
            4 => Carbon::THURSDAY,
            5 => Carbon::FRIDAY,
            6 => Carbon::SATURDAY,
            7 => Carbon::SUNDAY,
        ];

        foreach ($assignments as $assignment) {
            $recurrence = $assignment->recurrence;
            $last_occurrence = $recurrence->occurred_at;
            $last_task_due = $assignment->latestTask->due;

            if($now->format('H:i:00') !== $recurrence->time && $assignment->created_at->day == $now->day) {
                continue;
            }

            if ($recurrence->recurrence_end_date && $now->greaterThanOrEqualTo($recurrence->recurrence_end_date)) {
                continue;
            }

            list($hour, $minute) = explode(':', $recurrence->time->format('H:i'));
            $replicate_assignment = false;

            switch($recurrence->recurrence_type) {
                case('daily'):
                    $next_occurrence = $now->copy()->addDay()->setTime($hour, $minute);

                    $replicate_assignment = $next_occurrence->isWeekday()
                        && (!$last_occurrence || !$last_occurrence->isSameDay($next_occurrence))
                        && !$last_task_due->isSameDay($next_occurrence);

                    $started_date = $now->copy();
                    break;
                case('weekly'):
                    $today = $now->dayOfWeekIso;
                    $next_occurrence_day = min(array_filter($recurrence->day_of_week, fn($day) => $day > $today) ?: $recurrence->day_of_week);
                    $next_occurrence = $now->copy()->next($arr_day_of_weeks[$next_occurrence_day])->setTime($hour, $minute);

                    $replicate_assignment = $now->diffInDays($next_occurrence, false) <= 3
                        && (!$last_occurrence || !$last_occurrence->isSameDay($next_occurrence))
                        && !$last_task_due->isSameDay($next_occurrence);

                    $started_date = $next_occurrence->copy()->subDays(3);
                    break;
                case('monthly'):
                    $next_month = $now->copy()->addMonth()->startOfMonth();
                    $next_occurrence = $next_month->copy()->day(min($recurrence->day_of_month, $next_month->daysInMonth))->setTime($hour, $minute);

                    $replicate_assignment = $now->diffInDays($next_occurrence, false) <= 30
                        && (!$last_occurrence || !$last_occurrence->isSameDay($next_occurrence))
                        && !$last_task_due->isSameDay($next_occurrence);

                    $started_date = $now->diffInDays($next_occurrence, false) <= 3 ? $now->copy() : $next_occurrence->copy()->subDays(3);
                    break;
            }

            if($replicate_assignment) {
                foreach($assignment->tasks as $task) {
                    $newTask = $task->replicate();
                    $newTask->uuid = $task->generateUniqueId();
                    $newTask->started_at = $started_date->toDateTimeString();
                    $newTask->due = $next_occurrence->toDateTimeString();
                    $newTask->save();
                }

                $total++;
                $recurrence->occurred_at = $now->toDateTimeString();
                $recurrence->save();
            }
        }

        if($total > 0) {
            Log::channel('recurrence')->info('generated ' . $total . ' recurring assignments');
        }
    }
}
