<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

final class RadioElement extends BasicElement
{
    /**
     * @var string
     */
    public const TYPE = 'radio';

    /**
     * @var bool
     */
    public const DEFAULT_VALUE = false;

    public function getType(): string
    {
        return self::TYPE;
    }

    public static function hasDefaultValue(): bool
    {
        return true;
    }
}
