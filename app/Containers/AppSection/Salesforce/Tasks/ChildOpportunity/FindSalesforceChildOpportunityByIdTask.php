<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceChildOpportunityException;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceChildOpportunityByIdTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceChildOpportunityException
     */
    public function run(int $id): SalesforceChildOpportunity
    {
        $salesforceChildOpportunity = $this->repository->find($id);

        if ($salesforceChildOpportunity === null) {
            throw new FindSalesforceChildOpportunityException();
        }

        return $salesforceChildOpportunity;
    }

    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }
}
