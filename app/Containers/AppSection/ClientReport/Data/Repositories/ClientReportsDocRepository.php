<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class ClientReportsDocRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'            => '=',
        'type'          => '=',
        'filename'      => 'like',
        'status'        => '=',
        'created_at'    => '=',
    ];
}
