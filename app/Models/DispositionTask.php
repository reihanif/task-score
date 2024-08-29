<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispositionTask extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'disposition_id',
        'assignee_id',
        'task',
        'status',
        'detail',
        'due_date',
        'parent_task_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function disposition()
    {
        return $this->belongsTo(Disposition::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function parentTask()
    {
        return $this->belongsTo(DispositionTask::class, 'parent_task_id');
    }

    public function childTasks()
    {
        return $this->hasMany(DispositionTask::class, 'parent_task_id');
    }

    public function submissions()
    {
        return $this->hasMany(DispositionSubmission::class);
    }
}