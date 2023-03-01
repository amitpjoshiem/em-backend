<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self default()
 * @method static self avatar()
 * @method static self model()
 * @method static self member_report()
 * @method static self stress_test()
 * @method static self excel_export()
 * @method static self blueprint_pdf()
 * @method static self client_report_pdf()
 * @method static self assets_consolidation_docs()
 * @method static self investment_and_retirement_accounts()
 * @method static self life_insurance_annuity_and_long_terms_care_policies()
 * @method static self social_security_information()
 * @method static self list_of_stock_certificates_or_bonds()
 * @method static self fixed_index_annuities()
 * @method static self investment_package()
 * @method static self docusign_certificate()
 * @method static self medicare_details()
 * @method static self property_casualty()
 * @method static self client_help()
 *
 * @property-read string $value
 */
class MediaCollectionEnum extends Enum
{
    /** @var string */
    public const DEFAULT = 'default';

    /** @var string */
    public const AVATAR  = 'avatar';

    /** @var string */
    public const MODEL   = 'model';

    /** @var string */
    public const STRESS_TEST   = 'stress_test';

    /** @var string */
    public const MEMBER_REPORT = 'member_report';

    /** @var string */
    public const EXCEL_EXPORT = 'excel_export';

    /** @var string */
    public const BLUEPRINT_DOC = 'blueprint_docs';

    /** @var string */
    public const CLIENT_REPORT_DOC = 'client_report_docs';

    /** @var string */
    public const ASSETS_CONSOLIDATIONS_DOCS = 'assets_consolidation_docs';

    /** @var string */
    public const INVESTMENT_AND_RETIREMENT_ACCOUNTS = 'investment_and_retirement_accounts';

    /** @var string */
    public const LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES = 'life_insurance_annuity_and_long_terms_care_policies';

    /** @var string */
    public const SOCIAL_SECURITY_INFORMATION = 'social_security_information';

    /** @var string */
    public const FIXED_INDEX_ANNUITIES = 'fixed_index_annuities';

    /** @var string */
    public const INVESTMENT_PACKAGE = 'investment_package';

    /** @var string */
    public const DOCUSIGN_CERTIFICATE = 'docusign_certificate';

    /** @var string */
    public const MEDICARE_DETAILS = 'medicare_details';

    /** @var string */
    public const PROPERTY_CASUALTY = 'property_casualty';

    /** @var string */
    public const CLIENT_HELP = 'client_help';

    /** @var string */
    public const FINANCIAL_FACT_FINDER = 'financial_fact_finder';

    protected static function values(): array
    {
        return [
            'default'                                                     => self::DEFAULT,
            'avatar'                                                      => self::AVATAR,
            'model'                                                       => self::MODEL,
            'member_report'                                               => self::MEMBER_REPORT,
            'stress_test'                                                 => self::STRESS_TEST,
            'excel_export'                                                => self::EXCEL_EXPORT,
            'assets_consolidation_docs'                                   => self::ASSETS_CONSOLIDATIONS_DOCS,
            'blueprint_pdf'                                               => self::BLUEPRINT_DOC,
            'client_report_pdf'                                           => self::CLIENT_REPORT_DOC,
            'investment_and_retirement_accounts'                          => self::INVESTMENT_AND_RETIREMENT_ACCOUNTS,
            'life_insurance_annuity_and_long_terms_care_policies'         => self::LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES,
            'social_security_information'                                 => self::SOCIAL_SECURITY_INFORMATION,
            'fixed_index_annuities'                                       => self::FIXED_INDEX_ANNUITIES,
            'investment_package'                                          => self::INVESTMENT_PACKAGE,
            'docusign_certificate'                                        => self::DOCUSIGN_CERTIFICATE,
            'medicare_details'                                            => self::MEDICARE_DETAILS,
            'property_casualty'                                           => self::PROPERTY_CASUALTY,
            'client_help'                                                 => self::CLIENT_HELP,
            'financial_fact_finder'                                       => self::FINANCIAL_FACT_FINDER,
        ];
    }

    public static function clientDocsType(): array
    {
        return [
            self::INVESTMENT_AND_RETIREMENT_ACCOUNTS,
            self::LIFE_INSURANCE_ANNUITY_AND_LONG_TERMS_CARE_POLICIES,
            self::SOCIAL_SECURITY_INFORMATION,
            self::MEDICARE_DETAILS,
            self::PROPERTY_CASUALTY,
        ];
    }
}
