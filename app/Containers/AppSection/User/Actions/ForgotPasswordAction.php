<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Mails\UserForgotPasswordMail;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\CreatePasswordNotification;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Containers\AppSection\User\Tasks\ForgotPasswordTask;
use App\Containers\AppSection\User\UI\API\Requests\ForgotPasswordRequest;
use App\Ship\Parents\Actions\Action;
use Closure;

class ForgotPasswordAction extends Action
{
    public function run(ForgotPasswordRequest $forgotPasswordData, Closure $callback = null): string
    {
        /** @var User $user */
        $user = app(FindUserByEmailTask::class)->run($forgotPasswordData->email);

        $url = config('appSection-user.reset_password_link');

        CreatePasswordNotification::toMailUsing(
            fn (): UserForgotPasswordMail => (new UserForgotPasswordMail($user, $url))->onQueue('email')
        );

        return app(ForgotPasswordTask::class)->run(
            $user->email,
            fn (string $token) => $user->notify(new CreatePasswordNotification($token))
        );
    }
}
