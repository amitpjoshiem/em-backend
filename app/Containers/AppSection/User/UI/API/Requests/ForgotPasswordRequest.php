<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class ForgotPasswordRequest.
 *
 * @property-read string $email
 */
class ForgotPasswordRequest extends Request
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
            'email' => 'required|email|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
