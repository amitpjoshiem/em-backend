<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class MediaRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
