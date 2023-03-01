<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class AdminRegisterUserTask extends Task
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    /**
     * @throws ValidatorException|CreateResourceFailedException
     */
    public function run(array $userData): User
    {
        try {
            // Create new user
            return $this->userRepository->create($userData);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException())->debug($exception);
        }
    }
}
