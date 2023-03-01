<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class FindSalesforceChildOpportunitiesByUserIdTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    public function run(int $userId): Collection
    {
        return $this->repository->findWhere(['user_id' => $userId]);
    }
}
