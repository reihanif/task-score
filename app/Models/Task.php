<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due' => 'datetime'
    ];

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
     * Check if task is resolved.
     */
    public function isResolved()
    {
        return $this->resolved_at !== null;
    }

        /**
     * Return task score.
     */
    public function score()
    {
        if (!$this->isResolved()) {
            return 0;
        }

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
