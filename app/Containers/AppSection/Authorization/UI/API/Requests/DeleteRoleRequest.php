<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Ship\Parents\Requests\Request;

/**
 * Class FindRoleRequest.
 *
 * @property int $id
 */
class DeleteRoleRequest extends Request
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
        'id',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'id',
    ];

    public function rules(): array
    {
        return [
            'id' => sprintf('required|exists:%s,id', config('permission.table_names.roles')),
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
