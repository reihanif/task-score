<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteDispositionRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['disposition_id', 'reason', 'requested_by', 'status', 'decision_at'];

    public function disposition()
    {
        return $this->belongsTo(Disposition::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    
}