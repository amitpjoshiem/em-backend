<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions\AccountTransactions;

use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeTransactionCategoryTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserAbstractAction;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserActionInterface;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use Illuminate\Support\Facades\Log;

class UserTransactionsCategoryActions extends UserAbstractAction implements UserActionInterface
{
    /**
     * @var string
     */
    private const TRANSACTION_CATEGORY_ID_URL = '%s/transactions/categories/$d';

    /**
     * @var string
     */
    private const TRANSACTION_CATEGORY_URL = '%s/transactions/categories';

    public function create(YodleeTransactionCategoryTransporter $input): void
    {
        $url      = sprintf(self::TRANSACTION_CATEGORY_URL, $this->url);
        $this->sendRequest(YodleeApiService::HTTP_POST, $url, $input->toArray());
    }

    public function getAll(): array
    {
        $url      = sprintf(self::TRANSACTION_CATEGORY_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['transactionCategory'])) {
            Log::error('User GetAll Transactions Category Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t GetAll User Transactions Category');
        }

        return $content['transactionCategory'];
    }

    public function update(YodleeTransactionCategoryTransporter $input, int $id): void
    {
        $input       = $input->toArray();
        $input['id'] = $id;
        $url         = sprintf(self::TRANSACTION_CATEGORY_URL, $this->url);
        $this->sendRequest(YodleeApiService::HTTP_PUT, $url, $input);
    }

    public function delete(int $id): void
    {
        $url      = sprintf(self::TRANSACTION_CATEGORY_ID_URL, $this->url, $id);
        $this->sendRequest(YodleeApiService::HTTP_DELETE, $url);
    }

    public function rules(): UserTransactionsCategorizationRulesActions
    {
        return new UserTransactionsCategorizationRulesActions($this->token);
    }
}
