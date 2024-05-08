<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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
     * Get the child of the assignments.
     */
    public function childs(): HasMany
    {
        return $this->hasMany(Assignment::class, 'parent_id', 'id');
    }

    /**
     * Get the assignee of the assignments.
     */
    public function assignee(): BelongsTo
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
     * Get the assignee of the assignments.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the resolution's file.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->where('files.type', 'resolution');
    }

    /**
     * Get the assignment's file.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->where('files.type', 'attachment');
    }

    /**
     * Check if assignment is resolved.
     */
    public function isResolved()
    {
        return $this->resolved_at !== null;
    }

    /**
     * Check if assignment childs is resolved.
     */
    public function childsIsResolved()
    {
        return $this->childs()->whereNotNull('resolved_at');
    }

    /**
     * Check if assignment status is open.
     */
    public function isOpen()
    {
        return $this->status == 'open';
    }

    /**
     * Check if there is parent of the assignment.
     */
    public function hasParent()
    {
        return $this->parent()->exists();
    }

    /**
     * Check if there is childs of the assignment.
     */
    public function hasChilds()
    {
        return $this->childs()->exists();
    }

    /**
     * Check if there is childs of the assignment that unresolved.
     */
    public function hasUnresolvedChilds()
    {
        return $this->childs()->whereNull('resolved_at')->exists();
    }

    /**
     * Check if there is siblings of the assignment.
     */
    public function hasSiblings()
    {
        return $this->whereNotNull('parent_id')->whereNot('parent_id', $this->id)->where('parent_id', $this->parent_id)->exists();
    }

    public function hasUnresolvedSiblings()
    {
        return $this->whereNotNull('parent_id')->whereNot('parent_id', $this->id)->where('parent_id', $this->parent_id)->whereNull('resolved_at')->exists();
    }

    /**
     * Return assignment score.
     */
    public function score()
    {
        $interval = $this->created_at->diff($this->resolved_at);
        $due_interval = $this->created_at->diff($this->due);

        $resolved =
            $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

        $due =
            $due_interval->days * 86400 +
            $due_interval->h * 3600 +
            $due_interval->i * 60 +
            $due_interval->s;
        $score = ($due / $resolved) * 100;

        return round($score);
    }
}
