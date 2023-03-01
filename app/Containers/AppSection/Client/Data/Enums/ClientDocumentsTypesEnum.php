<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class ClientDocumentsTypesEnum extends Enum
{
    /** @var string */
    public const TYPE_401K = 'type_401k';

    /** @var string */
    public const TYPE_403B = 'type_403b';

    /** @var string */
    public const TYPE_457 = 'type_457';

    /** @var string */
    public const TYPE_TSP = 'type_tsp';

    /** @var string */
    public const TYPE_IRAS_ROTH = 'type_iras_roth';

    /** @var string */
    public const TYPE_TRADITIONAL = 'type_traditional';

    /** @var string */
    public const TYPE_SEP = 'type_sep';

    /** @var string */
    public const TYPE_SIMPLE = 'type_simple';

    /** @var string */
    public const TYPE_ROLLOVER = 'type_rollover';

    /** @var string */
    public const TYPE_JOINT_TENANTS_WITH_RIGHTS_OF_SURVIVORSHIP = 'type_joint_tenants_with_rights_of_survivorship';

    /** @var string */
    public const TYPE_JOINT_TENANTS_IN_COMMON = 'type_joint_tenants_in_common';

    /** @var string */
    public const TYPE_TRUST = 'type_trust';

    /** @var string */
    public const TYPE_INDIVIDUAL = 'type_individual';

    /** @var string */
    public const TYPE_FIXED = 'type_fixed';

    /** @var string */
    public const TYPE_INDEXED = 'type_indexed';

    /** @var string */
    public const TYPE_VARIABLE = 'type_variable';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::TYPE_TRADITIONAL,
            self::TYPE_ROLLOVER,
            self::TYPE_IRAS_ROTH,
            self::TYPE_SEP,
            self::TYPE_SIMPLE,
            self::TYPE_401K,
            self::TYPE_403B,
            self::TYPE_457,
            self::TYPE_TSP,
            self::TYPE_INDIVIDUAL,
            self::TYPE_INDEXED,
            self::TYPE_VARIABLE,
            self::TYPE_JOINT_TENANTS_WITH_RIGHTS_OF_SURVIVORSHIP,
            self::TYPE_JOINT_TENANTS_IN_COMMON,
            self::TYPE_TRUST,
        ];
    }

    public static function labels(): array
    {
        return [
            self::TYPE_TRADITIONAL                               => 'Traditional IRA',
            self::TYPE_ROLLOVER                                  => 'Rollover IRA',
            self::TYPE_IRAS_ROTH                                 => 'Roth IRA',
            self::TYPE_SEP                                       => 'SEP IRA',
            self::TYPE_SIMPLE                                    => 'Simple IRA',
            self::TYPE_401K                                      => '401K',
            self::TYPE_403B                                      => '403b',
            self::TYPE_457                                       => '457',
            self::TYPE_TSP                                       => 'TSP',
            self::TYPE_INDIVIDUAL                                => 'Individual Brokerage Account',
            self::TYPE_INDEXED                                   => 'Fixed Indexed Annuity',
            self::TYPE_VARIABLE                                  => 'Variable Annuity',
            self::TYPE_JOINT_TENANTS_WITH_RIGHTS_OF_SURVIVORSHIP => 'Joint Tenants with Rights of Survivorship',
            self::TYPE_JOINT_TENANTS_IN_COMMON                   => 'Joint Tenants in Common',
            self::TYPE_TRUST                                     => 'TRUST',
        ];
    }

    public static function getLabel(string $type): string
    {
        $labels = self::labels();

        if (!\array_key_exists($type, $labels)) {
            return $type;
        }

        return $labels[$type];
    }
}
