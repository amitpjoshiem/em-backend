<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\ResetPasswordException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Requests\ResetPasswordRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction extends Action
{
    public function run(ResetPasswordRequest $resetPasswordData): string
    {
        $input = $resetPasswordData->sanitizeInput([
            'email',
            'token',
            'password',
            'password_confirmation',
        ]);

        try {
            $status = Password::broker()->reset(
                $input,
                function (User $user, string $password): void {
                    $user->forceFill([
                        'password'       => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );
        } catch (Exception $exception) {
            throw new InternalErrorException(previous: $exception);
        }

        if ($status !== Password::PASSWORD_RESET) {
            throw new ResetPasswordException(trans($status));
        }

        return (string)trans($status);
    }
}
