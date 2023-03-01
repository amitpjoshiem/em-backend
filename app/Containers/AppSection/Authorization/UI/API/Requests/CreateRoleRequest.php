<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Enums\AuthorizationPermissionEnum;
use App\Containers\AppSection\Authorization\Data\Transporters\CreateRoleTransporter;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateRoleRequest.
 *
 * @property-read string      $name
 * @property-read string      $description
 * @property-read string      $display_name
 * @property-read int|null    $level
 * @property-read string|null $guard_name
 */
class CreateRoleRequest extends Request
{
    protected ?string $transporter = CreateRoleTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => AuthorizationPermissionEnum::MANAGE_ROLES,
        'roles'       => '',
    ];

    public function rules(): array
    {
        return [
            'name'         => sprintf('required|unique:%s,name|min:2|max:20|no_spaces', config('permission.table_names.roles')),
            'description'  => 'max:255',
            'display_name' => 'max:100',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
