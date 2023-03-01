<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\User\Data\Transporters\OutputUsersStatsTransporter;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class CompanyTransformer.
 */
class UsersStatsTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes = [
    ];

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
    ];

    public function transform(OutputUsersStatsTransporter $stats): array
    {
        return [
            'users' => $stats->users,
        ];
    }
}
