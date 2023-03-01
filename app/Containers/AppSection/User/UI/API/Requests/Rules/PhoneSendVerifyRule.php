<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests\Rules;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Rules\Rule;

class PhoneSendVerifyRule extends Rule
{
    public function passes($attribute, $value): bool
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->phone === $value) {
            return true;
        }

        $count = app(UserRepository::class)->count(['phone' => $value]);

        return $count === 0;
    }

    public function message(): string
    {
        return 'This phone is already in use';
    }
}
