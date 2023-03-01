<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\GetAllContactsTransporter;
use App\Containers\AppSection\Member\Tasks\Contacts\GetAllContactsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllContactsAction extends Action
{
    public function run(GetAllContactsTransporter $data): Collection | LengthAwarePaginator
    {
        return app(GetAllContactsTask::class)
            ->addRequestCriteria()
            ->filterByMemberId($data->member_id)
            ->run();
    }
}
