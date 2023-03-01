<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class ShareBlueprintDocTransporter extends Transporter
{
    public int $doc_id;

    public array $emails;
}
