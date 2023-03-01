<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Repositories\TemporaryUploadRepository;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Criterias\Eloquent\ThisMatchListThat;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTemporaryUploadByUuidsTask extends Task
{
    public function __construct(protected TemporaryUploadRepository $repository, private Collection $collection)
    {
    }

    /**
     * @return Collection<TemporaryUpload>
     *
     * @throws RepositoryException
     */
    public function run(array $uuids, string $collection = null): Collection
    {
        if ($uuids === []) {
            return $this->collection->make([]);
        }

        if ($collection) {
            $this->repository->pushCriteria(new ThisEqualThatCriteria('collection', $collection));
        }

        $this->repository->pushCriteria(new ThisMatchListThat('uuid', $uuids));

        return $this->repository->all();
    }
}
