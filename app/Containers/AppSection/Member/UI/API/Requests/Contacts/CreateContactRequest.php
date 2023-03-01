<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\CreateContactTransporter;
use App\Ship\Parents\Requests\Request;

class CreateContactRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateContactTransporter::class;

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
        'member_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'member_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'member_id'                  => 'required|exists:members,id',
            'first_name'                 => 'string|min:2|nullable',
            'last_name'                  => 'string|min:2|nullable',
            'email'                      => 'email|nullable',
            'birthday'                   => 'date|nullable',
            'phone'                      => 'string|regex:/\(\d{3}\)\s\d{3}-\d{4}/|nullable',
            'retired'                    => 'bool|nullable',
            'retirement_date'            => 'required_if:spouse.retired,true|nullable|date',
            'is_spouse'                  => 'bool|nullable',
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
