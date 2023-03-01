<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests;

use App\Containers\AppSection\Member\Data\Transporters\CreateMemberTransporter;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Containers\AppSection\Member\Models\MemberOther;
use App\Containers\AppSection\Member\UI\API\Requests\Rules\EmploymentHistoryValidationRule;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class CreateMemberRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateMemberTransporter::class;

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
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'                              => 'required|string',
            'email'                             => 'required|email|unique:members,email',
            'birthday'                          => 'required|date',
            'phone'                             => 'string|required|regex:/\(\d{3}\)\s\d{3}-\d{4}/',
            'married'                           => 'required|bool',
            'retired'                           => 'required|bool',
            'retirement_date'                   => 'required_if:retired,true|nullable|date',
            'address'                           => 'string|required',
            'city'                              => 'string|required',
            'state'                             => 'string|required',
            'zip'                               => 'string|required|max:5',
            'notes'                             => 'string|nullable',
            'spouse.first_name'                 => 'required_if:married,true|string|min:2|nullable',
            'spouse.last_name'                  => 'required_if:married,true|string|min:2|nullable',
            'spouse.email'                      => 'required_if:married,true|email|nullable',
            'spouse.birthday'                   => 'required_if:married,true|date|nullable',
            'spouse.phone'                      => 'string|regex:/\(\d{3}\)\s\d{3}-\d{4}/|nullable',
            'spouse.retired'                    => 'required_if:married,true|bool|nullable',
            'spouse.retirement_date'            => 'required_if:spouse.retired,true|nullable|date',
            'house.type'                        => ['required', 'string', Rule::in([
                MemberHouse::RENT,
                MemberHouse::OWN,
                MemberHouse::FAMILY,
            ])],
            'house.market_value'                => ['numeric', 'nullable'],
            'house.total_debt'                  => ['numeric', 'nullable'],
            'house.remaining_mortgage_amount'   => ['numeric', 'nullable'],
            'house.monthly_payment'             => ['numeric', 'nullable'],
            'house.total_monthly_expenses'      => ['numeric', 'nullable'],
            'other.risk'                        => ['string', 'required', Rule::in([
                MemberOther::AGGRESSIVE,
                MemberOther::MODERATELY_AGGRESSIVE,
                MemberOther::MODERATE,
                MemberOther::MODERATELY_CONSERVATIVE,
                MemberOther::CONSERVATIVE,
            ])],
            'other.questions'                          => 'string|nullable',
            'other.retirement'                         => 'string|nullable',
            'other.retirement_money'                   => 'string|nullable',
            'other.work_with_advisor'                  => 'bool|required',
            'employment_history.*'                     => ['array', new EmploymentHistoryValidationRule()],
            'employment_history.*.company_name'        => 'string|nullable',
            'employment_history.*.occupation'          => 'string|nullable',
            'employment_history.*.years'               => 'string|regex:/\d+/||nullable',
            'spouse.employment_history.*'              => ['array', new EmploymentHistoryValidationRule()],
            'spouse.employment_history.*.company_name' => 'string|nullable',
            'spouse.employment_history.*.occupation'   => 'string|nullable',
            'spouse.employment_history.*.years'        => 'string|regex:/\d+/||nullable',
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

    private function validateHousePayments(array $rules): bool
    {
        $house     = $this->get('house');
        $houseType = $house['type'];

        return \in_array($houseType, $rules, true);
    }
}
