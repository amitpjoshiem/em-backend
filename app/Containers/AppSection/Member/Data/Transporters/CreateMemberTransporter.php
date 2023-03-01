<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class CreateMemberTransporter extends Transporter
{
    public string $name;

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

    public ?array $house;

    public ?array $other;

    public ?SpouseTransporter $spouse;

    public ?array $employment_history;
}
