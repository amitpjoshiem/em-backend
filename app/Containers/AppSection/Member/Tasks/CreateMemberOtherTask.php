<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Exceptions\WrongOtherRiskException;
use App\Containers\AppSection\Member\Models\MemberOther;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class CreateMemberOtherTask extends Task
{
    public function __construct(protected MemberRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     * @throws WrongOtherRiskException
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
            return $this->repository->createRelation($memberId, 'other', $otherData);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
