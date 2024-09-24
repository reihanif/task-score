<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Assignment extends Model
{
    use HasFactory, HasUuids, Notifiable, LogsActivity;

    protected $fillable = [
        'taskmaster_id',
        'type',
        'subject',
        'description',
        'is_recurring',
        'status',
        'creator_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'closed_at' => 'datetime'
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
            'creator_id'
        ]);
    }

    /**
     * Relationships
     */

    /** Tasks inside assignment */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /** Get latest task of the assignment. */
    public function latestTask(): HasOne
    {
        return $this->hasOne(Task::class)->latestOfMany();
    }

    /** Taskmaster of the assignment. */
    public function taskmaster(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'taskmaster_id');
    }

    /** Creator of the assignment. */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /** Assignees of the assignment. */
    public function assignees(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Task::class, 'assignment_id', 'id', 'id', 'assignee_id');
    }

    /** Resolution's file. */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->where('files.type', 'resolution');
    }

    /** Attachments file. */
    public function attachments(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->where('files.type', 'attachment');
    }

    /** Recurrence pattern. */
    public function recurrence()
    {
        return $this->hasOne(RecurrencePattern::class);
    }

    /**
     * Accessors
     */

    /** Creator Name */
    public function getCreatedByAttribute()
    {
        return $this->creator->name;
    }

    /**
     * Scopes
     */

    /** Scope a query to only include closed assignments */
    public function scopeWhereClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /** Scope a query to only include open assignments */
    public function scopeWhereOpen($query)
    {
        return $query->where('status', 'open');
    }
}
