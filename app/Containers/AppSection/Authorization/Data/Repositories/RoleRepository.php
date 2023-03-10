<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class RoleRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'         => '=',
        'display_name' => 'like',
        'description'  => 'like',
    ];

    public function model(): string
    {
        return config('permission.models.role');
    }
}
