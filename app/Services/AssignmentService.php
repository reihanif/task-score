<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Assignment;
use App\Models\RecurrencePattern;
use Illuminate\Support\Collection;

class AssignmentService
{

    public function createAssignment(Collection $data)
    {
        $assignment = new Assignment();
        $assignment->taskmaster_id = $data['taskmaster'];
        $assignment->creator_id = $data['creator'];
        $assignment->type = $data['type'];
        $assignment->subject = $data['subject'];
        $assignment->description = $data['description'];
        $assignment->is_recurring = $data->has('is_recurring') ? true : false;
        $assignment->is_draft = false;
        $assignment->save();

        // Handle Recurrence
        if ($data['ocurrence_type'] == 'recurring') {
            $this->createRecurrencePattern($data, $assignment);
        }

        return $assignment;
    }

    public function publish($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->is_draft = false;
        $assignment->save();

        return $assignment;
    }

    private function createRecurrencePattern($data, $assignment)
    {
        $recurrence_end_date = $data->has('recurrence_end_date') ? new Carbon($data['recurrence_end_date']) : null;
        RecurrencePattern::create([
            'assignment_id' => $assignment->id,
            'recurrence_type' => $data['repeat'],
            'day_of_week' => $data['day_of_weeks'] ?? null,
            'day_of_month' => $data['day_of_month'] ?? null,
            'time' => $data['time'] ?? null,
            'recurrence_end_date' => $recurrence_end_date
        ]);
    }
}
