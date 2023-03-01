<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\ToStringCaster;
use Spatie\DataTransferObject\Attributes\CastWith;

class SaveDataTransporter extends Transporter
{
    public int $member_id;

    public string $group;

    public string $row;

    public string $element;

    public string $type;

    #[CastWith(ToStringCaster::class)]
    public ?string $value = null;

    public ?bool $joined;

    public ?bool $can_join;

    public ?string $parent;
}
