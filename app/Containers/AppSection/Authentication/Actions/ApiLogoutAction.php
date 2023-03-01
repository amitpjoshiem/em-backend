<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Data\Transporters\LogoutTransporter;
use App\Containers\AppSection\Authentication\Events\ApiLogoutEvent;
use App\Containers\AppSection\Authentication\Tasks\GetJtiByTokenTask;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Actions\Action;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class ApiLogoutAction extends Action
{
    /**
     * @throws AuthenticationException
     */
    public function run(LogoutTransporter $transporter, int $userId): void
    {
        $token = $transporter->request->bearerToken();

        if ($token === null) {
            throw new AuthenticationException();
        }

        $tokenId = app(GetJtiByTokenTask::class)->run($token);

        if ($tokenId === null) {
            throw new AuthenticationException((string)trans('appSection@authentication::messages.token'));
        }

        app(TokenRepository::class)->revokeAccessToken($tokenId);
        app(RefreshTokenRepository::class)->revokeRefreshTokensByAccessTokenId($tokenId);

        event(new ApiLogoutEvent($userId, $tokenId));
    }
}
