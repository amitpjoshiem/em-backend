<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class UserActivityRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'         => '=',
        'created_at' => '=',
    ];
}
