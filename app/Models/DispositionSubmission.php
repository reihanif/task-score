<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispositionSubmission extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'disposition_task_id',
        'detail',
        'decider_id',
        'decision',
        'decision_detail',
        'decision_at',
    ];

    protected $casts = [
        'decision_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(DispositionTask::class, 'disposition_task_id');
    }

    public function decider()
    {
        return $this->belongsTo(User::class, 'decider_id');
    }
}