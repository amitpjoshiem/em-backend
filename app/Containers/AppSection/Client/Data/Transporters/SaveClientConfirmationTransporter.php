<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SaveClientConfirmationTransporter extends Transporter
{
    public ?array $currently_have;

    public ?array $more_info_about;

    public ?string $consultation;
}
