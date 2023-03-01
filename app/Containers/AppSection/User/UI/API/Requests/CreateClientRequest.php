<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Data\Transporters\CreateClientTransporter;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateClientRequest.
 *
 * @property-read string $email
 */
class CreateClientRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateClientTransporter::class;

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
            'email'    => 'required|email|max:255|unique:users,email',
            'name'     => 'required|string',
            'phone'    => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
