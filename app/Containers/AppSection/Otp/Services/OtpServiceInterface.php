<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Services;

use App\Containers\AppSection\User\Models\User;

interface OtpServiceInterface
{
    public function resolveOtp(User $user, string $tokenId): void;

    public function checkOtp(User $user, string $code): bool;

    public function changeOtp(User $user, ?string $code): void;
}
