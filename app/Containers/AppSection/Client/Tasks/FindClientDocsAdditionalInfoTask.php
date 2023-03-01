<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientDocsAdditionalInfoRepository;
use App\Containers\AppSection\Client\Models\ClientDocsAdditionalInfo;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindClientDocsAdditionalInfoTask extends Task
{
    public function __construct(protected ClientDocsAdditionalInfoRepository $repository)
    {
    }

    public function run(int $clientId, int $mediaId): ?ClientDocsAdditionalInfo
    {
        try {
            return $this->repository->findWhere([
                'client_id' => $clientId,
                'media_id'  => $mediaId,
            ])->first();
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
