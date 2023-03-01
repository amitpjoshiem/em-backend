<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class TaxQualificationEnum extends Enum
{
    /** @var string */
    public const TAX_QUALIFICATION_FIRST = 'tax_qualification1';

    /** @var string */
    public const TAX_QUALIFICATION_SECOND = 'tax_qualification2';

    /** @var string */
    public const TAX_QUALIFICATION_THIRD = 'tax_qualification3';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::TAX_QUALIFICATION_FIRST,
            self::TAX_QUALIFICATION_SECOND,
            self::TAX_QUALIFICATION_THIRD,
        ];
    }
}
