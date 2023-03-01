<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Support\Carbon;

class SalesforceAccountTransporter extends Transporter
{
    public string $ownerId;

    public ?string $name;

    public ?string $phone;

    public ?Carbon $birthday;

    public ?string $email;

    public ?string $type;

    public ?string $address;

    public ?string $city;

    public ?string $state;

    public ?string $zip;
}
