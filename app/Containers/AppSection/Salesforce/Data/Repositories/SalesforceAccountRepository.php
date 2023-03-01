<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class SalesforceAccountRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];
}
