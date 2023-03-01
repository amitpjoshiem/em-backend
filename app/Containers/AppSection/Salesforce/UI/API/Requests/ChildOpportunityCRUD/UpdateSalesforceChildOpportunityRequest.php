<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\UpdateSalesforceChildOpportunityTransporter;
use App\Ship\Parents\Requests\Request;

class UpdateSalesforceChildOpportunityRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateSalesforceChildOpportunityTransporter::class;

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
            'id'                    => 'required|exists:salesforce_child_opportunities,id',
            'type'                  => 'string',
            'stage'                 => 'string',
            'close_date'            => 'date',
            'amount'                => 'string',
            'name'                  => 'string',
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
