<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class CreateSalesforceAnnualReviewTransporter extends Transporter
{
    public string $name;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $review_date = null;

    public ?float $amount = null;

    public ?string $type = null;

    public ?string $new_money = null;

    public ?string $notes = null;
}
