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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime'
    ];

    /**
     * Get the task of the tasks.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the submission's file.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Check if the submission is approved.
     */
    public function isApproved()
    {
        return $this->is_approve == true;
    }

    /**
     * Check if the submission is rejected.
     */
    public function isNotApproved()
    {
        return $this->approval_detail !== null && $this->is_approve == false;
    }

    /**
     * Check if the submission is wait for approval.
     */
    public function isWaitingApproval()
    {
        return $this->approval_detail == null && $this->is_approve == false;
    }
}
