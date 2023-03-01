<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class DocusignFileTransporter extends Transporter
{
    public string $b64file;

    public string $name;

    public string $extension;

    public string $id;
}
