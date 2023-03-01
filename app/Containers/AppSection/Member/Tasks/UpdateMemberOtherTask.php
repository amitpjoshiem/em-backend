<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberOtherRepository;
use App\Containers\AppSection\Member\Exceptions\WrongOtherRiskException;
use App\Containers\AppSection\Member\Models\MemberOther;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class UpdateMemberOtherTask extends Task
{
    public function __construct(protected MemberOtherRepository $repository)
    {
    }

    /**
     * @throws UpdateResourceFailedException|WrongOtherRiskException
     */
    public function run(int $memberId, array $otherData): MemberOther
    {
        if (!\in_array($otherData['risk'], [
            MemberOther::AGGRESSIVE,
            MemberOther::CONSERVATIVE,
            MemberOther::MODERATE,
            MemberOther::MODERATELY_AGGRESSIVE,
            MemberOther::MODERATELY_CONSERVATIVE,
        ], true)) {
            throw new WrongOtherRiskException();
        }

        try {
            return $this->repository->updateOrCreate(['member_id' => $memberId], array_merge($otherData, ['member_id' => $memberId]));
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
