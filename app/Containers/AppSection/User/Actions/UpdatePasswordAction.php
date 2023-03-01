<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Containers\AppSection\User\Exceptions\VerificationOldPasswordException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\UI\API\Requests\UpdatePasswordRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction extends Action
{
    public function __construct(private AuthenticatedUser $authUser)
    {
    }

    /**
     * @throws InternalErrorException
     * @throws NotFoundException
     * @throws VerificationOldPasswordException
     * @throws AuthenticationUserException
     * @throws UpdateResourceFailedException
     */
    public function run(UpdatePasswordRequest $updatePasswordData): User
    {
        $user = $this->authUser->getStrictlyAuthUserModel();

        if (!Hash::check($updatePasswordData->current_password, $user->password)) {
            throw new VerificationOldPasswordException();
        }

        $password = Hash::make($updatePasswordData->password);

        return app(UpdateUserTask::class)->run(['password' => $password], $user->id);
    }
}
