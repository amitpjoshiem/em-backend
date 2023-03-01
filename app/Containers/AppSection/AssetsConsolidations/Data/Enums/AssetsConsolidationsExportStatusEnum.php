<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self success()
 * @method static self error()
 * @method static self process()
 *
 * @property-read string $value
 */
class AssetsConsolidationsExportStatusEnum extends Enum
{
    /** @var string */
    public const SUCCESS = 'success';

    /** @var string */
    public const ERROR = 'error';

    /** @var string */
    public const PROCESS = 'process';

    protected static function values(): array
    {
        return [
            'success'   => self::SUCCESS,
            'error'     => self::ERROR,
            'process'   => self::PROCESS,
        ];
    }
}
