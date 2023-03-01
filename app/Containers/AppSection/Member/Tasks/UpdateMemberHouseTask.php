<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberHouseRepository;
use App\Containers\AppSection\Member\Exceptions\WrongHouseTypeException;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;

class UpdateMemberHouseTask extends Task
{
    public function __construct(protected MemberHouseRepository $repository)
    {
    }

    /**
     * @throws WrongHouseTypeException|UpdateResourceFailedException
     */
    public function run(int $memberId, array $houseInfo): MemberHouse
    {
        if (isset($houseInfo['type']) && !\in_array($houseInfo['type'], [MemberHouse::RENT, MemberHouse::OWN, MemberHouse::FAMILY], true)) {
            throw new WrongHouseTypeException();
        }

        try {
            return $this->repository->updateOrCreate(['member_id' => $memberId], array_merge($houseInfo, ['member_id' => $memberId]));
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
