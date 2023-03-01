<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class EntityLogRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'      => '=',
        'user_id' => '=',
    ];
}
