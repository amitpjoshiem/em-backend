<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class CompanyRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
