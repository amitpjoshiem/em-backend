<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\UserEditTransporter;
use App\Ship\Parents\Requests\Request;

class UpdateUserRequest extends Request
{
    protected ?string $transporter = UserEditTransporter::class;

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
        'role',
        'company_id',
        'advisors.*',
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
            'id'            => 'required|exists:users,id',
            'first_name'    => 'required|min:2|max:100',
            'last_name'     => 'required|min:2|max:100',
            'position'      => 'required|min:2|max:100',
            'phone'         => 'string|nullable',
            'npn'           => 'string|nullable',
            'role'          => 'exists:roles,id',
            'company_id'    => 'exists:companies,id',
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
