<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class BlueprintDocRepository extends Repository
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
