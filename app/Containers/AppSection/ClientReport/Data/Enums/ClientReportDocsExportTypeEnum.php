<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self excel()
 *
 * @property-read string $value
 */
class ClientReportDocsExportTypeEnum extends Enum
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
