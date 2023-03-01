<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllMediaByTemporaryUploadUuidsTransporter extends Transporter
{
    /** @var array<string> */
    public array $uuids = [];

    public ?string $collection = null;
}
