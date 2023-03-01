<?php

declare(strict_types=1);

namespace App\Ship\Parents\Traits;

trait RequestWithoutRulesTrait
{
    /**
     * Stub. Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [];
    }
}
