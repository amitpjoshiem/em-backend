<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Tasks;

use App\Containers\AppSection\Settings\Data\Criterias\OrderByKeyAscendingCriteria;
use App\Containers\AppSection\Settings\Data\Repositories\SettingRepository;
use App\Containers\AppSection\Settings\Models\Setting;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllSettingsTask extends Task
{
    public function __construct(protected SettingRepository $repository)
    {
    }

    /**
     * @return Setting[]|Collection|LengthAwarePaginator
     */
    public function run(): Collection | array | LengthAwarePaginator
    {
        return $this->repository->paginate();
    }

    /**
     * @throws RepositoryException
     */
    public function ordered(): self
    {
        $this->repository->pushCriteria(new OrderByKeyAscendingCriteria());

        return $this;
    }
}
