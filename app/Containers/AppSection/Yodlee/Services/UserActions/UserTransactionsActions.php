<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions;

use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeTransactionTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\UserActions\AccountTransactions\UserTransactionsCategoryActions;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use Illuminate\Support\Facades\Log;

class UserTransactionsActions extends UserAbstractAction implements UserActionInterface
{
    /**
     * @var string
     */
    private const TRANSACTION_URL = '%s/transactions';

    /**
     * @var string
     */
    private const TRANSACTION_COUNT_URL = '%s/transactions/count';

    /**
     * @var string
     */
    private const TRANSACTION_ID_URL = '%s/transactions/%d';

    public function categories(): UserTransactionsCategoryActions
    {
        return new UserTransactionsCategoryActions($this->token);
    }

    public function getAll(): array
    {
        $url      = sprintf(self::TRANSACTION_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!$response->successful() || !isset($content['transaction'])) {
            Log::error('User get Transactions Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t get User Transactions');
        }

        return $content['transaction'];
    }

    public function update(YodleeTransactionTransporter $input, int $id): void
    {
        $url      = sprintf(self::TRANSACTION_ID_URL, $this->url, $id);
        $this->sendRequest(YodleeApiService::HTTP_PUT, $url, $input->toArray());
    }

    public function count(): int
    {
        $url      = sprintf(self::TRANSACTION_COUNT_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['transaction']['TOTAL']['count'])) {
            Log::error('User get Transactions Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t get User Transactions');
        }

        return $content['transaction']['TOTAL']['count'];
    }
}
