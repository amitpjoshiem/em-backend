<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleeAccountBalanceTransporter extends Transporter
{
    public ?int $amount;

    public ?string $currency;
}
