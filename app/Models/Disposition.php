<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Disposition extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'no_agenda',
        'status',
        'sender_type',
        'sender_id',
        'sender_name',
        'date_of_letter',
        'date_of_letter_received',
        'subject',
        'description',
        'priority',
        'due_date',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(DispositionTask::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function generateLastNoAgenda() {
        $last = Disposition::orderBy('no_agenda', 'desc')->first();
        if($last == null) {
            return 1;
        }
        return $last->no_agenda + 1;
    }

    
}