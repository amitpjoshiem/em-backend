<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (!function_exists('getFieldNameByValue')) {
    function getFieldNameByValue(int | string $value): string
    {
        return (is_numeric($value) || Str::isUuid($value)) ? 'id' : 'name';
    }
}
