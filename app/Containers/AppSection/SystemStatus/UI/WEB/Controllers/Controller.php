<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\UI\WEB\Controllers;

use App\Containers\AppSection\SystemStatus\Actions\FallbackRouteNotFoundAction;
use App\Ship\Parents\Controllers\WebController;

class Controller extends WebController
{
    public function fallbackWebRouteNotFound(): void
    {
        app(FallbackRouteNotFoundAction::class)->run();
    }

    public function getPhpInfo(): void
    {
        echo phpinfo();
    }

    public function ping(): array
    {
        return ['status' => 'ok'];
    }
}
