<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class DocusignWebhookTransporter extends Transporter
{
    public string $event;

    public array $data;
}
