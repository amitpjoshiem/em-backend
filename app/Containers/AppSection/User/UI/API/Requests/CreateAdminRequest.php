<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Data\Transporters\CreateUserTransporter;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateAdminRequest.
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read string $password_confirmation
 * @property-read string $username
 */
class CreateAdminRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateUserTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => UserPermissionEnum::CREATE_ADMINS,
        'roles'       => '',
    ];

    public function rules(): array
    {
        return [
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:6|max:30',
            'username' => 'required|min:2|max:100|unique:users,username',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
