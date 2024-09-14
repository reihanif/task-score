<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory, HasUuids;

    /** * The attributes that should be cast. */
    protected $casts = [
        'approved_at' => 'datetime'
    ];

    /**
     * Relationships
     */

    /** Get the task of the submission. */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /** Get the submission's attachments (files). */
    public function attachments(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /** Get the approver of the submission. */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Scopes
     */

    /** Scope a query to only include approved submissions. */
    public function scopeApproved($query)
    {
        return $query->where('is_approve', true);
    }

    /** Scope a query to only include rejected submissions. */
    public function scopeRejected($query)
    {
        return $query->where('is_approve', false)->whereNotNull('approval_detail');
    }

    /** Scope a query to only include submissions waiting for approval. */
    public function scopeWaitingApproval($query)
    {
        return $query->whereNull('approval_detail')->whereNull('is_approve');
    }

    /**
     * Custom
     */

    /** Check if the submission is approved. */
    public function isApproved(): bool
    {
        return $this->is_approve == true;
    }

    /** Check if the submission is rejected. */
    public function isRejected(): bool
    {
        return $this->is_approve == false && $this->approval_detail !== null;
    }

    /** Check if the submission is waiting for approval. */
    public function isWaitingApproval(): bool
    {
        return $this->is_approve == null && $this->approval_detail == null;
    }
}
