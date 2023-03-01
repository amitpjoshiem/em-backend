<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use Hashids;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Primitive;
use stdClass;

class YodleeProvidersTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'accounts',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(array $provider): array
    {
        return [
            'id'    => Hashids::encode($provider['id']),
            'name'  => $provider['name'],
            'logo'  => $provider['logo'],
        ];
    }

    public function includeAccounts(array $provider): Collection| Primitive
    {
        if (!isset($provider['accounts'])) {
            return $this->primitive(new stdClass());
        }

        return $this->collection($provider['accounts'], new YodleeAccountsTransformer(), 'accounts');
    }
}
