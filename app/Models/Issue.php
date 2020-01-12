<?php

namespace App\Models;

use App\Traits\HasTags;
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
        return $this->belongsTo(User::class);
    }
}
