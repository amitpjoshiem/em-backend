<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleeCategoryRuleClauseTransporter extends Transporter
{
    public ?string $field;

    public ?string $operation;

    public ?string $value;
}
