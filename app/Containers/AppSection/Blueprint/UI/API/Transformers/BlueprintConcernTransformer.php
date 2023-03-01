<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Transformers;

use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Ship\Parents\Transformers\Transformer;

class BlueprintConcernTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(BlueprintConcern $blueprint): array
    {
        return [
            'id'                                            => $blueprint->getHashedKey(),
            'high_fees'                                     => $blueprint->high_fees,
            'extremely_high_market_exposure'                => $blueprint->extremely_high_market_exposure,
            'simple'                                        => $blueprint->simple,
            'keep_the_money_safe'                           => $blueprint->keep_the_money_safe,
            'massive_overlap'                               => $blueprint->massive_overlap,
            'design_implement_monitoring_income_strategy'   => $blueprint->design_implement_monitoring_income_strategy,
            'created_at'                                    => $blueprint->created_at->toISOString(),
            'updated_at'                                    => $blueprint->updated_at->toISOString(),
        ];
    }
}
