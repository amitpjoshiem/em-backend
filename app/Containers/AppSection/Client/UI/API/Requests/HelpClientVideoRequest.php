<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Requests;

use App\Containers\AppSection\Client\Data\Enums\ClientHelpPagesEnum;
use App\Containers\AppSection\Client\Data\Transporters\HelpClientVideoTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class HelpClientVideoRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = HelpClientVideoTransporter::class;

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
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'page',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'page' => ['required', 'string', Rule::in(ClientHelpPagesEnum::values())],
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
