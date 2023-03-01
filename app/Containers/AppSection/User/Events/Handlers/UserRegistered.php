<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Handlers;

use App\Containers\AppSection\User\Mails\UserRegisteredMail;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class UserRegistered
{
    /**
     * Handle the Event. (Single Listener Implementation).
     */
    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;
        Mail::send((new UserRegisteredMail($user))->onQueue('email'));
    }
}
