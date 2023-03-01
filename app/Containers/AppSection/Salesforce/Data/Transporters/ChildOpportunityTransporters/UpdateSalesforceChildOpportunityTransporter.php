<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateSalesforceChildOpportunityTransporter extends Transporter
{
    public int $id;

    public ?string $type;

    public ?string $stage;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $close_date;

    public ?string $amount;

    public ?string $name;
}
