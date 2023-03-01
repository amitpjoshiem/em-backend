<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Transporters\SaveDataTransporter;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Containers\AppSection\AssetsIncome\SubActions\GetValuesSubAction;
use App\Containers\AppSection\AssetsIncome\Tasks\FindRowTask;
use App\Containers\AppSection\AssetsIncome\Tasks\SaveValueTask;
use App\Ship\Parents\Actions\Action;
use stdClass;

class SaveDataAction extends Action
{
    public function run(SaveDataTransporter $data): stdClass
    {
        /** @var AssetsIncomeValue | null $row */
        $row = app(FindRowTask::class)->run($data->group, $data->row, $data->member_id);

        if ($data->element === 'owner' && isset($data->joined) && $data->joined === true && ($row === null || !$row->joined)) {
            app(SaveValueTask::class)->run(new SaveDataTransporter([
                'member_id' => $data->member_id,
                'group'     => $data->group,
                'row'       => $data->row,
                'element'   => 'spouse',
                'type'      => $data->type,
                'value'     => null,
            ]));
        }

        app(SaveValueTask::class)->run($data);

        return app(GetValuesSubAction::class)->run($data->member_id);
    }
}
