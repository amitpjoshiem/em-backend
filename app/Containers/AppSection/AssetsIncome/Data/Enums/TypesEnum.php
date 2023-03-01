<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Enums;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\DropdownElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\NumberElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\RadioElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\StringElement;
use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self string()
 * @method static self dropdown()
 * @method static self radio()
 * @method static self number()
 *
 * @property-read string $value
 */
class TypesEnum extends Enum
{
    /** @var string */
    public const STRING = StringElement::class;

    /** @var string */
    public const DROPDOWN = DropdownElement::class;

    /** @var string */
    public const RADIO = RadioElement::class;

    /** @var string */
    public const NUMBER = NumberElement::class;

    protected static function values(): array
    {
        return [
            'string'   => self::STRING,
            'dropdown' => self::DROPDOWN,
            'radio'    => self::RADIO,
            'number'   => self::NUMBER,
        ];
    }

    public static function types(): array
    {
        return array_keys(self::values());
    }
}
