<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientHelpRepository;
use App\Containers\AppSection\Client\Models\ClientHelp;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;

class SaveClientHelpByTypeTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected ClientHelpRepository $repository)
    {
    }

    public function run(string $type, array $data): ClientHelp
    {
        return $this->repository->updateOrCreate(['type' => $type], $data);
    }
}
