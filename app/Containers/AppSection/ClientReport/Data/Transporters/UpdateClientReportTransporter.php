<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateClientReportTransporter extends Transporter
{
    public int $id;

    public ?string $carrier = null;

    public int $contract_number;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $origination_date = null;

    public ?CurrentYearClientReportTransporter $current_year = null;

    public ?SinceInceptionClientReportTransporter $since_inception = null;

    public ?float $total_fees = null;

    public ?float $rmd_or_sys_wd = null;
}
