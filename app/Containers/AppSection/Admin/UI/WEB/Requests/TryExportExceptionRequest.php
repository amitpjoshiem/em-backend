<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\WEB\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\TryExportExceptionTransporter;
use App\Ship\Parents\Requests\Request;

class TryExportExceptionRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = TryExportExceptionTransporter::class;

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
        'export_exceptions_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'export_exceptions_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'export_exceptions_id' => 'required|exists:salesforce_export_exceptions,id',
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
