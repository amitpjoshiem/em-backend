<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Data\Transporters\ReSendLeadCreatePasswordTransporter;
use App\Ship\Parents\Requests\Request;

class ReSendLeadCreatePasswordRequest extends Request
{
    protected ?string $transporter = ReSendLeadCreatePasswordTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
    ];

    public function rules(): array
    {
        return [
            'email' => 'required|exists:users,email',
        ];
    }

    /**
     * Is this an admin who has access to permission `update-users`
     * or the user is updating his own object (is the owner).
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
