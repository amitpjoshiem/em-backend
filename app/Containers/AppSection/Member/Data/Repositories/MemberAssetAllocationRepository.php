<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class MemberAssetAllocationRepository extends Repository
{
    protected string $container = 'Member';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
