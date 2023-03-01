<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions;

interface SaveImportedObjectInterface
{
    public function run(array $info, string $objectId, ?int $userId = null): void;
}
