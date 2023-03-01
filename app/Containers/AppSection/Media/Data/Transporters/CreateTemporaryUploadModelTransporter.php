<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Ramsey\Uuid\UuidInterface;

class CreateTemporaryUploadModelTransporter extends Transporter
{
    public UuidInterface $uuid;

    public string $collection;
}
