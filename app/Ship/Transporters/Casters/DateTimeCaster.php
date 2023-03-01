<?php

declare(strict_types=1);

namespace App\Ship\Transporters\Casters;

use App\Ship\Exceptions\DateTimeCastException;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Caster;

class DateTimeCaster implements Caster
{
    public function cast(mixed $value): ?Carbon
    {
        if ($value === null) {
            return null;
        }
        try {
            $dateTime = Carbon::create($value);
        } catch (InvalidFormatException) {
            throw new DateTimeCastException();
        }
        if (!$dateTime) {
            throw new DateTimeCastException();
        }

        return $dateTime;
    }
}