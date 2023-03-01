<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\WEB\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\EditClientVideoPageTransporter;
use App\Containers\AppSection\Client\Data\Enums\ClientHelpPagesEnum;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class EditClientVideoPageRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = EditClientVideoPageTransporter::class;

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
        //        'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'type',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(ClientHelpPagesEnum::values())],
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
