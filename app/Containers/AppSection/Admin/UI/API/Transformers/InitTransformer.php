<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Transformers;

use App\Containers\AppSection\Admin\Data\Transporters\OutputInitTransporter;
use App\Containers\AppSection\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\CompanyTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

class InitTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'roles',
        'companies',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(OutputInitTransporter $data): array
    {
        return [];
    }

    public function includeRoles(OutputInitTransporter $data): Collection
    {
        return $this->collection($data->roles, new RoleTransformer(), resourceKey: 'roles');
    }

    public function includeCompanies(OutputInitTransporter $data): Collection
    {
        return $this->collection($data->companies, new CompanyTransformer(), resourceKey: 'companies');
    }
}
