<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\SubActions;

use App\Containers\AppSection\Member\Data\Repositories\MemberEmploymentHistoryRepository;
use App\Containers\AppSection\Member\Tasks\CreateEmploymentHistoryTask;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\SubAction;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdateEmploymentHistorySubAction extends SubAction
{
    public function __construct(protected MemberEmploymentHistoryRepository $repository)
    {
    }

    /**
     * @throws UpdateResourceFailedException
     * @throws ValidatorException
     */
    public function run(array $employmentHistory, int $modelId, string $type): void
    {
        foreach ($employmentHistory as $history) {
            if (!isset($history['id'])) {
                app(CreateEmploymentHistoryTask::class)->run($modelId, $type, [$history]);
                continue;
            }

            $id = $history['id'];
            unset($history['id']);

            try {
                $this->repository->update($history, $id);
            } catch (Exception $exception) {
                throw new UpdateResourceFailedException(previous: $exception);
            }
        }
    }
}
