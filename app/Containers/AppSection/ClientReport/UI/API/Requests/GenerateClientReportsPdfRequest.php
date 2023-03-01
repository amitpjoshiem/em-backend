<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Requests;

use App\Containers\AppSection\ClientReport\Data\Transporters\GenerateClientReportsPdfTransporter;
use App\Ship\Parents\Requests\Request;

class GenerateClientReportsPdfRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = GenerateClientReportsPdfTransporter::class;

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
        'contracts.*',
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
            'member_id'     => 'required|exists:members,id',
            'contracts'     => 'array|nullable',
            'contracts.*'   => 'exists:client_reports,id',
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
