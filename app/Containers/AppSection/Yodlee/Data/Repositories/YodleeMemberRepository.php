<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class YodleeMemberRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
