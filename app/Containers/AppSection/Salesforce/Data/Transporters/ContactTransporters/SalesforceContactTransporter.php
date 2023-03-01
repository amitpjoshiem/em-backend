<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Support\Carbon;

class SalesforceContactTransporter extends Transporter
{
    public string $ownerId;

    public ?string $name = '';

    public ?string $title = '';

    public ?string $phone = '';

    public ?Carbon $birthday = null;

    public ?string $account_id = '';

    public ?string $email = '';
}
