<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Repositories\ClientDocsAdditionalInfoRepository;
use App\Containers\AppSection\Client\Models\ClientDocsAdditionalInfo;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveClientDocsAdditionalInfoTask extends Task
{
    public function __construct(protected ClientDocsAdditionalInfoRepository $repository)
    {
    }

    public function run(int $clientId, int $mediaId, array $data = []): ClientDocsAdditionalInfo
    {
        try {
            return $this->repository->updateOrCreate([
                'client_id' => $clientId,
                'media_id'  => $mediaId,
            ], $data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
