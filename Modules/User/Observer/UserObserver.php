<?php

namespace Modules\User\Observer;

use Modules\User\Models\User;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->assignRole('client');
    }
}