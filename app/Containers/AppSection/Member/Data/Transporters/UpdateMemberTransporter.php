<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateMemberTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public int $id;

    public ?string $name;

    public ?string $email;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $birthday;

    public ?bool $retired;

    public ?bool $married;

    public ?string $phone;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $retirement_date;

    public ?string $address;

    public ?string $city;

    public ?string $state;

    public ?string $zip;

    public ?string $notes;

    public ?float $total_net_worth;

    public ?float $goal;

    public ?string $amount_for_retirement;

    public ?string $biggest_financial_concern;

    public ?string $channels;

    public ?bool $is_watch;

    public ?HouseTransporter $house;

    public ?OtherTransporter $other;

    public ?SpouseTransporter $spouse;

    public ?array $employment_history;
}
