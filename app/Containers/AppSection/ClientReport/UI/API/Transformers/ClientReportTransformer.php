<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Transformers;

use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Ship\Parents\Transformers\Transformer;

class ClientReportTransformer extends Transformer
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

    public function transform(ClientReport $clientReport): array
    {
        return [
            'id'                  => $clientReport->getHashedKey(),
            'member_id'           => $clientReport->member->getHashedKey(),
            'carrier'             => $clientReport->carrier,
            'contract_number'     => $clientReport->contract_number,
            'origination_date'    => $clientReport->origination_date?->format('Y-m-d'),
            'contract_year'       => $clientReport->contract_years,
            'current_year'        => [
                'beginning_balance'     => $clientReport->origination_value,
                'interest_credited'     => $clientReport->current_interest_credited,
                'growth'                => $clientReport->origination_value + $clientReport->current_interest_credited,
                'withdrawals'           => $clientReport->withdrawals,
                'contract_value'        => ($clientReport->origination_value + $clientReport->current_interest_credited + $clientReport->withdrawals) / 3,
            ],
            'since_inception' => [
                'total_premiums'     => $clientReport->total_premiums,
                'bonus_received'     => $clientReport->bonus_received,
                'interest_credited'  => $clientReport->since_interest_credited,
                'total_withdrawals'  => $clientReport->total_withdrawals,
                'average_growth'     => ($clientReport->total_premiums + $clientReport->bonus_received + $clientReport->since_interest_credited + $clientReport->total_withdrawals) / 4,
            ],
            'total_fees'    => $clientReport->total_fees,
            'rmd_or_sys_wd' => $clientReport->rmd_or_sys_wd,
            'is_custom'     => $clientReport->is_custom,
        ];
    }
}
