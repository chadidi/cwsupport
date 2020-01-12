<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    public function list(User $user): bool
    {
        return $user->is_admin;
    }

    public function show(User $user, Issue $issue): bool
    {
        return $user->is_admin || $user->id == $issue->user_id;
    }

    public function close(User $user, Issue $issue): bool
    {
        return $user->is_admin || $user->id == $issue->user_id;
    }

    public function update(User $user, Issue $issue): bool
    {
        return $user->is_admin;
    }
}
