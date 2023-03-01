<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportsDocRepository;
use App\Containers\AppSection\ClientReport\Exceptions\CantFindClientReportDocException;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class FindClientReportDocByIdTask extends Task
{
    public function __construct(protected ClientReportsDocRepository $repository)
    {
    }

    /**
     * @throws NotFoundException
     * @throws CantFindClientReportDocException
     */
    public function run(int $id): ClientReportsDoc
    {
        try {
            $clientReportDoc = $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }

        if ($clientReportDoc === null) {
            throw new CantFindClientReportDocException();
        }

        return $clientReportDoc;
    }

    public function withMember(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('member'));

        return $this;
    }

    public function withUser(): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria('user'));

        return $this;
    }

    /**
     * @throws RepositoryException
     */
    public function withRelations(array $relations): self
    {
        $this->repository->pushCriteria(new WithRelationsCriteria($relations));

        return $this;
    }
}
