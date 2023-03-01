<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

final class Ping extends Api
{
    /**
     * @var string
     */
    private const OBJECT_NAME = 'Ping';

    public function getObjectName(): string
    {
        return self::OBJECT_NAME;
    }
}
