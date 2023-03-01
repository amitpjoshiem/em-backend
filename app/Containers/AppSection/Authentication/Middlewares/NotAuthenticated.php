<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Middlewares;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Tasks\HasRoleTask;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Providers\RoutesProvider;
use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Orchid\Platform\Providers\FoundationServiceProvider;

class NotAuthenticated
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
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            $authGuard = $this->auth->guard($guard);

            if ($authGuard->check()) {
                if ($request->expectsJson()) {
                    abort(404);
                } else {
                    // @FIXME : change it
                    if (class_exists(FoundationServiceProvider::class)) {
                        /** @var UserModel|null $user */
                        $user = $authGuard->user();

                        if (app(HasRoleTask::class)->run($user, RolesEnum::admin())) {
                            return redirect()->route(config('platform.index'));
                        }
                    }

                    return redirect(RoutesProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
