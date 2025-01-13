<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function message(User $user, User $recipient)
    {
        return $user->isFriendWith($recipient);
    }
}

