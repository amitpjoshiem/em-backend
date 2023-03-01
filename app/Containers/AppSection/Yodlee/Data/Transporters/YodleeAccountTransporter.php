<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleeAccountTransporter extends Transporter
{
    public ?string $accountType;

    public ?string $accountName;

    public ?string $nickname;

    public ?string $accountNumber;

    public ?YodleeAccountBalanceTransporter $balance;

    public ?string $includeInNetWorth;

    public ?string $memo;
}
