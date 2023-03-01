<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Transporters\Transporter;

class OutputClientHelpTransporter extends Transporter
{
    public ?Media $media;

    public string $type;

    public ?string $text;
}
