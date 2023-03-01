<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Actions;

use App\Containers\AppSection\SystemStatus\Exceptions\FallbackRouteNotFoundException;
use App\Ship\Parents\Actions\Action;

/**
 * Class FallbackRouteNotFoundAction.
 */
class FallbackRouteNotFoundAction extends Action
{
    public function run(): void
    {
        throw new FallbackRouteNotFoundException();
    }
}
