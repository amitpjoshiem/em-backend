<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Database\Eloquent\Collection;

class OutputClientConfirmationTransporter extends Transporter
{
    public Collection $currently_have;

    public Collection $more_info_about;

    public ?string $consultation;
}
