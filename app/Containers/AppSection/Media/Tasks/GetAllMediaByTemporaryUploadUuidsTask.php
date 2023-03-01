<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Criterias\WhereHasTemporaryUploadCriteria;
use App\Containers\AppSection\Media\Data\Repositories\MediaRepository;
use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;

class GetAllMediaByTemporaryUploadUuidsTask extends Task
{
    public function __construct(protected MediaRepository $repository)
    {
    }

    /**
     * @return Collection<Media>
     */
    public function run(array $uuids, ?string $collection = null): Collection
    {
        $this->repository->pushCriteria(new WhereHasTemporaryUploadCriteria($uuids, $collection));

        return $this->repository->all();
    }
}
