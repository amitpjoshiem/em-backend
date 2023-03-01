<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Requests;

use App\Containers\AppSection\ClientReport\Data\Transporters\CreateClientReportTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class CreateClientReportRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateClientReportTransporter::class;

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
        /** @psalm-suppress InvalidArgument */
        $values = $this->all(['member_id', 'contract_number']);

        return [
            'member_id'       => 'required|exists:members,id',
            'contract_number' => ['required', 'numeric', 'max:999999999', Rule::unique('client_reports')->where(
                function (Builder $query) use ($values): Builder {
                    return $query->where([
                        ['member_id', '=', $values['member_id']],
                        ['contract_number', '=', $values['contract_number']],
                    ]);
                }
            )],
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
