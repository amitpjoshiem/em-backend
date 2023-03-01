<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class OtpSecurityRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
