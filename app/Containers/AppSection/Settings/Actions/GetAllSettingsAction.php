<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Actions;

use App\Containers\AppSection\Settings\Models\Setting;
use App\Containers\AppSection\Settings\Tasks\GetAllSettingsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllSettingsAction extends Action
{
    /**
     * @return Setting[]|Collection|LengthAwarePaginator
     *
     * @throws RepositoryException
     */
    public function run(): array | Collection | LengthAwarePaginator
    {
        return app(GetAllSettingsTask::class)->addRequestCriteria()->ordered()->run();
    }
}
