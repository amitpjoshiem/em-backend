<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Providers;

use App\Containers\AppSection\User\Middlewares\TermsAndConditionsMiddleware;
use App\Containers\AppSection\User\Middlewares\UserMiddleware;
use App\Ship\Parents\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * @psalm-var array<array-key, string>
     */
    protected array $routeMiddleware = [
        'user_header'          => UserMiddleware::class,
        'terms_and_conditions' => TermsAndConditionsMiddleware::class,
    ];
}
