<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberEmploymentHistoryRepository;
use App\Containers\AppSection\Member\Models\PersonInterface;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteAllEmploymentHistoryByPersonTask extends Task
{
    public function __construct(protected MemberEmploymentHistoryRepository $repository)
    {
    }

    public function run(PersonInterface $person): bool
    {
        try {
            return (bool)$this->repository->deleteWhere([
                'memberable_id'   => $person->getKey(),
                'memberable_type' => $person::class,
            ]);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}
