<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Containers\AppSection\Member\Data\Transporters\UpdateMemberTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Containers\AppSection\Member\Models\MemberOther;
use App\Containers\AppSection\Member\UI\API\Requests\Rules\EmploymentHistoryValidationRule;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateMemberTransporter::class;

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
        'spouse.employment_history.*.id',
        'employment_history.*.id',
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
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'name'                              => 'string|nullable',
            'email'                             => 'email|nullable',
            'birthday'                          => 'date|nullable',
            'phone'                             => 'string|regex:/\(\d{3}\)\s\d{3}-\d{4}/|nullable',
            'married'                           => 'bool|nullable',
            'retired'                           => 'bool|nullable',
            'retirement_date'                   => 'required_if:retired,true|nullable|date',
            'address'                           => 'string|nullable',
            'city'                              => 'string|nullable',
            'state'                             => 'string|nullable',
            'zip'                               => 'string|nullable|max:5',
            'notes'                             => 'string|nullable',
            'amount_for_retirement'             => ['string', 'nullable', Rule::in(Member::AMOUNT_FOR_RETIREMENT_TYPE)],
            'biggest_financial_concern'         => 'string|nullable',
            'is_watch'                          => 'bool|nullable',
            'channels'                          => 'string|nullable',
            'spouse.name'                       => 'string|min:2|nullable',
            'spouse.email'                      => 'email|nullable',
            'spouse.birthday'                   => 'date|nullable',
            'spouse.phone'                      => 'string|regex:/\(\d{3}\)\s\d{3}-\d{4}/|nullable',
            'spouse.retired'                    => 'bool|nullable',
            'spouse.retirement_date'            => 'required_if:spouse.retired,true|nullable|date',
            'house.type'                        => ['string', Rule::in([
                MemberHouse::RENT,
                MemberHouse::OWN,
                MemberHouse::FAMILY,
            ])],
            'house.market_value'                => 'numeric|nullable',
            'house.total_debt'                  => 'numeric|nullable',
            'house.remaining_mortgage_amount'   => 'numeric|nullable',
            'house.monthly_payment'             => 'numeric|nullable',
            'house.total_monthly_expenses'      => 'numeric|nullable',
            'other.risk_tolerance'              => ['string', Rule::in([
                MemberOther::AGGRESSIVE,
                MemberOther::MODERATELY_AGGRESSIVE,
                MemberOther::MODERATE,
                MemberOther::MODERATELY_CONSERVATIVE,
                MemberOther::CONSERVATIVE,
            ])],
            'other.questions'                          => 'string|nullable',
            'other.retirement_goal'                    => 'string|nullable',
            'other.retirement_money_goal'              => 'string|nullable',
            'other.work_with_advisor'                  => 'bool|nullable',
            'employment_history.*'                     => ['array', new EmploymentHistoryValidationRule()],
            'employment_history.*.company_name'        => 'string|nullable',
            'employment_history.*.occupation'          => 'string|nullable',
            'employment_history.*.years'               => 'integer|nullable',
            'spouse.employment_history.*'              => ['array', new EmploymentHistoryValidationRule()],
            'spouse.employment_history.*.company_name' => 'string|nullable',
            'spouse.employment_history.*.occupation'   => 'string|nullable',
            'spouse.employment_history.*.years'        => 'integer|nullable',
            'total_net_worth'                          => 'numeric|nullable',
            'goal'                                     => 'numeric|nullable',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::AVATAR])->run($rules);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @throws NotFoundException
     */
    public function authorize(): bool
    {
        return $this->check(['hasAccess']);
    }
}
