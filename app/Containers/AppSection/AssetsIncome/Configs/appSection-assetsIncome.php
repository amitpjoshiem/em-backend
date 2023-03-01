<?php

declare(strict_types=1);

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\DropdownElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\NumberElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\StringElement;

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section AssetsIncome Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'schema' => [
        'groups' => [
            GroupsEnum::CURRENT_INCOME => [
                'salary'      => [
                    'owner'  => NumberElement::class,
                    'spouse' => NumberElement::class,
                ],
                'social_security_estimate' => [
                    'owner'  => NumberElement::class,
                    'spouse' => NumberElement::class,
                ],
                'pension' => [
                    'owner'  => NumberElement::class,
                    'spouse' => NumberElement::class,
                ],
                'rental_income' => [
                    'owner'  => NumberElement::class,
                    'spouse' => NumberElement::class,
                ],
                'required_minimum_distributions' => [
                    'owner'  => NumberElement::class,
                    'spouse' => NumberElement::class,
                ],
                'other' => [
                    'owner'  => NumberElement::class,
                    'spouse' => NumberElement::class,
                ],
            ],
            GroupsEnum::LIQUID_ASSETS => [
                'account_type'                        => DropdownElement::class,
                'employer_sponsored_retirement_plans' => DropdownElement::class,
                'individual_retirement_account'       => DropdownElement::class,
                'taxable_brokerage'                   => DropdownElement::class,
                'annuities'                           => DropdownElement::class,
                'certificates_of_deposit'             => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'cash_value_life_insurance' => [
                    'owner'       => NumberElement::class,
                    'spouse'      => NumberElement::class,
                    'institution' => StringElement::class,
                ],
                'inheritance' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'lump_sum_pension' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
            ],
            GroupsEnum::OTHER_ASSETS_INVESTMENTS => [
                'value_of_home'                       => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'business_interest'                   => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'investment_properties' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'rental_properties' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'farmland' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'vacation_property' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
                'other' => [
                    'owner'         => NumberElement::class,
                    'spouse'        => NumberElement::class,
                    'institution'   => StringElement::class,
                ],
            ],
        ],
        'headers' => [
            GroupsEnum::CURRENT_INCOME => [
                'owner',
                'spouse',
            ],
            GroupsEnum::LIQUID_ASSETS => [
                'owner',
                'spouse',
                'institution',
                'household',
            ],
            GroupsEnum::OTHER_ASSETS_INVESTMENTS => [
                'owner',
                'spouse',
                'institution',
                'household',
            ],
        ],
        'dropdown_options' => [
            'account_type' => [
                'cash'         => 'Cash',
                'checking'     => 'Checking',
                'savings'      => 'Savings',
                'money_market' => 'Money Market',
            ],
            'employer_sponsored_retirement_plans' => [
                '401k'  => '401k',
                '403b'  => '403b',
                '457'   => '457',
                'tsp'   => 'TSP',
            ],
            'individual_retirement_account' => [
                'iras_roth'   => 'Roth IRA',
                'traditional' => 'Traditional IRA',
                'sep'         => 'SEP IRA',
                'simple'      => 'Simple IRA',
                'rollover'    => 'Rollover IRA',
            ],
            'taxable_brokerage' => [
                'jtwros'     => 'Joint Tenants with Rights of Survivorship',
                'jtic'       => 'Joint Tenants in Common',
                'trust'      => 'Trust',
                'individual' => 'Individual',
            ],
            'annuities' => [
                'fixed'    => 'Fixed',
                'indexed'  => 'Indexed',
                'variable' => 'Variable',
            ],
        ],
        'placeholders' => [
            'owner'         => '$12345',
            'spouse'        => '$12345',
            'institution'   => 'Enter Name',
            'household'     => '$12345',
        ],
        'joined_rows' => [
            GroupsEnum::CURRENT_INCOME => [
                'rental_income',
                'other',
            ],
            GroupsEnum::LIQUID_ASSETS => [
                'money_market',
                'checking',
                'cash',
                'savings',
                'jtwros',
                'jtic',
                'trust',
                'individual',
                'fixed',
                'indexed',
                'variable',
                'certificates_of_deposit',
            ],
            GroupsEnum::OTHER_ASSETS_INVESTMENTS => [
            ],
        ],
        'joined_dropdown' => [
            'taxable_brokerage',
            'account_type',
        ],
    ],
];
