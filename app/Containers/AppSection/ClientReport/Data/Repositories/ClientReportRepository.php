<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class ClientReportRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'               => '=',
        'origination_date' => 'between',
    ];
}
