<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

final class NumberElement extends InputElement
{
    /**
     * @var string
     */
    public const TYPE = 'number';

    public function getType(): string
    {
        return self::TYPE;
    }
}
