<?php

namespace App\Models;

use cwsupport\Admin\Models\User as CwsupportUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends CwsupportUser
{
    public function issues() : HasMany
    {
        return $this->hasMany(Issue::class);
    }
}
