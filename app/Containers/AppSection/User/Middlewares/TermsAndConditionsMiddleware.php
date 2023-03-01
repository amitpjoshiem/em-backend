<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Middlewares;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Exceptions\TermsAndConditionsException;
use App\Containers\AppSection\User\Traits\RealUserTrait;
use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class TermsAndConditionsMiddleware
{
    use RealUserTrait;

    public function __construct(private AuthManager $auth)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     *
     * @psalm-return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = $this->getStrictlyRealUser();

        if ($user->hasRole(RolesEnum::CLIENT) && !$user->client?->terms_and_conditions) {
            throw new TermsAndConditionsException();
        }

        return $next($request);
    }
}
