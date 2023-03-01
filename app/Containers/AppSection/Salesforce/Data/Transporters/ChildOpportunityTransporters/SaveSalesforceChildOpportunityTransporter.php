<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class SaveSalesforceChildOpportunityTransporter extends Transporter
{
    public ?int $member_id;

    public ?string $salesforce_id;

    public ?int $salesforce_opportunity_id;

    public ?float $amount;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $created_at;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $close_date;

    public ?string $stage;

    public ?string $name;

    public ?string $type;

    public ?int $user_id;
}
