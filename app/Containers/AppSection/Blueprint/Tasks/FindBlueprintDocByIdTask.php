<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintDocRepository;
use App\Containers\AppSection\Blueprint\Exceptions\DocumentNotFountException;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Ship\Criterias\Eloquent\WithRelationsCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class FindBlueprintDocByIdTask extends Task
{
    public function __construct(protected BlueprintDocRepository $repository)
    {
    }

    public function run(int $docId): BlueprintDoc
    {
        $doc = $this->repository->find($docId);

        if ($doc === null) {
            throw new DocumentNotFountException();
        }

        return $doc;
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
