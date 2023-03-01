<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\CompanyRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllCompaniesTask extends Task
{
    public function __construct(protected CompanyRepository $repository)
    {
    }

    /**
     * @return Collection|User[]
     */
    public function run(): Collection | array
    {
        return $this->repository->all();
    }

    public function filterById(int $id): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria('id', $id));

        return $this;
    }
}
