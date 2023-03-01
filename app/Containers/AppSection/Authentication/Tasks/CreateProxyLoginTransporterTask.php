<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Data\Transporters\ApiLoginTransporter;
use App\Containers\AppSection\Authentication\Data\Transporters\ProxyApiLoginTransporter;
use App\Ship\Parents\Tasks\Task;

class CreateProxyLoginTransporterTask extends Task
{
    public function run(ApiLoginTransporter $transporter): ProxyApiLoginTransporter
    {
        return ProxyApiLoginTransporter::fromTransporter($transporter, [
            'client_ip'       => $transporter->request->ip(),
            'locale'          => $transporter->request->headers->get('accept-language') ?? config('app.locale'),
            'client_id'       => (int)config('appSection-authentication.clients.api.user.id'),
            'client_password' => config('appSection-authentication.clients.api.user.secret'),
        ]);
    }
}
