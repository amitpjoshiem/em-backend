<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Providers;

use App\Containers\AppSection\Otp\Guards\TokenGuard;
use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\RequestGuard;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\PassportUserProvider;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

/**
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        EventServiceProvider::class,
        MiddlewareServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();

        if (config('auth.otp')) {
            $this->registerGuard();
        }
    }

    /**
     * Register the token guard.
     */
    protected function registerGuard(): void
    {
        Auth::resolved(function (AuthManager $auth): void {
            $auth->extend('passport', fn (Application $app, string $name, array $config): RequestGuard => tap($this->makeGuard($config), function (RequestGuard $guard): void {
                app()->refresh('request', $guard, 'setRequest');
            }));
        });
    }

    /**
     * Make an instance of the token guard.
     */
    protected function makeGuard(array $config): RequestGuard
    {
        return new RequestGuard(function (Request $request) use ($config): mixed {
            if (!isset($config['provider'])) {
                return null;
            }

            $provider = Auth::createUserProvider($config['provider']);

            if ($provider === null) {
                return null;
            }

            /** @var Encrypter $encrypter */
            $encrypter = $this->app->make('encrypter');

            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                new PassportUserProvider($provider, $config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $encrypter,
            ))->user($request);
        }, $this->app['request']);
    }
}
