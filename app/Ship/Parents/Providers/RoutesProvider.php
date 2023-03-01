<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\RoutesProvider as AbstractRoutesProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class RoutesProvider extends AbstractRoutesProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        parent::boot();
    }

    /**
     * Configure the rate limiters for the API application.
     */
    protected function configureRateLimiting(): void
    {
        if (Config::get('auth.login.throttle.enabled')) {
            RateLimiter::for('login', function (Request $request) {
                $ip = $request->ip() ?? '';

                return Limit::perMinute(Config::get('auth.login.throttle.attempts'))
                    ->by(Str::lower($request->input('email')) . '|' . $ip);
            });
        }
    }
}
