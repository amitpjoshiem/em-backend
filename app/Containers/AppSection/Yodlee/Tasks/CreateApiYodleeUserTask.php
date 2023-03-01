<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Tasks;

use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeUserTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\YodleeAdminApiService;
use App\Ship\Parents\Tasks\Task;

class CreateApiYodleeUserTask extends Task
{
    public function __construct(protected YodleeAdminApiService $apiService)
    {
    }

    /**
     * @throws BaseException
     */
    public function run(YodleeUserTransporter $data): array
    {
        return $this->apiService->createUser($data);
    }
}
