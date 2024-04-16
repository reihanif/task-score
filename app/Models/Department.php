<?php

namespace App\Models;

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

    /**
     * Get all of the users for the project.
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Position::class);
    }
}
