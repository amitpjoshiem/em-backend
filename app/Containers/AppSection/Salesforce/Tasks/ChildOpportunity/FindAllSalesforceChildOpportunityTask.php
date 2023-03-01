<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class FindAllSalesforceChildOpportunityTask extends Task
{
    public function __construct(protected SalesforceChildOpportunityRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(int $memberId): Collection
    {
        try {
            return $this->repository->findByField([
                'member_id'     => $memberId,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
