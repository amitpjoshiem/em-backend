<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\Salesforce\Services\Objects\AbstractObject;

/**
 * @property int     $id
 * @property ?string $salesforce_id
 */
interface SalesforceObjectInterface
{
    public function api(): AbstractObject;

    public static function prepareSalesforceData(int $id, bool $isUpdate): array;

    /** @psalm-suppress MissingReturnType */
    public function getKey();

    public function getSalesforceId(): ?string;
}
