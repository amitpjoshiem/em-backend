<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Services;

use App\Containers\AppSection\Authentication\Contracts\AuthenticatedModel;
use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

final class AuthenticatedUser implements AuthenticatedModel
{
    private ?Authenticatable $user = null;

    /**
     * @throws AuthenticationUserException
     */
    public function getStrictlyAuthUser(): Authenticatable
    {
        $user = $this->getAuthUser();

        if ($user === null) {
            throw new AuthenticationUserException();
        }

        return $user;
    }

    /**
     * @throws AuthenticationUserException
     */
    public function getStrictlyAuthUserId(): int
    {
        $userId = $this->getAuthUserId();

        if ($userId === null) {
            throw new AuthenticationUserException();
        }

        return $userId;
    }

    public function getAuthUserModel(): ?UserModel
    {
        $user = $this->getAuthUser();

        if ($user instanceof UserModel) {
            return $user;
        }

        return null;
    }

    /**
     * @throws AuthenticationUserException
     */
    public function getStrictlyAuthUserModel(): UserModel
    {
        $user = $this->getStrictlyAuthUser();

        if (!($user instanceof UserModel)) {
            throw new AuthenticationUserException();
        }

        return $user;
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public function getAuthUser(): ?Authenticatable
    {
        if (\is_null($this->user)) {
            $this->user = Auth::user();
        }

        return $this->user;
    }

    public function getAuthUserId(): ?int
    {
        $user = $this->getAuthUser();

        return $user !== null ? $this->getAuthIdentifierAsInt($user) : null;
    }

    public function getAuthIdentifierAsInt(Authenticatable $user): int
    {
        return (int)$user->getAuthIdentifier();
    }

    public function setAuthUser(Authenticatable $user): void
    {
        $this->user = $user;
    }
}
