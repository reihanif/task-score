<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use stdClass;
use App\Models\Permission;
use App\Models\TimeExtension;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
     * Get the permissions associated with the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if user has specified permission.
     */
    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Assign permission to user.
     */
    public function assignPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }
        $this->permissions()->attach($permission);
    }

    /**
     * Unassign permission from user.
     */
    public function unassignPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission);
    }

    /**
     * Get all the tasks associated with the user as assignee.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    /**
     * Get all the tasks associated with the user as taskmaster.
     */
    public function delegatedTasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Assignment::class, 'taskmaster_id', 'assignment_id', 'id', 'id');
    }

    /**
     * Get all the assignments associated with the user as assignee.
     */
    public function assignments(): HasManyThrough
    {
        return $this->hasManyThrough(Assignment::class, Task::class, 'assignee_id', 'id', 'id', 'assignment_id');
    }

    /**
     * Get the resolved assignments associated with the user as assignee.
     */
    public function resolvedAssignments(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id')->where('resolved_at', '!=', null)->whereHas('assignment');
    }

    /**
     * Get the unresolved assignments associated with the user as assignee.
     */
    public function unresolvedAssignments()
    {
        return collect([
            Task::where('resolved_at', null)->whereHas('assignment')->where('assignee_id', $this->id)->doesntHave('submissions')->get(),
            Task::where('resolved_at', null)->whereHas('assignment')->where('assignee_id', $this->id)->whereHas('latestSubmission', function($query) {
                return $query->where('is_approve', false);
            })->get()
        ])->flatten(1)->sortBy('created_at');
    }

    /**
     * Get the pending assignments associated with the user as assignee.
     */
    public function pendingAssignments()
    {
        return Task::where('resolved_at', null)->where('assignee_id', $this->id)->whereHas('latestSubmission', function($query) {
            return $query->whereNull('is_approve');
        })->whereHas('assignment')->get();
    }

    /**
     * Count the waiting approval submission
     */
    public function getWaitingApprovalSubmissionAttribute()
    {
        return Submission::whereNull('approval_detail')->whereNull('is_approve')->whereHas('task', function($query) {
            return $query->whereHas('assignment', function($sub_query) {
                return $sub_query->where('taskmaster_id', $this->id);
            });
        })->count();
    }

    /**
     * Count the waiting approval time extension
     */
    public function getWaitingApprovalTimeExtensionAttribute()
    {
        return TimeExtension::whereNull('approved_at')->whereNull('is_approve')->whereHas('task', function($query) {
            return $query->whereHas('assignment', function($sub_query) {
                return $sub_query->where('taskmaster_id', $this->id);
            });
        })->count();
    }

    /**
     * Count the waiting approval of submission & time extension
     */
    public function getWaitingApprovalRequestAttribute()
    {
        return $this->waiting_approval_submission + $this->waiting_approval_time_extension;
    }

    /**
     * Get the user subordinates
     */
    public function subordinates()
    {
        if($this->position()->exists()) {
            return User::where('id', '!=', $this->id)->whereNotNull('position_id')->whereHas('position', function ($query) {
                $query->where('path', 'LIKE', '%' . $this->position?->id . '%');
            })->get()->sortBy('name');
        } elseif($this->role == 'superadmin') {
            return User::all()->except($this->id);
        } else {
            return [];
        }
    }

    /**
     * Get the assignments associated with the user as taskmaster.
     */
    public function created_assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'taskmaster_id');
    }

    /**
     * Check if the user is an assignee of specific assignment.
     */
    public function isAssignee($assignment_id)
    {
        return Assignment::findOrFail($assignment_id)->tasks->pluck('assignee_id')->contains($this->id);
    }

    /**
     * Check if the user is an assignee of specific task.
     */
    public function isTaskAssignee($task_id)
    {
        return !!Task::where('assignee_id', $this->id)->find($task_id);
    }

    /**
     * Check if the user is a taskmaster of specific assignment.
     */
    public function isTaskmaster($assignment_id)
    {
        return $this->id == Assignment::select('taskmaster_id')->findOrFail($assignment_id)->taskmaster_id;
    }

    /**
     * Check if the user role is superadmin
     */
    public function isSuperadmin()
    {
        return $this->role == 'superadmin';
    }

    /**
     * Check if the user is involved (has access) with a specific assignment
     */
    public function isInvolved($assignment_id = null)
    {
        $is_involved = false;
        $assignment = Assignment::findOrFail($assignment_id);
        if ($assignment->taskmaster->position_id == $this->position_id) {
            $is_involved = true;
        }

        return $is_involved;
    }
}
