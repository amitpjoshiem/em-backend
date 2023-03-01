<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\Member\Exceptions\WrongHouseTypeException;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateMemberHouseTask extends Task
{
    public function __construct(protected MemberRepository $repository)
    {
    }

    /**
     * @throws WrongHouseTypeException
     * @throws ValidatorException
     */
    public function run(int $memberId, array $houseInfo): MemberHouse
    {
        if (!\in_array($houseInfo['type'], [MemberHouse::RENT, MemberHouse::OWN, MemberHouse::FAMILY], true)) {
            throw new WrongHouseTypeException();
        }

        try {
            return $this->repository->createRelation($memberId, 'house', $houseInfo);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
