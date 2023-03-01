<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Requests;

use App\Containers\AppSection\Client\Data\Transporters\SaveClientConfirmationTransporter;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class SaveClientConfirmationRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = SaveClientConfirmationTransporter::class;

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
        //         'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        //         'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'consultation'  => ['string', 'nullable', Rule::in([
                Client::WANT_CONSULTATION,
                Client::DONT_WANT_CONSULTATION,
                Client::WANT_CONSULTATION_AND_BOOK,
            ])],
            'currently_have.cds'                         => 'boolean|nullable',
            'currently_have.annuity'                     => 'boolean|nullable',
            'currently_have.life_insurance'              => 'boolean|nullable',
            'currently_have.bonds_or_bonds_funds'        => 'boolean|nullable',
            'currently_have.variable_annuity'            => 'boolean|nullable',
            'currently_have.mutual_funds_or_stocks'      => 'boolean|nullable',
            'currently_have.ira_tsa_401_403'             => 'boolean|nullable',
            'currently_have.long_term_care_insurance'    => 'boolean|nullable',
            'currently_have.dormant_accounts'            => 'boolean|nullable',
            'more_info_about.indexed_annuities'          => 'boolean|nullable',
            'more_info_about.moving_my_ira'              => 'boolean|nullable',
            'more_info_about.securing_my_money'          => 'boolean|nullable',
            'more_info_about.strategic_wealth_report'    => 'boolean|nullable',
            'more_info_about.rolling_over_my_401_403'    => 'boolean|nullable',
            'more_info_about.tax_free_accounts'          => 'boolean|nullable',
            'more_info_about.rule_of_100'                => 'boolean|nullable',
            'more_info_about.retirement_income_analysis' => 'boolean|nullable',
            'more_info_about.my_variable_annuity'        => 'boolean|nullable',
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
