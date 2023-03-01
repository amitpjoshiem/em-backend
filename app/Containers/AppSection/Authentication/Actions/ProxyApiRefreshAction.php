<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Data\Transporters\ProxyRefreshTransporter;
use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\SubActions\PrepareProxyResponseSubAction;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\GetSameSiteTask;
use App\Ship\Parents\Actions\Action;

class ProxyApiRefreshAction extends Action
{
    /**
     * @return array{response_content: mixed, refresh_cookie: mixed}
     */
    public function run(ProxyRefreshTransporter $data): array
    {
        if (!$data->refresh_token) {
            throw new RefreshTokenMissedException();
        }

        $requestData = [
            'client_ip'     => $data->client_ip,
            'grant_type'    => $data->grant_type,
            'refresh_token' => $data->refresh_token,
            'client_id'     => $data->client_id,
            'client_secret' => $data->client_password,
            'scope'         => $data->scope,
            'locale'        => $data->locale,
        ];

        $sameSite        = app(GetSameSiteTask::class)->run();
        $responseContent = app(CallOAuthServerTask::class)->run($requestData);

        return app(PrepareProxyResponseSubAction::class)->run($responseContent, $sameSite);
    }
}
