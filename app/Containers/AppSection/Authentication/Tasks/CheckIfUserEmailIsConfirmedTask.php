<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;

class CheckIfUserEmailIsConfirmedTask extends Task
{
    public function run(UserModel $user): bool
    {
        if ($this->emailConfirmationIsRequired()) {
            return $user->hasVerifiedEmail();
        }

        return true;
    }

    private function emailConfirmationIsRequired(): bool
    {
        return (bool)config('appSection-authentication.require_email_confirmation');
    }
}
