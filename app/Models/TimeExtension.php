<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeExtension extends Model
{
    use HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime'
    ];


    /**
     * Get the task of the time extensions.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Check if the time extension request is approved.
     */
    public function isApproved()
    {
        return $this->is_approve == true && $this->approved_at !== null;;
    }

    /**
     * Check if the time extension request is rejected.
     */
    public function isNotApproved()
    {
        return $this->is_approve == false && $this->approved_at !== null;;
    }

    /**
     * Check if the time extension request is wait for approval.
     */
    public function isWaitingApproval()
    {
        return $this->is_approve == null && $this->approved_at == null;
    }
}
