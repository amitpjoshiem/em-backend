<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\FindSalesforceAnnualReviewTransporter;
use App\Ship\Parents\Requests\Request;

class FindSalesforceAnnualReviewRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = FindSalesforceAnnualReviewTransporter::class;

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
            'id'    => 'required|exists:salesforce_annual_reviews,id',
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
