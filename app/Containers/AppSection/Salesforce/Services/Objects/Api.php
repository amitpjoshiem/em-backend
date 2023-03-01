<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\ApiRequestException;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\SalesforceAuthException;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceCreateException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceDescribeException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceFindException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceQueryAllException;
use  App\Containers\AppSection\Salesforce\Exceptions\SalesforceUserNotLoggedInException;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JsonException;

abstract class Api
{
    /**
     * @var string
     */
    public const TOKEN_CACHE_KEY = 'salesforce:token';

    /**
     * @var string
     */
    public const INSTANCE_CACHE_KEY = 'salesforce:instance_url';

    /**
     * @var string
     *
     * @param string InstanceUrl
     * @param string ApiVersion
     * @param string Object
     * @param string SalesforceID
     */
    private const PRINTF_API_OBJECT_URL = '%s/services/data/v%s/sobjects/%s/%s';

    /**
     * @var string
     *
     * @param string InstanceUrl
     * @param string ApiVersion
     */
    private const PRINTF_API_QUERY_ALL_URL = '%s/services/data/v%s/queryAll/';

    /**
     * @var string
     */
    private const PRINTF_API_QUERY_URL = '%s/services/data/v%s/query/';

    private string $apiVer;

    abstract public function getObjectName(): string;

    /**
     * @throws FindSalesforceAccountException
     */
    public function __construct()
    {
        $this->apiVer = config('appSection-salesforce.api_version');

        if (!$this->isAuthenticated()) {
            $this->authenticate();
        }
    }

    protected function getToken(): string
    {
        $token = Cache::get(self::TOKEN_CACHE_KEY);

        if ($token === null) {
            throw new SalesforceAuthException();
        }

        return $token;
    }

    protected function getInstance(): string
    {
        $instance = Cache::get(self::INSTANCE_CACHE_KEY);

        if ($instance === null) {
            throw new SalesforceAuthException();
        }

        return $instance;
    }

    protected function isAuthenticated(): bool
    {
        return Cache::has(self::TOKEN_CACHE_KEY);
    }

    /**
     * @throws ApiRequestException
     */
    protected function authenticate(): void
    {
        $url  = config('appSection-salesforce.login_url');
        $data = [
            'grant_type'        => 'password',
            'client_id'         => config('appSection-salesforce.clientId'),
            'client_secret'     => config('appSection-salesforce.clientSecret'),
            'username'          => config('appSection-salesforce.username'),
            'password'          => config('appSection-salesforce.password'),
        ];
        /** @var Response $response */
        $response = Http::withHeaders([
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Accept'        => 'application/json',
        ])->asForm()->post($url, $data);

        if (!$response->successful()) {
            throw new ApiRequestException('post', $url, $response->json(), $data, true);
        }

        $content = $response->json();

        Cache::set(self::TOKEN_CACHE_KEY, $content['access_token'], config('appSection-salesforce.token_ttl'));
        Cache::set(self::INSTANCE_CACHE_KEY, $content['instance_url'], config('appSection-salesforce.token_ttl'));
    }

    /**
     * @throws ApiRequestException
     * @throws SalesforceAuthException
     */
    protected function sendRequest(string $method, string $object, array $data = [], string $salesforceId = ''): Response
    {
        $url = sprintf(
            self::PRINTF_API_OBJECT_URL,
            $this->getInstance(),
            $this->apiVer,
            $object,
            $salesforceId
        );

        /** @var Response $response */
        $response = Http::withToken($this->getToken())->withHeaders([
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ])->asJson()->{$method}($url, $data);

        if (!$response->successful()) {
            throw new ApiRequestException($method, $url, $response->json(), $data);
        }

        return $response;
    }

    /**
     * @throws JsonException|SalesforceQueryAllException
     */
    protected function queryAll(string $query): array
    {
        $url      = sprintf(self::PRINTF_API_QUERY_ALL_URL, $this->getInstance(), $this->apiVer);
        $data     = ['q' => $query];
        $response = Http::withToken($this->getToken())->withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->asJson()->get($url, $data);

        if (!$response->successful()) {
            throw new ApiRequestException('get', $url, $response->json(), $data);
        }

        return $response->json();
    }

    /**
     * @throws JsonException|SalesforceQueryAllException
     */
    protected function query(string $query): array
    {
        $url      = sprintf(self::PRINTF_API_QUERY_URL, $this->getInstance(), $this->apiVer);
        $data     = ['q' => $query];
        $response = Http::withToken($this->getToken())->withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->asJson()->get($url, $data);

        if (!$response->successful()) {
            throw new ApiRequestException('get', $url, $response->json(), $data);
        }

        return $response->json();
    }

    /**
     * @throws SalesforceCreateException
     * @throws JsonException
     * @throws SalesforceUserNotLoggedInException
     */
    protected function createObject(array $data): string
    {
        $response    = $this->sendRequest('post', $this->getObjectName(), $data);

        $content = $response->json();

        return $content['id'];
    }

    protected function updateObject(string $objectId, array $data): Response
    {
        return $this->sendRequest(
            'patch',
            $this->getObjectName(),
            $data,
            $objectId
        );
    }

    /**
     * @throws SalesforceFindException
     * @throws JsonException
     */
    protected function getObjectById(string $objectId): array
    {
        $response = $this->sendRequest('get', $this->getObjectName(), salesforceId: $objectId);

        return $response->json();
    }

    protected function deleteObject(string $objectId): Response
    {
        return $this->sendRequest('delete', $this->getObjectName(), salesforceId: $objectId);
    }

    /**
     * @throws JsonException
     * @throws SalesforceDescribeException
     */
    protected function describeObject(): array
    {
        $response = $this->sendRequest('get', $this->getObjectName(), salesforceId: 'describe');

        return $response->json();
    }

    protected function getUpdatedObjects(CarbonImmutable $startDate, CarbonImmutable $endDate): array
    {
        $data = [
            'start' => $startDate->format('Y-m-d\TH:i:s\z'),
            'end'   => $endDate->format('Y-m-d\TH:i:s\z'),
        ];
        $response    = $this->sendRequest('get', $this->getObjectName(), $data, 'updated');

        return $response->json();
    }

    protected function getDeletedObjects(CarbonImmutable $startDate, CarbonImmutable $endDate): array
    {
        $data = [
            'start' => $startDate->format('Y-m-d\TH:i:s\z'),
            'end'   => $endDate->format('Y-m-d\TH:i:s\z'),
        ];
        $response    = $this->sendRequest('get', $this->getObjectName(), $data, 'deleted');

        return $response->json();
    }

    public function status(): void
    {
        $this->authenticate();
    }
}
