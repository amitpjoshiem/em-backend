<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class CreateSalesforceChildOpportunityTransporter extends Transporter
{
    public int $member_id;

    public ?string $type = null;

    public string $name;

    public ?string $stage = null;

    #[CastWith(DateTimeCaster::class)]
    public Carbon $close_date;

    public ?float $amount = null;
}
