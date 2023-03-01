<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Mails\CreatePasswordEmail;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\CreatePasswordNotification;
use App\Containers\AppSection\User\Tasks\ForgotPasswordTask;
use App\Ship\Parents\Actions\SubAction;

class SendCreatePasswordSubAction extends SubAction
{
    public function run(User $user): void
    {
        $url = config('appSection-admin.create_password.url');

        CreatePasswordNotification::toMailUsing(
            fn (): CreatePasswordEmail => (new CreatePasswordEmail($user, $user->getEmailForPasswordReset(), $url))->onQueue('email')
        );

        app(ForgotPasswordTask::class)->run(
            $user->email,
            fn (string $token) => $user->notify(new CreatePasswordNotification($token))
        );
    }
}
