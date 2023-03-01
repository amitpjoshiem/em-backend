<?php

declare(strict_types=1);

namespace App\Ship\Transporters\Casters;

use App\Ship\Exceptions\DateTimeCastException;
use App\Ship\Exceptions\StringToNumberCastException;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Caster;

class PercentToFloatCaster implements Caster
{

    public function cast(mixed $value): float
    {
        if (!is_numeric($value)) {
            throw new StringToNumberCastException();
        }

        return (float)($value / 100);
    }
}