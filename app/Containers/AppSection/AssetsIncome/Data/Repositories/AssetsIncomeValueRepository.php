<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class AssetsIncomeValueRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'  => 'like',
        'type'  => 'in',
    ];
}
