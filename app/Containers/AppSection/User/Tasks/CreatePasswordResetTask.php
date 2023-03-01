<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;

class CreatePasswordResetTask extends Task
{
    public function run(User $user): string
    {
        try {
            /** @var PasswordBroker $broker */
            $broker = Password::broker();

            return $broker->createToken($user);
        } catch (Exception $exception) {
            throw new InternalErrorException(previous: $exception);
        }
    }
}
