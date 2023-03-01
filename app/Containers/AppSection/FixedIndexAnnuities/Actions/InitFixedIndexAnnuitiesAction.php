<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Enums\TaxQualificationEnum;
use App\Ship\Parents\Actions\Action;

class InitFixedIndexAnnuitiesAction extends Action
{
    public function run(): array
    {
        return [
            'tax_qualifications' => TaxQualificationEnum::values(),
        ];
    }
}
