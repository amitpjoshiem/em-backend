<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Values;

use App\Ship\Parents\Values\Value;
use Locale;

class Region extends Value
{
    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'regions';

    public function __construct(private string $region)
    {
    }

    public function getDefaultName(): string
    {
        return Locale::getDisplayRegion($this->region, config('app.locale'));
    }

    public function getLocaleName(): string
    {
        return Locale::getDisplayRegion($this->region, $this->region);
    }

    public function getRegion(): string
    {
        return $this->region;
    }
}
