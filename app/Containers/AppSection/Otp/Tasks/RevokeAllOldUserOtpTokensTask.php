<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class RevokeAllOldUserOtpTokensTask extends Task
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    /**
     * @throws RepositoryException
     * @throws UpdateResourceFailedException
     */
    public function run(): void
    {
        try {
            $this->otpRepository->updateByCriteria([
                'revoked'   => true,
            ]);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function filterByUser(int $userId): self
    {
        $this->otpRepository->pushCriteria(new ThisEqualThatCriteria('user_id', $userId));

        return $this;
    }
}
