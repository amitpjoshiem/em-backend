<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

final class TotalElement extends InputElement
{
    /**
     * @var string
     */
    public const TYPE = 'total';

    public function getType(): string
    {
        return self::TYPE;
    }
}
