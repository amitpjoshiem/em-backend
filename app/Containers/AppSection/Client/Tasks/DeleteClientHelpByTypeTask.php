<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientHelpRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;

class DeleteClientHelpByTypeTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected ClientHelpRepository $repository)
    {
    }

    public function run(string $type): bool
    {
        return (bool)$this->repository->deleteWhere(['type' => $type]);
    }
}
