<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use function now;

class CacheTokenRepository extends TokenRepository
{
    protected Carbon $expiresInSeconds;

    public function __construct(protected string $cacheKey, int $expiresInSeconds, protected string $cacheStore)
    {
        $this->expiresInSeconds = now()->addSeconds($expiresInSeconds);
    }

    /**
     * @inheritDoc
     * @psalm-suppress all
     */
    public function find($id)
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $id,
                $this->expiresInSeconds,
                fn (): ?Token => parent::find($id)
            );
    }

    /**
     * @inheritDoc
     */
    public function findForUser($id, $userId)
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $id,
                $this->expiresInSeconds,
                fn (): ?Token => parent::findForUser($id, $userId)
            );
    }

    /**
     * @inheritDoc
     */
    public function forUser($userId): Collection
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $userId,
                $this->expiresInSeconds,
                fn (): Collection => parent::forUser($userId)
            );
    }

    /**
     * @inheritDoc
     */
    public function getValidToken($user, $client)
    {
        return Cache::store($this->cacheStore)
            ->remember(
                $this->cacheKey . $user->getKey(),
                $this->expiresInSeconds,
                fn (): ?Token => parent::getValidToken($user, $client)
            );
    }
}
