<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\User\Models\Company;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class CompanyTransformer.
 */
class CompanyTransformer extends Transformer
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

    public function transform(Company $company): array
    {
        return [
            'id'     => $company->getHashedKey(),
            'name'   => $company->name,
            'domain' => $company->domain,
        ];
    }
}
