<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceChildOpportunityException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use Illuminate\Database\Eloquent\Collection;

class FindSalesforceChildOpportunitiesByCompanyIdTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceChildOpportunityException
     */
    public function run(int $companyId): Collection
    {
        return $this->repository->whereHas('user.company', function (EagerLoadPivotBuilder $query) use ($companyId): void {
            $query->where('id', $companyId);
        })->all();
    }
}
