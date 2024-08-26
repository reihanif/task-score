<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurrencePattern extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
