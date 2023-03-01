<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class ShareClientReportDocTransporter extends Transporter
{
    public int $doc_id;

    public array $emails;
}
