<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Containers\AppSection\ClientReport\Exceptions\CantFindClientReportException;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindClientReportByIdTask extends Task
{
    public function __construct(protected ClientReportRepository $repository)
    {
    }

    /**
     * @throws NotFoundException
     * @throws CantFindClientReportException
     */
    public function run(int $id): ClientReport
    {
        try {
            $clientReport = $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }

        if ($clientReport === null) {
            throw new CantFindClientReportException();
        }

        return $clientReport;
    }

    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('member'));

        return $this;
    }
}
