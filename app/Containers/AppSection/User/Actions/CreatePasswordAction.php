<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Client\Tasks\FindClientByUserIdTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Containers\AppSection\User\Exceptions\CreatePasswordException;
use App\Containers\AppSection\User\Exceptions\ResetPasswordException;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Containers\AppSection\User\UI\API\Requests\CreatePasswordRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CreatePasswordAction extends Action
{
    /**
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws ResetPasswordException
     * @throws UserNotFoundException
     * @throws CreatePasswordException
     */
    public function run(CreatePasswordRequest $createPasswordData): string
    {
        $user = app(FindUserByEmailTask::class)->run($createPasswordData->email);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        if ($user->hasVerifiedEmail()) {
            throw new CreatePasswordException();
        }

        $input = $createPasswordData->sanitizeInput([
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

            if ($status === Password::PASSWORD_RESET) {
                $user->markEmailAsVerified();
                event(new Verified($user));
            }
        } catch (Exception $exception) {
            throw new InternalErrorException(previous: $exception);
        }

        if ($status !== Password::PASSWORD_RESET) {
            throw new ResetPasswordException(trans($status));
        }

        $client = app(FindClientByUserIdTask::class)->withRelations(['member'])->run($user->getKey());

        if ($client !== null && $client->member->type === Member::PRE_LEAD) {
            app(UpdateMemberTask::class)->run($client->member->getKey(), ['type' => Member::LEAD]);
        }

        return (string)trans($status);
    }
}
