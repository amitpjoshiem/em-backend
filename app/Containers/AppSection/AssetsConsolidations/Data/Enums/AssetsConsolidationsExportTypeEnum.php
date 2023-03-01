<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self excel()
 *
 * @property-read string $value
 */
class AssetsConsolidationsExportTypeEnum extends Enum
{
    /** @var string */
    public const EXCEL = 'excel';

    protected static function values(): array
    {
        return [
            'excel' => self::EXCEL,
        ];
    }
}
