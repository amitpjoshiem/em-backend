<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleePreferenceTransporter extends Transporter
{
    public string $currency = 'USD';

    public string $timeZone = 'GMT-7';

    public string $dateFormat = '01/01/1970';

    public string $locale = 'en_US';
}
