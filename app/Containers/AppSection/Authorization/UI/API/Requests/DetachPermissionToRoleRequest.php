<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Ship\Parents\Requests\Request;

/**
 * Class DetachPermissionToRoleRequest.
 *
 * @property-read int   $role_id
 * @property-read array $permissions_ids
 */
class DetachPermissionToRoleRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'role_id',
        'permissions_ids.*',
    ];

    public function rules(): array
    {
        return [
            'role_id'           => sprintf('required|exists:%s,id', config('permission.table_names.roles')),
            'permissions_ids'   => 'required',
            'permissions_ids.*' => sprintf('exists:%s,id', config('permission.table_names.permissions')),
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
