<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Events\Events;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Ship\Parents\Events\Event;

class GenerateExcelExportEvent extends Event
{
    public function __construct(public AssetsConsolidationsExport $export)
    {
    }
}
