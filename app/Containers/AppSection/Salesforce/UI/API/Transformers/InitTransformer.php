<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class InitTransformer extends Transformer
{
    public function transform(object $init): array
    {
        return [
            'init' => [
                'stage_list'    => $init->stageList,
                'type_list'     => $init->typeList,
            ],
        ];
    }
}
