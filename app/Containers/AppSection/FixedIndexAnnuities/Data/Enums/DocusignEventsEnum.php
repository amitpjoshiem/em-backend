<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class DocusignEventsEnum extends Enum
{
    /** @var string */
    public const RECIPIENT_COMPLETED = 'recipient-completed';

    /** @var string */
    public const ENVELOPE_COMPLETED = 'envelope-completed';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::RECIPIENT_COMPLETED,
            self::ENVELOPE_COMPLETED,
        ];
    }
}
