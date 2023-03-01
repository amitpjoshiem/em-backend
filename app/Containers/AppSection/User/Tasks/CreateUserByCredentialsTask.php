<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Hash;

class CreateUserByCredentialsTask extends Task
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function run(
        string $email,
        string $password,
        string $username,
        ?int $companyId,
        bool $isClient = true,
        ?string $phone = null
    ): User {
        try {
            // Create new user
            return $this->repository->create([
                'password'      => Hash::make($password),
                'email'         => $email,
                'username'      => $username,
                'company_id'    => $companyId,
                'is_client'     => $isClient,
                'phone'         => $phone,
            ]);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException(previous: $exception))->debug($exception);
        }
    }
}
