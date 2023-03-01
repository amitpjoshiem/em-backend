<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberReportRepository;
use App\Containers\AppSection\Member\Models\MemberReport;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindMemberReportByIdTask extends Task
{
    public function __construct(protected MemberReportRepository $repository)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function run(int $id): MemberReport
    {
        try {
            $memberReport = $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }

        if ($memberReport === null) {
            throw new NotFoundException();
        }

        return $memberReport;
    }
}
