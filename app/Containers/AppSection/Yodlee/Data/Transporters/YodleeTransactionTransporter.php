<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleeTransactionTransporter extends Transporter
{
    public ?string $categorySource;

    public ?string $container;

    public ?YodleeTransactionDescriptionTransporter $description;

    public ?string $memo;

    public ?int $categoryId;
}
