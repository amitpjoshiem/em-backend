<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Transporters\DeleteRowTransporter;
use App\Containers\AppSection\AssetsIncome\Tasks\DeleteRowTask;
use App\Ship\Parents\Actions\Action;

class DeleteRowAction extends Action
{
    public function run(DeleteRowTransporter $data): void
    {
        app(DeleteRowTask::class)->run($data->row, $data->group, $data->member_id);
    }
}
