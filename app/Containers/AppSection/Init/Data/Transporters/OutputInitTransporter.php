<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Init\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Database\Eloquent\Collection;

class OutputInitTransporter extends Transporter
{
    public Collection $roles;

    public string $user_id;

    public string $company_id;

    public ?string $advisor_id = null;

    public ?bool $terms_and_conditions = null;

    public ?string $member_type = null;

    public ?string $member_id = null;

    public ?bool $readonly = null;
}
