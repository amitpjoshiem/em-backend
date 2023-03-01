<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\DocusignRecipientRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignRecipient;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Exception;

class FindDocusignRecipientByIdTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected DocusignRecipientRepository $repository)
    {
    }

    public function run(int $id): ?DocusignRecipient
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}
