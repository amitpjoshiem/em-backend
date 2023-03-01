<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Requests;

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Data\Transporters\UpdateOpportunityStageTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class SalesforceUpdateOpportunityStageRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateOpportunityStageTransporter::class;

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
            'member_id'         => 'required|exists:salesforce_opportunities,member_id',
            'stage'             => ['required', Rule::in(array_merge(OpportunityStageEnum::values(), [OpportunityStageEnum::CLOSED]))],
            'date_of_1st'       => [
                'date',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_1ST),
            ],
            'date_of_2nd'       => [
                'date',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_2ND),
            ],
            'date_of_3rd'       => [
                'date',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_3RD),
            ],
            'result_1st_appt'   => [
                'string',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_2ND),
                Rule::in($this->getOptionsValues('appSection-salesforce.opportunity_stage_schema.appointment_2nd.result_1st_appt.options')),
            ],
            'result_2nd_appt'   => [
                'string',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_3RD),
                Rule::in($this->getOptionsValues('appSection-salesforce.opportunity_stage_schema.appointment_3rd.result_2nd_appt.options')),
            ],
            'status_1st_appt'   => [
                'string',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_2ND),
                Rule::in($this->getOptionsValues('appSection-salesforce.opportunity_stage_schema.appointment_2nd.status_1st_appt.options')),
            ],
            'status_2nd_appt'   => [
                'string',
                sprintf('required_if:stage,%s', OpportunityStageEnum::APPOINTMENT_3RD),
                Rule::in($this->getOptionsValues('appSection-salesforce.opportunity_stage_schema.appointment_3rd.status_2nd_appt.options')),
            ],
            'closed_status' => [
                'string',
                sprintf('required_if:stage,%s', OpportunityStageEnum::CLOSED),
                Rule::in($this->getOptionsValues('appSection-salesforce.opportunity_stage_schema.closed.closed_status.options')),
            ],
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

    private function getOptionsValues(string $conf): array
    {
        return array_column(config($conf), 'value');
    }
}
