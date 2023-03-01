<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class CreateEmploymentHistoryTask extends Task
{
    public function __construct(
        protected MemberRepository $MemberRepository,
        protected MemberContactRepository $MemberContactRepository
    ) {
    }

    public function run(int $memberId, string $type, array $employmentHistory): void
    {
        foreach ($employmentHistory as $key => &$history) {
            if (empty($history['company_name'])) {
                unset($employmentHistory[$key]);
                continue;
            }

            $history['years'] = (int)$history['years'];
        }

        /** @var MemberRepository | MemberContactRepository $repository */
        $repository        = $this->{$type . 'Repository'};
        $employmentHistory = $this->removeEmptyEmploymentHistory($employmentHistory);

        try {
            $repository->createManyRelation($memberId, 'employmentHistory', $employmentHistory);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }

    private function removeEmptyEmploymentHistory(array $employmentHistory): array
    {
        foreach ($employmentHistory as $key => $history) {
            if (
                empty($history[MemberEmploymentHistory::COMPANY_NAME]) &&
                empty($history[MemberEmploymentHistory::OCCUPATION]) &&
                empty($history[MemberEmploymentHistory::YEARS])
            ) {
                unset($employmentHistory[$key]);
            }
        }

        return $employmentHistory;
    }
}
