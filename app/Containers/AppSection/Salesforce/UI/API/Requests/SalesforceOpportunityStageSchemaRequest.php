<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Requests;

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Data\Transporters\SalesforceOpportunityStageSchemaTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class SalesforceOpportunityStageSchemaRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = SalesforceOpportunityStageSchemaTransporter::class;

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
        '',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'stage',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'stage'     => ['string', 'required', Rule::in(array_merge(OpportunityStageEnum::values(), [OpportunityStageEnum::CLOSED]))],
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
