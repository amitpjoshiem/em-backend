<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Middlewares;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Client\Exceptions\ClientReadOnlyException;
use App\Containers\AppSection\User\Models\User;
use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class ClientReadOnlyMiddleware
{
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
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->hasRole(RolesEnum::LEAD) && $user->client?->readonly) {
            throw new ClientReadOnlyException();
        }

        return $next($request);
    }
}
