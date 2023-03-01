<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceUserRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class FindAllSalesforceUsersTask extends Task
{
    public function __construct(protected SalesforceUserRepository $repository)
    {
    }

    public function run(): Collection
    {
        return $this->repository->all();
    }
}
