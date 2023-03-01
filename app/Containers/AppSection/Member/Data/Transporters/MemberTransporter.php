<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class MemberTransporter extends Transporter
{
    public ?string $name;

    public ?string $email;

    public ?string $birthday;

    public ?bool $retired;

    public ?bool $married;

    public ?string $phone;

    public ?string $retirement_date;

    public ?string $address;

    public ?string $city;

    public ?string $state;

    public ?string $zip;

    public ?int $user_id;

    public ?string $step;

    public ?string $notes;

    public ?string $amount_for_retirement;

    public ?string $biggest_financial_concern;

    public ?string $channels;

    public ?bool $is_watch;

    public ?float $total_net_worth;

    public ?float $goal;
}
