<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Notifiable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'closed_at' => 'datetime'
    ];

    /**
     * Get the tasks of the assignments.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the taskmaster of the assignments.
     */
    public function taskmaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'taskmaster_id');
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
     * Check if assignment status is closed.
     */
    public function isClosed()
    {
        return $this->status == 'closed';
    }

    /**
     * Check if assignment childs is resolved.
     */
    // public function childsIsResolved()
    // {
    //     return $this->childs()->whereNotNull('resolved_at');
    // }

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
    // public function hasParent()
    // {
    //     return $this->parent()->exists();
    // }

    /**
     * Check if there is childs of the assignment.
     */
    // public function hasChilds()
    // {
    //     return $this->childs()->exists();
    // }

    /**
     * Check if there is childs of the assignment that unresolved.
     */
    // public function hasUnresolvedChilds()
    // {
    //     return $this->childs()->whereNull('resolved_at')->exists();
    // }

    /**
     * Check if there is siblings of the assignment.
     */
    // public function hasSiblings()
    // {
    //     return $this->whereNotNull('parent_id')->whereNot('parent_id', $this->id)->where('parent_id', $this->parent_id)->exists();
    // }

    // public function hasUnresolvedSiblings()
    // {
    //     return $this->whereNotNull('parent_id')->whereNot('parent_id', $this->id)->where('parent_id', $this->parent_id)->whereNull('resolved_at')->exists();
    // }
}
