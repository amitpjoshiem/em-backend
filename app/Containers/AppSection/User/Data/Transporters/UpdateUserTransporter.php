<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UpdateUserTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public int $id;

    public ?string $username;

    public ?string $first_name;

    public ?string $last_name;

    public ?int $company_id;

    public ?string $data_source;
}
