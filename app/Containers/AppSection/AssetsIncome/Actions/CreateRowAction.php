<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\NumberElement;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\CreateRowTransporter;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\SaveDataTransporter;
use App\Containers\AppSection\AssetsIncome\Tasks\CheckRowNameTask;
use App\Containers\AppSection\AssetsIncome\Tasks\SaveValueTask;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\AssetsIncome\Tasks\CheckRowParentTask;

class CreateRowAction extends Action
{
    public function run(CreateRowTransporter $data): void
    {
        $name = app(CheckRowNameTask::class)->run($data->row, $data->group, $data->member_id);

        $parent = app(CheckRowParentTask::class)->run($data->row, $data->group, $data->member_id);

        app(SaveValueTask::class)->run(new SaveDataTransporter([
            'member_id' => $data->member_id,
            'group'     => $data->group,
            'row'       => $name,
            'element'   => 'owner',
            'type'      => NumberElement::class,
            'can_join'  => $data->can_join,
            'parent'    => $data->parent ?? $parent,
        ]));
    }
}
