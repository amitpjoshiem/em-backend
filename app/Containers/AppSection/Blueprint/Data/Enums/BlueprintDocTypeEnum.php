<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self pdf()
 *
 * @property-read string $value
 */
class BlueprintDocTypeEnum extends Enum
{
    /** @var string */
    public const PDF = 'pdf';

    /** @var string */
    public const EXCEL = 'excel';

    protected static function values(): array
    {
        return [
            'pdf'   => self::PDF,
            'excel' => self::EXCEL,
        ];
    }
}
