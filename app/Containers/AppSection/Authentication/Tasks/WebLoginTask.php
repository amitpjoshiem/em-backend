<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;

class WebLoginTask extends Task
{
    public function run(?string $email, string $password, string $field = 'email', bool $remember = false): bool
    {
        return Auth::attempt([$field => $email, 'password' => $password], $remember);
    }
}
