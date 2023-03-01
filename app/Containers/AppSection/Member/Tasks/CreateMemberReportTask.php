<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberReportRepository;
use App\Containers\AppSection\Member\Models\MemberReport;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateMemberReportTask extends Task
{
    public function __construct(protected MemberReportRepository $repository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(array $reportData): MemberReport
    {
        try {
            return $this->repository->create($reportData);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
