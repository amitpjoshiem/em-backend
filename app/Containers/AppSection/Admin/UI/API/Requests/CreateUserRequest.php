<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\UserRegisterTransporter;
use App\Ship\Parents\Requests\Request;

class CreateUserRequest extends Request
{
    protected ?string $transporter = UserRegisterTransporter::class;

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
        'company_id',
        'role',
        'advisors.*',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        // 'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email'         => 'required|email|max:255|unique:users,email',
            'username'      => 'required|min:2|max:100|unique:users,username',
            'position'      => 'min:2|max:100',
            'first_name'    => 'required|min:2|max:100',
            'last_name'     => 'required|min:2|max:100',
            'role'          => 'required|exists:roles,id',
            'phone'         => 'required',
            'npn'           => 'numeric|nullable',
            'company_id'    => 'required|exists:companies,id',
            'advisors.*'    => 'exists:users,id',
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
