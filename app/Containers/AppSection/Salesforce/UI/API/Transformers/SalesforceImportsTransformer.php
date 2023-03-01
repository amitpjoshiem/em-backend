<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Containers\AppSection\Salesforce\Models\SalesforceImport;
use App\Ship\Parents\Transformers\Transformer;

class SalesforceImportsTransformer extends Transformer
{
    public function transform(SalesforceImport $import): array
    {
        return [
            'object'    => $import->getObjectName(),
            'start_job' => $import->start_date->timestamp,
            'end_job'   => $import->end_date->timestamp,
        ];
    }
}
