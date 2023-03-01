<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\FindSalesforceChildOpportunityTransporter;
use App\Ship\Parents\Requests\Request;

class FindSalesforceChildOpportunityRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = FindSalesforceChildOpportunityTransporter::class;

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
        'child_opportunity_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'child_opportunity_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'child_opportunity_id'  => 'required|exists:salesforce_child_opportunities,id',
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
