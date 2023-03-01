<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Requests;

use App\Containers\AppSection\ClientReport\Data\Transporters\UpdateClientReportTransporter;
use App\Containers\AppSection\ClientReport\Tasks\FindClientReportByIdTask;
use App\Ship\Parents\Requests\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class UpdateClientReportRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateClientReportTransporter::class;

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
        /** @psalm-suppress InvalidArgument */
        $values = $this->all(['id', 'contract_number']);

        return [
            'id'              => ['required', Rule::exists('client_reports', 'id')->where('is_custom', 1)],
            'carrier'         => 'string|nullable',
            'contract_number' => ['nullable', 'numeric', Rule::unique('client_reports')->where(
                function (Builder $query) use ($values): Builder {
                    $clientReport = app(FindClientReportByIdTask::class)->run($values['id']);

                    return $query->where([
                        ['member_id', '=', $clientReport->member_id],
                        ['contract_number', '=', $values['contract_number']],
                    ]);
                }
            )->ignore($values['id'])],
            'origination_date'                  => 'date|nullable',
            'current_year.beginning_balance'    => 'numeric|nullable',
            'current_year.interest_credited'    => 'numeric|nullable',
            'current_year.withdrawals'          => 'numeric|nullable',
            'current_year.current_value'        => 'numeric|nullable',
            'current_year.surrender_value'      => 'numeric|nullable',
            'since_inception.total_premiums'    => 'numeric|nullable',
            'since_inception.bonus_received'    => 'numeric|nullable',
            'since_inception.interest_credited' => 'numeric|nullable',
            'since_inception.total_withdrawals' => 'numeric|nullable',
            'total_fees'                        => 'numeric|nullable',
            'rmd_or_sys_wd'                     => 'numeric|nullable',
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
