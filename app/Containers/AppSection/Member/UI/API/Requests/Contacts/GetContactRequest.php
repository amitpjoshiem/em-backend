<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\GetContactTransporter;
use App\Ship\Parents\Requests\Request;

class GetContactRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = GetContactTransporter::class;

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
            'id' => 'required|exists:member_contacts,id',
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
