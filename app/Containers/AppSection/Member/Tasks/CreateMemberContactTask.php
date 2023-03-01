<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class CreateMemberContactTask extends Task
{
    public function __construct(protected MemberRepository $repository)
    {
    }

    public function run(int $memberId, array $data, bool $isSpouse = false): MemberContact
    {
        try {
            return $this->repository->createRelation($memberId, 'contacts', array_merge($data, ['is_spouse' => $isSpouse]));
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
