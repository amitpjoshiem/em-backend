<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class MonthlyExpenseRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
