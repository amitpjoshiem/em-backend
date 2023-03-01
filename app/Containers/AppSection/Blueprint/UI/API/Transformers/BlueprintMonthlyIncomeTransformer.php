<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Transformers;

use App\Containers\AppSection\Blueprint\Data\Transporters\OutputBlueprintMonthlyIncomeTransporter;
use App\Ship\Parents\Transformers\Transformer;

class BlueprintMonthlyIncomeTransformer extends Transformer
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

    public function transform(OutputBlueprintMonthlyIncomeTransporter $blueprint): array
    {
        return [
            'current_member'        => $blueprint->current_member,
            'current_spouse'        => $blueprint->current_spouse,
            'current_pensions'      => $blueprint->current_pensions,
            'current_rental_income' => $blueprint->current_rental_income,
            'current_investment'    => $blueprint->current_investment,
            'future_member'         => $blueprint->future_member,
            'future_spouse'         => $blueprint->future_spouse,
            'future_pensions'       => $blueprint->future_pensions,
            'future_rental_income'  => $blueprint->future_rental_income,
            'future_investment'     => $blueprint->future_investment,
            'total'                 => $blueprint->total,
            'tax'                   => $blueprint->tax,
            'ira_first'             => $blueprint->ira_first,
            'ira_second'            => $blueprint->ira_second,
            'monthly_expenses'      => $blueprint->monthly_expenses,
            'created_at'            => $blueprint->created_at,
            'updated_at'            => $blueprint->updated_at,
        ];
    }
}
