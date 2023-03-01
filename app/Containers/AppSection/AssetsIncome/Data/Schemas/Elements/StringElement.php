<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

final class StringElement extends InputElement
{
    /**
     * @var string
     */
    public const TYPE = 'string';

    public function getType(): string
    {
        return self::TYPE;
    }
}
