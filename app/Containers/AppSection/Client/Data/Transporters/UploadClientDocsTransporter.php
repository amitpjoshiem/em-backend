<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UploadClientDocsTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public string $collection;

    public ?string $name;

    public ?string $type;

    public ?string $description;

    public ?bool $is_spouse;
}
