<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class PartnersHealthcheckTransporter extends Transporter
{
    public bool $salesforce = true;

    public bool $yodlee = true;

    public bool $hiddenlevers = true;
}
