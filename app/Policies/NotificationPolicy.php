<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Notification $notification)
    {
        return $user->id === $notification->user_id;
    }
}

