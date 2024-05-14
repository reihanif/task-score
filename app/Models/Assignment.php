<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Assignment extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Notifiable;

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

        return number_format(($this->calculate_score($realization, $target)), 2, '.', '');
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
