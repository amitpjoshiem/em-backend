<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class OutputClientDocsTransporter extends Transporter
{
    public string $status;

    public MediaCollection $documents;
}
