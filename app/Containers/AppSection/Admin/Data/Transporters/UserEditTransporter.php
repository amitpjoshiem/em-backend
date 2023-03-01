<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UserEditTransporter extends Transporter
{
    public int $id;

    public string $first_name;

    public string $last_name;

    public string $position;

    public int $role;

    public int $company_id;

    public ?string $phone = null;

    public ?string $npn = null;

    public ?array $advisors;
}
