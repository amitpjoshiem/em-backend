<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class ClientDocumentsEnum extends Enum
{
    /** @var string */
    public const COMPLETED_FINANCIAL_FACT_FINDER = 'completed_financial_fact_finder';

    /** @var string */
    public const INVESTMENT_AND_RETIREMENT_ACCOUNTS = 'investment_and_retirement_accounts';

    /** @var string */
    public const LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES = 'life_insurance_annuity_and_long_terms_care_policies';

    /** @var string */
    public const SOCIAL_SECURITY_INFORMATION = 'social_security_information';

    /** @var string */
    public const MEDICARE_DETAILS = 'medicare_details';

    /** @var string */
    public const PROPERTY_CASUALTY = 'property_casualty';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::COMPLETED_FINANCIAL_FACT_FINDER,
            self::INVESTMENT_AND_RETIREMENT_ACCOUNTS,
            self::LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES,
            self::SOCIAL_SECURITY_INFORMATION,
            self::MEDICARE_DETAILS,
            self::PROPERTY_CASUALTY,
        ];
    }

    public static function requiredSteps(): array
    {
        return [
            self::COMPLETED_FINANCIAL_FACT_FINDER,
            self::INVESTMENT_AND_RETIREMENT_ACCOUNTS,
            self::LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES,
            self::SOCIAL_SECURITY_INFORMATION,
        ];
    }

    public static function salesforceType(string $type): string
    {
        $salesforceTypes = [
            self::LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES => 'life_insurance_statement',
            self::MEDICARE_DETAILS                                    => 'medicare_statement',
            self::SOCIAL_SECURITY_INFORMATION                         => 'social_security_statement',
            self::PROPERTY_CASUALTY                                   => 'property_casualty_statement',
        ];

        if (!\array_key_exists($type, $salesforceTypes)) {
            return $type;
        }

        return $salesforceTypes[$type];
    }
}
