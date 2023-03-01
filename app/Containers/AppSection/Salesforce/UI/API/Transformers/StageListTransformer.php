<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class StageListTransformer extends Transformer
{
    public function transform(object $stageList): array
    {
        return [
            'stage_list' => $stageList,
        ];
    }
}
