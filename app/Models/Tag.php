<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function issues() : MorphToMany
    {
        return $this->morphedByMany(Issue::class, 'taggable');
    }
}
