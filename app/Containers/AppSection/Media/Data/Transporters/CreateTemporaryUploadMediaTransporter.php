<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Transporters;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Http\UploadedFile;

class CreateTemporaryUploadMediaTransporter extends Transporter
{
    public ?UploadedFile $file = null;

    public array $files = [];

    public string $collection = MediaCollectionEnum::DEFAULT;
}
