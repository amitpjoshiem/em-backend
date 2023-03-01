<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks\Contacts;

use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\Member\Exceptions\CantFindContactException;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class GetContactByIdTask extends Task
{
    public function __construct(protected MemberContactRepository $repository)
    {
    }

    public function run(int $id): MemberContact
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new CantFindContactException(previous: $exception);
        }
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
