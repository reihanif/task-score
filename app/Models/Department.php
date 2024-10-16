<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Department extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the positions of the department.
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class)->using(DepartmentPosition::class)->withPivot(['added_at', 'adder_id'])->orderBy('name');
    }

    public function getUsersAttribute(): Collection
    {
        return $this->positions->flatMap(function ($position) {
            return $position->users;
        })->unique('id');
    }

    public function getUsersCountAttribute()
    {
        return $this->users->count();
    }

    public function getAssignmentsCountAttribute()
    {
        $tasks = $this->positions->flatMap(function ($position) {
            return $position->users->flatMap(function ($user) {
                return $user->tasks;
            });
        });

        return $tasks->count();
    }

    public function getResolvedAssignmentsCountAttribute()
    {
        $tasks = $this->positions->flatMap(function ($position) {
            return $position->users->flatMap(function ($user) {
                return $user->resolvedAssignments;
            });
        });

        return $tasks->count();
    }

    public function getPendingAssignmentsCountAttribute()
    {
        $tasks = $this->positions->flatMap(function ($position) {
            return $position->users->flatMap(function ($user) {
                return $user->pendingAssignments;
            });
        });

        return $tasks->count();
    }

    public function getUnresolvedAssignmentsCountAttribute()
    {
        $tasks = $this->positions->flatMap(function ($position) {
            return $position->users->flatMap(function ($user) {
                return $user->unresolvedAssignments;
            });
        });

        return $tasks->count();
    }
}
