<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions\AccountTransactions;

use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeCategoryRuleTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserAbstractAction;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserActionInterface;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use Illuminate\Support\Facades\Log;

class UserTransactionsCategorizationRulesActions extends UserAbstractAction implements UserActionInterface
{
    /**
     * @var string
     */
    private const TRANSACTIONS_CATEGORY_RULE_URL = '%s/transactions/categories/rules';

    /**
     * @var string
     */
    private const TRANSACTIONS_CATEGORY_RULE_ID_URL = '%s/transactions/categories/rules/%d';

    /**
     * @var string
     */
    private const GET_ALL_TRANSACTIONS_CATEGORY_RULE_URL = '%s/transactions/categories/txnRules';

    public function create(YodleeCategoryRuleTransporter $input): void
    {
        $url      = sprintf(self::TRANSACTIONS_CATEGORY_RULE_URL, $this->url) . '?ruleParam=' . json_encode(['rule' => $input->toArray()], JSON_THROW_ON_ERROR);
        $this->sendRequest(YodleeApiService::HTTP_POST, $url);
    }

    public function run(int $id): void
    {
        $url      = sprintf(self::TRANSACTIONS_CATEGORY_RULE_ID_URL, $this->url, $id);
        $this->sendRequest(YodleeApiService::HTTP_GET, $url);
    }

    public function delete(int $id): void
    {
        $url      = sprintf(self::TRANSACTIONS_CATEGORY_RULE_ID_URL, $this->url, $id);
        $this->sendRequest(YodleeApiService::HTTP_DELETE, $url);
    }

    public function update(YodleeCategoryRuleTransporter $input, int $id): void
    {
        $url      = sprintf(self::TRANSACTIONS_CATEGORY_RULE_ID_URL, $this->url, $id);
        $this->sendRequest(YodleeApiService::HTTP_PUT, $url, ['rule' => $input->toArray()]);
    }

    public function getAll(): array
    {
        $url      = sprintf(self::GET_ALL_TRANSACTIONS_CATEGORY_RULE_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['txnRules'])) {
            Log::error('User Update Transactions Category Rule Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t Update User Transactions Rule Category');
        }

        return $content['txnRules'];
    }
}
