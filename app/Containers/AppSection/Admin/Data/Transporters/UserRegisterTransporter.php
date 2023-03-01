<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UserRegisterTransporter extends Transporter
{
    public string $first_name;

    public string $last_name;

    public string $email;

    public string $username;

    public ?string $position;

    public string $phone;

    public ?string $npn;

    public int $role;

    public int $company_id;

    public ?string $password = null;

    public ?array $advisors = [];
}
