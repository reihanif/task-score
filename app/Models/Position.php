<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get the users for the position.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the superior of the positions.
     */
    public function superior(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }

    /**
     * Get the direct subordinates of the positions.
     */
    public function direct_subordinates(): HasMany
    {
        return $this->hasMany(Position::class, 'parent_id', 'id');
    }

    // /**
    //  * Get the subordinates of the positions.
    //  */
    // public function subordinates(): HasMany
    // {
    //     return $this->hasMany(Position::class, 'path', 'id');
    // }

    /**
     * Get the departments of the position.
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class)->using(DepartmentPosition::class)->withPivot(['added_at', 'adder_id'])->orderBy('name');
    }
}
