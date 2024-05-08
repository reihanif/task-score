<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Permission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'position_id',
        'provider',
        'login_attempts',
        'last_login_at',
        'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime'
    ];

    /**
     * Get the position that owns the user.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the permission associated with the user.
     */
    public function permission(): HasOne
    {
        return $this->hasOne(Permission::class);
    }

    /**
     * Get all the assignments associated with the user as assignee.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'assigned_to');
    }

    /**
     * Get the resolved assignments associated with the user as assignee.
     */
    public function resolved_assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'assigned_to')->where('resolved_at', '!=', null);
    }

    /**
     * Get the unresolved assignments associated with the user as assignee.
     */
    public function unresolved_assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'assigned_to')->where('resolved_at', null);
    }

    /**
     * Get the assignments associated with the user as taskmaster.
     */
    public function created_assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'taskmaster_id');
    }

    /**
     * Check if the user is an assignee.
     */
    public function isAssignee() {
        return $this->assignments()->exists();
    }

    /**
     * Check if the user is a taskmaster.
     */
    public function isTaskmaster() {
        return $this->created_assignments()->exists();
    }
}
