<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    /**
     * Get the parent fileable model (user or post).
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
