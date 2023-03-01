<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

abstract class InputElement extends BasicElement
{
    /**
     * @var null
     */
    public const DEFAULT_VALUE = null;

    public static function hasDefaultValue(): bool
    {
        return true;
    }

    public function getPlaceholder(): string
    {
        $placeholders = config('appSection-assetsIncome.schema.placeholders');

        return $placeholders[$this->name];
    }
}
