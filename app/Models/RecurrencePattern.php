<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurrencePattern extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'day_of_week' => 'array',
        'time' => 'datetime',
        'recurrence_end_date' => 'datetime'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Create pattern attribute.
     */
    public function getPatternAttribute()
    {
        switch($this->recurrence_type) {
            case('daily'):
                $pattern = ucwords($this->recurrence_type) . ' at ' . $this->time->format('H:i');
                break;
            case('weekly'):
                $dayNumbers = $this->day_of_week;
                $dayNames = [
                    "0" => "Sunday",
                    "1" => "Monday",
                    "2" => "Tuesday",
                    "3" => "Wednesday",
                    "4" => "Thursday",
                    "5" => "Friday",
                    "6" => "Saturday",
                ];

                $dayNamesArray = array_map(function ($dayNumber) use ($dayNames) {
                    return $dayNames[$dayNumber];
                }, $dayNumbers);

                $dayNamesString = implode(', ', array_slice($dayNamesArray, 0, -1))
                                . (count($dayNamesArray) > 1 ? ' and ' : '')
                                . end($dayNamesArray);

                $pattern = ucwords($this->recurrence_type) . ' in ' . $dayNamesString . ' at ' . $this->time->format('H:i');
                break;
            case('monthly'):
                $pattern = ucwords($this->recurrence_type) . ' in day ' . $this->day_of_month . ' at ' . $this->time->format('H:i');
                break;
        }

        if(!is_null($this->recurrence_end_date)) {
            $pattern .= ' until ' . $this->recurrence_end_date->format('d F Y');
        }

        return $pattern;
    }
}
