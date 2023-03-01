<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\UpdateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateSalesforceAnnualReviewRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateSalesforceAnnualReviewTransporter::class;

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
            'id'            => 'required|exists:salesforce_annual_reviews,id',
            'name'          => 'nullable|string',
            'review_date'   => 'nullable|date',
            'amount'        => 'nullable|numeric',
            'type'          => ['nullable', 'string', Rule::in(SalesforceAnnualReview::TYPE)],
            'new_money'     => ['nullable', 'string', Rule::in(SalesforceAnnualReview::NEW_MONEY)],
            'notes'         => 'nullable|string',
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
