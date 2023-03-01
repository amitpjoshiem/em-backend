<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateOpportunityStageTransporter extends Transporter
{
    public int $member_id;

    public string $stage;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $date_of_1st;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $date_of_2nd;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $date_of_3rd;

    public ?string $result_1st_appt;

    public ?string $result_2nd_appt;

    public ?string $result_3rd_appt;

    public ?string $status_1st_appt;

    public ?string $status_2nd_appt;

    public ?string $status_3rd_appt;

    public ?string $closed_status;
}
