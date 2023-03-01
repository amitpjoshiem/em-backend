<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Handlers;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use Illuminate\Http\Request;
use Laravel\Passport\Events\AccessTokenCreated;
use Prettus\Validator\Exceptions\ValidatorException;

class LogSuccessfulLogin
{
    public function __construct(protected UserRepository $repository, protected Request $request)
    {
    }

    /**
     * Handle the Event. (Single Listener Implementation).
     *
     *
     *
     * @throws ValidatorException
     */
    public function handle(AccessTokenCreated $event): void
    {
        $this->repository->update([
            'last_login_at' => now(),
            'last_login_ip' => $this->request->ip(),
        ], $event->userId);
    }
}
