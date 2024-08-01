<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due' => 'datetime',
        'resolved_at' => 'datetime'
    ];

    /**
     * Get the submission of the tasks.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get the time_extensions of the tasks.
     */
    public function time_extensions(): HasMany
    {
        return $this->hasMany(TimeExtension::class);
    }

    /**
     * Get latest submission of the tasks.
     */
    public function latestSubmission(): HasOne
    {
        return $this->hasOne(Submission::class)->latestOfMany();
    }

    /**
     * Get the assignee of the tasks.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get the assignment of the tasks.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    /**
     * Get the task's comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Check if task is resolved.
     */
    public function isResolved()
    {
        return $this->resolved_at !== null;
    }

    /**
     * Check if task is submitted.
     */
    public function isSubmitted()
    {
        return $this->submissions()->whereNull('approval_detail')->get()->isEmpty();
    }

    /**
     * Check if task has time extension request.
     */
    public function hasTimeExtensionRequest()
    {
        return !$this->time_extensions()->whereNull('approved_at')->get()->isEmpty();
    }

    /**
     * Get time extension request.
     */
    public function getTimeExtensionRequest()
    {
        return $this->time_extensions()->whereNull('approved_at')->get();
    }

    /**
     * Check if task has submissions.
     */
    public function hasSubmissions()
    {
        return $this->submissions()->exists();
    }

    /**
     * Create UUID for ticket
     */
    public function generateUniqueId($prefix = '#', $length = 6)
    {
        // Get the last record's UUID and extract the numeric part
        $lastRecord = $this->orderBy('uuid', 'desc')->first();
        $lastIdNumber = $lastRecord ? intval(substr($lastRecord->uuid, strlen($prefix))) : 0;

        // Increment the number for the new UUID
        $newIdNumber = $lastIdNumber + 1;

        // Pad the number with leading zeros
        $uuid = $prefix . str_pad($newIdNumber, $length, '0', STR_PAD_LEFT);

        return $uuid;
    }

    /**
     * Calculate task score.
     */
    public function score()
    {
        if (!$this->isResolved()) {
            return 0;
        }

        $realization_interval = $this->created_at->diff($this->resolved_at);
        $target_interval = $this->created_at->diff($this->due);

                $realization =
                    $realization_interval->days * 86400 +
                    $realization_interval->h * 3600 +
                    $realization_interval->i * 60 +
                    $realization_interval->s;

                $target =
                    $target_interval->days * 86400 +
                    $target_interval->h * 3600 +
                    $target_interval->i * 60 +
                    $target_interval->s;

        return number_format(($this->calculate_score($realization, $target) < 0 ? 0 : $this->calculate_score($realization, $target)), 2, '.', '');
    }

    private function calculate_score(float $realization, float $target)
    {
        if ($realization >= $target) {
            return (1 - (($realization - $target) / $target)) * 100;
        }
        elseif ($realization <= ($target * 1.1)) {
            return 110;
        } else {
           return (100 + (($realization - $target) * (110 - 100) / ($realization * 1.1) - $target));
        }
    }
}
