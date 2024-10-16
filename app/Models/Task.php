<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = [
        'assignee_id',
        'assignment_id',
        'description',
        'difficulty',
        'due',
        'resolved_at',
        'started_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due' => 'datetime',
        'resolved_at' => 'datetime',
        'started_at' => 'datetime'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'taskmaster_id',
            'type',
            'subject',
            'description',
            'is_recurring',
            'status',
            'creator_id',
            'started_at',
            'due'
        ]);
    }

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
     * Get latest time_extension request of the tasks.
     */
    public function latestTimeExtension(): HasOne
    {
        return $this->hasOne(TimeExtension::class)->latestOfMany();
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
     * Query Scopes
     */
    public function scopeResolved(Builder $query)
    {
        return $query->whereNotNull('resolved_at');
    }

    public function scopeUnresolved(Builder $query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeWithAssignment(Builder $query)
    {
        return $query->whereHas('assignment');
    }

    public function scopePendingApproval(Builder $query)
    {
        return $query->whereHas('latestSubmission', function ($query) {
            $query->whereNull('is_approve');
        });
    }

    public function scopeDisapproved(Builder $query)
    {
        return $query->whereHas('latestSubmission', function ($query) {
            $query->where('is_approve', false);
        });
    }

    public function scopeWithoutSubmissions(Builder $query)
    {
        return $query->doesntHave('submissions');
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
        return $this->latestSubmission?->isWaitingApproval();
    }

    /**
     * Check if task has time extension request.
     */
    public function hasTimeExtensionRequest()
    {
        return !$this->time_extensions()->whereNull('approved_at')->get()->isEmpty();
    }

    /**
     * Get time extension request total.
     */
    public function getTotalTimeExtensionAttribute()
    {
        return $this->time_extensions()->whereNull('approved_at')->count();
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
     * Create score attribute.
     */
    public function getScoreAttribute()
    {
        return $this->score();
    }

    /**
     * Create submission status attribute.
     */
    public function getSubmissionStatusAttribute()
    {
        if ($this->latestSubmission?->isWaitingApproval()) {
            $status = 'Waiting for approval';
        } elseif ($this->latestSubmission?->isApproved()) {
            $status = 'Resolved';
        } elseif ($this->latestSubmission?->isRejected()) {
            $status = 'Rejected';
        } else {
            $status = '-';
        }
        return Str::of($status)->toHtmlString;
    }

    /**
     * Create time extension status attribute.
     */
    public function getTimeExtensionStatusAttribute()
    {
        if ($this->latestTimeExtension?->isWaitingApproval()) {
            $status = 'Waiting for approval';
        } elseif ($this->latestTimeExtension?->isApproved()) {
            $status = 'Approved';
        } elseif ($this->latestTimeExtension?->isRejected()) {
            $status = 'Rejected';
        } else {
            $status = '-';
        }
        return $status;
    }

    /**
     * Calculate task score.
     */
    public function score()
    {
        if (!$this->isResolved()) {
            return;
        }

        $seconds_before_due = $this->resolved_at->diffInSeconds($this->due, false);

        return number_format($this->calculate_score($seconds_before_due), 2, '.', '');
    }

    public function possibleScore()
    {
        $seconds_before_due = $this->latestSubmission->created_at->diffInSeconds($this->due, false);

        return number_format($this->calculate_score($seconds_before_due), 2, '.', '');
    }

    private function calculate_score($seconds_before_due)
    {
        // Jika resolved_at lebih dari 3 jam (10800 detik) sebelum due
        if ($seconds_before_due > 10800) {
            $score = 110;
        }
        // Jika resolved_at dalam rentang 0 hingga 3 jam (10800 detik) sebelum due
        elseif ($seconds_before_due > 0 && $seconds_before_due <= 10800) {
            // Hitung penurunan score secara linear dari 110 hingga 100
            $score = 110 - ($seconds_before_due * 10 / 10800);
        }
        // Jika resolved_at melebihi due
        else {
            $seconds_after_due = abs($seconds_before_due); // Detik setelah due
            // Jika lebih dari 3 hari (259200 detik) setelah due, score minimal adalah 60
            if ($seconds_after_due >= 259200) {
                $score = 60;
            } else {
                // Hitung penurunan score secara linear dari 100 hingga 60
                $score = 100 - (($seconds_after_due * 40) / 259200);
            }
        }

        return $score;
    }
}
