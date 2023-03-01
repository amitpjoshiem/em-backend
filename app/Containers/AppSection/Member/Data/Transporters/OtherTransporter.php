<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class OtherTransporter extends Transporter
{
    public ?int $member_id;

    public ?string $questions;

    public ?string $retirement_money;

    public ?string $retirement;

    public ?string $risk;

    public ?bool $work_with_advisor;
}
