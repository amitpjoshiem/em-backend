<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class UpdateMemberContactTask extends Task
{
    public function __construct(protected MemberContactRepository $repository)
    {
    }

    public function run(int $memberId, array $spouseData): MemberContact
    {
        try {
            return $this->repository->updateOrCreate(['member_id' => $memberId], array_merge($spouseData, ['member_id' => $memberId]));
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
