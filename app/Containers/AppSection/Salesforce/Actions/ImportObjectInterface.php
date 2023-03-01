<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use Carbon\CarbonImmutable;

interface ImportObjectInterface
{
    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void;
}
