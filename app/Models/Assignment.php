<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime'
    ];

    /**
     * Get the parent of the assignments.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'parent_id');
    }

    /**
     * Get the assignee of the assignments.
     */
    public function asignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the taskmaster of the assignments.
     */
    public function taskmaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'taskmaster_id');
    }

    /**
     * Get the assignment's file.
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
