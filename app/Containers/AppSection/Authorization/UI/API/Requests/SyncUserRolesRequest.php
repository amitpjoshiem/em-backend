<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Requests\Request;

/**
 * Class SyncUserRolesRequest.
 *
 * @property-read array         $roles_ids
 * @property-read int|UserModel $user_id
 */
class SyncUserRolesRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ADMINS_ACCESS,
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'user_id',
        'roles_ids.*',
    ];

    public function rules(): array
    {
        return [
            'roles_ids'   => 'required',
            'roles_ids.*' => sprintf('exists:%s,id', config('permission.table_names.roles')),
            'user_id'     => 'required|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
