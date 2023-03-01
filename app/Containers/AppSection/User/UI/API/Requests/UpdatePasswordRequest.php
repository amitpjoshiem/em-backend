<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class UpdatePasswordRequest.
 *
 * @property-read string $current_password
 * @property-read string $password
 * @property-read string $password_confirmation
 */
class UpdatePasswordRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'password'         => 'required|string|confirmed|min:6|max:30| :current_password',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
