<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class AdminDeleteUserTask extends Task
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    /**
     * @throws ValidatorException|CreateResourceFailedException
     */
    public function run(int $userId): bool
    {
        try {
            // Create new user
            return (bool)$this->userRepository->delete($userId);
        } catch (Exception $exception) {
            throw (new DeleteResourceFailedException())->debug($exception);
        }
    }
}
