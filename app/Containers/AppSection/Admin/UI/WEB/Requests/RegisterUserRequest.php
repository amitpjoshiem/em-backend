<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\WEB\Requests;

use App\Containers\AppSection\Admin\Data\Enums\AdminPermissionsEnum;
use App\Containers\AppSection\Admin\Data\Transporters\UserRegisterTransporter;
use App\Ship\Parents\Requests\Request;

class RegisterUserRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UserRegisterTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => [AdminPermissionsEnum::ADMIN_REGISTER_USER],
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email'         => 'required|email|max:255|unique:users,email',
            'username'      => 'required|min:2|max:100|unique:users,username',
            'position'      => 'required|min:2|max:100',
            'first_name'    => 'required|min:2|max:100',
            'last_name'     => 'required|min:2|max:100',
            'role'          => 'required|exists:roles,id',
            'phone'         => 'required',
            'npn'           => 'required',
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
