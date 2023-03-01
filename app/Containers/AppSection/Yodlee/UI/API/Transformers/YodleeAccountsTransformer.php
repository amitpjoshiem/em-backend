<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use Hashids;

class YodleeAccountsTransformer extends Transformer
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

    public function transform(array $account): array
    {
        $balance = 0;

        if (isset($account['balance'])) {
            $balance = $account['balance']['amount'] . ' ' . $account['balance']['currency'];
        } elseif (isset($account['rewardBalance'])) {
            $balance = $account['rewardBalance'][0]['balance'] . ' ' . $account['rewardBalance'][0]['units'];
        }

        return [
            'id'        => Hashids::encode($account['id']),
            'container' => $account['CONTAINER'],
            'name'      => $account['accountName'] ?? '-',
            'status'    => $account['accountStatus'],
            'balance'   => $balance,
            'type'      => $account['accountType'],
        ];
    }
}
