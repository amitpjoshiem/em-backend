<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Events\Observers;

use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function saved(User $user): void
    {
        Cache::put(sprintf('user.%s', $user->getKey()), $user, 60);
    }

    public function deleted(User $user): void
    {
        Cache::forget(sprintf('user.%s', $user->getKey()));
    }

    public function restored(User $user): void
    {
        Cache::put(sprintf('user.%s', $user->getKey()), $user, 60);
    }

    public function retrieved(User $user): void
    {
        Cache::add(sprintf('user.%s', $user->getKey()), $user, 60);
    }
}
