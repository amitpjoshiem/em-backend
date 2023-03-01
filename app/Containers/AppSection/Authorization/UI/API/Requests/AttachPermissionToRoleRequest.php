<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Data\Transporters\AttachPermissionToRoleTransporter;
use App\Ship\Parents\Requests\Request;

/**
 * Class AttachPermissionToRoleRequest.
 *
 * @property int   $role_id
 * @property array $permissions_ids
 */
class AttachPermissionToRoleRequest extends Request
{
    protected ?string $transporter = AttachPermissionToRoleTransporter::class;

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
        'permissions_ids.*',
        'role_id',
    ];

    public function rules(): array
    {
        return [
            'permissions_ids'   => 'required',
            'permissions_ids.*' => sprintf('exists:%s,id', config('permission.table_names.permissions')),
            'role_id'           => sprintf('required|exists:%s,id', config('permission.table_names.roles')),
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
