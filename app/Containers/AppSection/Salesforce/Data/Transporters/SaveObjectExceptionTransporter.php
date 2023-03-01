<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Exception;

class SaveObjectExceptionTransporter extends Transporter
{
    public string $salesforce_id;

    public string $object;

    public array $salesforceData;

    public Exception $exception;
}
