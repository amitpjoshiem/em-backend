<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\DeleteUserTransporter;
use App\Ship\Parents\Requests\Request;

class DeleteUserRequest extends Request
{
    protected ?string $transporter = DeleteUserTransporter::class;

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
        'id',
        'transfer_to',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id'          => 'required|exists:users,id',
            'transfer_to' => 'exists:users,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
