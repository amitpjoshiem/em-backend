<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Containers\AppSection\AssetsIncome\Data\Enums\TypesEnum;
use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\SaveDataTransporter;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Ship\Parents\Tasks\Task;

class SaveValueTask extends Task
{
    public function __construct(protected AssetsIncomeValueRepository $repository)
    {
    }

    public function run(SaveDataTransporter $input): AssetsIncomeValue
    {
        $type = $input->type;

        $data = [
            'value' => $input->value,
            'type'  => TypesEnum::$type(),
        ];

        if (isset($input->joined)) {
            $data['joined'] = $input->joined;
        }

        if (isset($input->can_join)) {
            $data['can_join'] = $input->can_join;
        }

        if (isset($input->parent)) {
            $data['parent'] = $input->parent;
        }

        return $this->repository->updateOrCreate([
            'member_id' => $input->member_id,
            'group'     => $input->group,
            'row'       => $input->row,
            'element'   => $input->element,
        ], $data);
    }
}
