<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\GetAllFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\GetAllFixedIndexAnnuitiesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllFixedIndexAnnuitiesAction extends Action
{
    /**
     * @return Collection|FixedIndexAnnuities[]|LengthAwarePaginator
     */
    public function run(GetAllFixedIndexAnnuitiesTransporter $data): Collection | array | LengthAwarePaginator
    {
        return app(GetAllFixedIndexAnnuitiesTask::class)->filterByMember($data->member_id)->addRequestCriteria()->run();
    }
}
