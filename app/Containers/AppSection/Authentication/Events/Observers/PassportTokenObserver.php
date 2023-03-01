<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Events\Observers;

use Illuminate\Support\Facades\Cache;
use Laravel\Passport\Token;

class PassportTokenObserver
{
    public function deleted(Token $token): void
    {
        $this->forgetCacheByPrefix($token);
    }

    public function updated(Token $token): void
    {
        $this->forgetCacheByPrefix($token);
    }

    private function forgetCacheByPrefix(Token $token): void
    {
        Cache::forget(config('passport.cache.token.prefix') . $token->getKey());
    }
}
