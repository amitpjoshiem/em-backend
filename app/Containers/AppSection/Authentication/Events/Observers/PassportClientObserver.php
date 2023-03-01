<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Events\Observers;

use Illuminate\Support\Facades\Cache;
use Laravel\Passport\Client;

class PassportClientObserver
{
    public function deleted(Client $client): void
    {
        $this->forgetCacheByPrefix($client);
    }

    public function updated(Client $client): void
    {
        $this->forgetCacheByPrefix($client);
    }

    private function forgetCacheByPrefix(Client $client): void
    {
        Cache::forget(config('passport.cache.client.prefix') . $client->getKey());
    }
}
