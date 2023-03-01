<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class ClientDocsAdditionalInfoRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
