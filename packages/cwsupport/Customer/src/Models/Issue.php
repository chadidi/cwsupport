<?php

namespace cwsupport\Customer\Models;

use cwsupport\Customer\Traits\HasTags;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasTags;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'tags',
    ];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
