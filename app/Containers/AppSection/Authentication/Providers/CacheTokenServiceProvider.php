<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\Authentication\Data\Repositories\CacheTokenRepository;
use App\Containers\AppSection\Authentication\Events\Observers\PassportTokenObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class CacheTokenServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Token::observe(PassportTokenObserver::class);
    }

    public function register(): void
    {
        $this->app->singleton(TokenRepository::class, static fn (): CacheTokenRepository => new CacheTokenRepository(
            config('passport.cache.client.prefix'),
            config('passport.cache.token.expires_in'),
            config('passport.cache.client.store', config('cache.default'))
        ));
    }
}
