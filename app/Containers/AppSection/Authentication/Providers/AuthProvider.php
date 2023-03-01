<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\Authentication\Events\Observers\UserObserver;
use App\Containers\AppSection\Authentication\Passport\PkceClient;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Core\Loaders\RoutesLoaderTrait;
use App\Ship\Parents\Providers\AuthProvider as ParentAuthProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;

/**
 * This class is provided by Laravel as default provider,
 * to register authorization policies.
 *
 * A.K.A App\Providers\AuthServiceProvider.php
 */
class AuthProvider extends ParentAuthProvider
{
    use RoutesLoaderTrait;

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerCacheUserAuth();

        parent::boot();

        $this->registerPassport();
        $this->registerPassportApiRoutes();
        $this->registerPassportWebRoutes();
    }

    private function registerCacheUserAuth(): void
    {
        // Register caching user provider
        Auth::provider('cache-user', static fn (): mixed => resolve(CacheUserProvider::class));

        // Register user observer for keep in cache actual data
        User::observe(UserObserver::class);
    }

    private function registerPassport(): void
    {
        Passport::loadKeysFrom(base_path('/secret-keys/oauth'));

        if (config('apiato.api.enabled-implicit-grant')) {
            Passport::enableImplicitGrant();
        }

        if (config('apiato.api.enabled-first-party-pkce-client')) {
            Passport::useClientModel(PkceClient::class);
        }

        if (config('apiato.api.enabled-client-secret-hashing')) {
            Passport::hashClientSecrets();
        }

        Passport::tokensExpireIn(now()->addMinutes(config('apiato.api.expires-in')));

        Passport::refreshTokensExpireIn(now()->addMinutes(config('apiato.api.refresh-expires-in')));

        if (config('apiato.api.enabled-password-grant-client')) {
            Passport::personalAccessTokensExpireIn(now()->addMonths(config('apiato.api.expires-in')));
        }
    }

    private function registerPassportApiRoutes(): void
    {
        $routeGroupArray = $this->getApiRouteGroup(Apiato::getApiPrefix() . self::getApiVersion());

        if (!$this->app->routesAreCached()) {
            Route::group($routeGroupArray, function (): void {
                Passport::routes(function (RouteRegistrar $router): void {
                    $router->forAccessTokens();
                    $router->forTransientTokens();

                    if (config('apiato.api.enabled-password-grant-client')) {
                        $router->forClients();
                        $router->forPersonalAccessTokens();
                    }
                });
            });
        }
    }

    private function registerPassportWebRoutes(): void
    {
        if (!$this->app->routesAreCached()) {
            Passport::routes(function (RouteRegistrar $router): void {
                $router->forAuthorization();
            });
        }
    }

    /**
     * Return current api version.
     */
    private static function getApiVersion(): string
    {
        $version = '';

        if (config('apiato.api.enable_version_prefix')) {
            $version = config('appSection-authentication.version', $version);
        }

        return $version;
    }
}
