<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class SaveMonthlyExpenseRequest extends Request
{
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
            'member_id'                                                    => 'required|exists:members,id',
            'housing.mortgage_rent_fees.essential'                         => 'numeric|nullable',
            'housing.mortgage_rent_fees.discretionary'                     => 'numeric|nullable',
            'housing.property_taxes_and_insurance.essential'               => 'numeric|nullable',
            'housing.property_taxes_and_insurance.discretionary'           => 'numeric|nullable',
            'housing.utilities.essential'                                  => 'numeric|nullable',
            'housing.utilities.discretionary'                              => 'numeric|nullable',
            'housing.household_improvement.essential'                      => 'numeric|nullable',
            'housing.household_improvement.discretionary'                  => 'numeric|nullable',
            'housing.household_maintenance.essential'                      => 'numeric|nullable',
            'housing.household_maintenance.discretionary'                  => 'numeric|nullable',
            'food_transportation.at_home.essential'                        => 'numeric|nullable',
            'food_transportation.at_home.discretionary'                    => 'numeric|nullable',
            'food_transportation.dining_out.essential'                     => 'numeric|nullable',
            'food_transportation.dining_out.discretionary'                 => 'numeric|nullable',
            'food_transportation.vehicle_purchases_payments.essential'     => 'numeric|nullable',
            'food_transportation.vehicle_purchases_payments.discretionary' => 'numeric|nullable',
            'food_transportation.auto_insurance_and_taxes.essential'       => 'numeric|nullable',
            'food_transportation.auto_insurance_and_taxes.discretionary'   => 'numeric|nullable',
            'food_transportation.fuel_and_maintenance.essential'           => 'numeric|nullable',
            'food_transportation.fuel_and_maintenance.discretionary'       => 'numeric|nullable',
            'food_transportation.public_transportation.essential'          => 'numeric|nullable',
            'food_transportation.public_transportation.discretionary'      => 'numeric|nullable',
            'healthcare.health_insurance.essential'                        => 'numeric|nullable',
            'healthcare.health_insurance.discretionary'                    => 'numeric|nullable',
            'healthcare.medicare_medigap.essential'                        => 'numeric|nullable',
            'healthcare.medicare_medigap.discretionary'                    => 'numeric|nullable',
            'healthcare.copays_uncovered_medical_services.essential'       => 'numeric|nullable',
            'healthcare.copays_uncovered_medical_services.discretionary'   => 'numeric|nullable',
            'healthcare.drugs_and_medical_supplies.essential'              => 'numeric|nullable',
            'healthcare.drugs_and_medical_supplies.discretionary'          => 'numeric|nullable',
            'personal_insurance.life_other.essential'                      => 'numeric|nullable',
            'personal_insurance.life_other.discretionary'                  => 'numeric|nullable',
            'personal_insurance.long_term_care.essential'                  => 'numeric|nullable',
            'personal_insurance.long_term_care.discretionary'              => 'numeric|nullable',
            'personal_insurance.clothing.essential'                        => 'numeric|nullable',
            'personal_insurance.clothing.discretionary'                    => 'numeric|nullable',
            'personal_insurance.product_and_services.essential'            => 'numeric|nullable',
            'personal_insurance.product_and_services.discretionary'        => 'numeric|nullable',
            'entertainment.essential'                                      => 'numeric|nullable',
            'entertainment.discretionary'                                  => 'numeric|nullable',
            'travel.essential'                                             => 'numeric|nullable',
            'travel.discretionary'                                         => 'numeric|nullable',
            'hobbies.essential'                                            => 'numeric|nullable',
            'hobbies.discretionary'                                        => 'numeric|nullable',
            'family_care_education.essential'                              => 'numeric|nullable',
            'family_care_education.discretionary'                          => 'numeric|nullable',
            'income_taxes.essential'                                       => 'numeric|nullable',
            'income_taxes.discretionary'                                   => 'numeric|nullable',
            'charitable_contributions.essential'                           => 'numeric|nullable',
            'charitable_contributions.discretionary'                       => 'numeric|nullable',
            'other.essential'                                              => 'numeric|nullable',
            'other.discretionary'                                          => 'numeric|nullable',
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
