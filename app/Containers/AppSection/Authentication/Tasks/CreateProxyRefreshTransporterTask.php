<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Data\Transporters\ProxyRefreshTransporter;
use App\Containers\AppSection\Authentication\Data\Transporters\RefreshTransporter;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Tasks\Task;

class CreateProxyRefreshTransporterTask extends Task
{
    public function run(RefreshTransporter $transporter): ProxyRefreshTransporter
    {
        return ProxyRefreshTransporter::fromTransporter($transporter, [
            'client_ip'       => $transporter->request->ip(),
            'locale'          => $transporter->request->headers->get('accept-language') ?? config('app.locale'),
            'client_id'       => (int)config('appSection-authentication.clients.api.user.id'),
            'client_password' => config('appSection-authentication.clients.api.user.secret'),
            // Use the refresh token sent in request data, if not exist try to get it from the cookie
            'refresh_token'   => $transporter->refresh_token ?? $transporter->request->cookie('refreshToken'),
        ]);
    }
}
