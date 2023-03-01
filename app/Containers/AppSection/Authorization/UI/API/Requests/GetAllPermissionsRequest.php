<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Traits\RequestWithoutRulesTrait;

class GetAllPermissionsRequest extends Request
{
    use RequestWithoutRulesTrait;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
