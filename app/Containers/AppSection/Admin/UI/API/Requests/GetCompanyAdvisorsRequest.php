<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\GetCompanyAdvisorsTransporter;
use App\Ship\Parents\Requests\Request;

class GetCompanyAdvisorsRequest extends Request
{
    protected ?string $transporter = GetCompanyAdvisorsTransporter::class;

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
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'company_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required',
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
