<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Transformers;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Parents\Transformers\Transformer;

class PermissionTransformer extends Transformer
{
    public function transform(Permission $permission): array
    {
        return [
            'object'       => $permission->getResourceKey(),
            'id'           => $permission->getHashedKey(), // << Unique Identifier
            'name'         => $permission->name, // << Unique Identifier
            'description'  => $permission->description,
            'display_name' => $permission->display_name,
        ];
    }
}
