<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Transporters;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Http\UploadedFile;

class CreateMediaByOneFileTransporter extends Transporter
{
    public UploadedFile $file;

    public HasInteractsWithMedia $model;

    public string $collection;
}
