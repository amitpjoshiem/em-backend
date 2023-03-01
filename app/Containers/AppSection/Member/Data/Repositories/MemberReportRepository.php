<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class MemberReportRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
