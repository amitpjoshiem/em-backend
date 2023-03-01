<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\Token;

class LogoutUserTask extends Task
{
    public function __construct(private RefreshTokenRepository $refreshTokenRepository)
    {
    }

    public function run(UserModel $user): void
    {
        $user->tokens->each(function (Token $token): void {
            $token->revoke();
            $this->refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->getKey());
        });
    }
}
