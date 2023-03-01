<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateSalesforceAnnualReviewTransporter extends Transporter
{
    public ?string $name;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $review_date;

    public ?float $amount;

    public ?string $type;

    public ?string $new_money;

    public ?string $notes;
}
