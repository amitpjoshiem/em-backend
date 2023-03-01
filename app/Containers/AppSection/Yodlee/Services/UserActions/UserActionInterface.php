<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions;

interface UserActionInterface
{
    public function __construct(string $token);
}
