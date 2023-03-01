<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Events\Events\VerifiedEmailEvent;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Auth\Events\Verified;

class MarkEmailAsVerifiedTask extends Task
{
    public function run(User $user): void
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new VerifiedEmailEvent($user->getKey()));
            event(new Verified($user));
        }
    }
}
