<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class AssetsConsolidationsRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
