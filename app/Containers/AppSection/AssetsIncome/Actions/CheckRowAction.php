<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Transporters\CheckRowTransporter;
use App\Containers\AppSection\AssetsIncome\Exceptions\RowAlreadyExistException;
use App\Containers\AppSection\AssetsIncome\Tasks\FindRowTask;
use App\Ship\Parents\Actions\Action;

class CheckRowAction extends Action
{
    public function run(CheckRowTransporter $data): void
    {
        $row = app(FindRowTask::class)->run($data->row, $data->group, $data->member_id);

        if ($row !== null) {
            throw new RowAlreadyExistException();
        }
    }
}
