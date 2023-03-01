<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\SubActions;

use App\Containers\AppSection\User\Mails\RestoreUserEmail;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\ResetPasswordNotification;
use App\Containers\AppSection\User\Tasks\ForgotPasswordTask;
use App\Ship\Parents\Actions\SubAction;

class SendRestoreUserMailSubAction extends SubAction
{
    public function run(User $user): void
    {
        $url = config('appSection-user.reset_password_link');

        ResetPasswordNotification::toMailUsing(
            fn (): RestoreUserEmail => (new RestoreUserEmail($user, $user->getEmailForPasswordReset(), $url))->onQueue('email')
        );

        app(ForgotPasswordTask::class)->run(
            $user->email,
            fn (string $token) => $user->notify(new ResetPasswordNotification($token))
        );
    }
}
