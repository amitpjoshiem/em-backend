<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientHelpRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Illuminate\Support\Collection;

class GetAllClientHelpTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected ClientHelpRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }
}
