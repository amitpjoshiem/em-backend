<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Ship\Parents\Actions\SubAction;
use Closure;
use Illuminate\Support\Facades\Password;

class ForgotPasswordTask extends SubAction
{
    public function run(string $email, Closure $callback = null): string
    {
        $status = Password::broker()->sendResetLink(['email' => $email], $callback);

        return (string)trans($status);
    }
}
