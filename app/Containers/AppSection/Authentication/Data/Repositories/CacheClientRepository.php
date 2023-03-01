<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use function config;
use function now;

class CacheClientRepository extends ClientRepository
{
    protected string $cacheKey;

    protected Carbon $expiresInSeconds;

    protected string $cacheStore;

    /**
     * @inheritDoc
     * @psalm-suppress MissingParamType
     */
    public function __construct($personalAccessClientId = null, $personalAccessClientSecret = null)
    {
        $this->cacheKey         = config('passport.cache.client.prefix');
        $this->expiresInSeconds = now()->addSeconds(config('passport.cache.client.expires_in'));
        $this->cacheStore       = config('passport.cache.client.store', config('cache.default'));

        parent::__construct($personalAccessClientId, $personalAccessClientSecret);
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $id,
                $this->expiresInSeconds,
                fn (): ?Client => parent::find($id)
            );
    }

    /**
     * @inheritDoc
     */
    public function findForUser($clientId, $userId)
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $clientId,
                $this->expiresInSeconds,
                fn (): ?Client => parent::findForUser($clientId, $userId)
            );
    }

    /**
     * @inheritDoc
     */
    public function forUser($userId)
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $userId,
                $this->expiresInSeconds,
                fn (): Collection => parent::forUser($userId)
            );
    }
}
