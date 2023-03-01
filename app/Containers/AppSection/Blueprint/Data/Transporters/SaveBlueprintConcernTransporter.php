<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SaveBlueprintConcernTransporter extends Transporter
{
    public int $member_id;

    public ?bool $high_fees;

    public ?bool $extremely_high_market_exposure;

    public ?bool $simple;

    public ?bool $keep_the_money_safe;

    public ?bool $massive_overlap;

    public ?bool $design_implement_monitoring_income_strategy;
}
