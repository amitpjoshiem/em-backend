<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class BlueprintMonthlyIncomeRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
