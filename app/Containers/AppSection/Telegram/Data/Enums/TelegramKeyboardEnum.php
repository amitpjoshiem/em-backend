<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class TelegramKeyboardEnum extends Enum
{
    /** @var string */
    public const SALESFORCE_IMPORT_STATUS = 'Salesforce Import Status';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::SALESFORCE_IMPORT_STATUS,
        ];
    }
}
