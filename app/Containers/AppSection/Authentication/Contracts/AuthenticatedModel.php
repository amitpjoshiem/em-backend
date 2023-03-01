<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Contracts;

use App\Ship\Parents\Models\UserModel;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthenticatedModel
{
    public function getStrictlyAuthUser(): Authenticatable;

    public function getStrictlyAuthUserId(): int;

    public function getAuthUserModel(): ?UserModel;

    public function getStrictlyAuthUserModel(): UserModel;

    /** @psalm-suppress MoreSpecificReturnType */
    public function getAuthUser(): ?Authenticatable;

    public function getAuthUserId(): ?int;

    public function getAuthIdentifierAsInt(Authenticatable $user): int;

    public function setAuthUser(Authenticatable $user): void;
}
