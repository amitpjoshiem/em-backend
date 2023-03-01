<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters\Contacts;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\DateTimeCaster;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateContactTransporter extends Transporter
{
    public int $id;

    public ?string $name;

    public ?string $first_name;

    public ?string $last_name;

    public ?string $email;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $birthday;

    public ?bool $retired;

    public ?string $phone;

    #[CastWith(DateTimeCaster::class)]
    public ?Carbon $retirement_date;

    public ?int $member_id;

    public ?array $employment_history;

    public ?bool $is_spouse;
}
