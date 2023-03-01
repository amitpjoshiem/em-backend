<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Exceptions\IncorrectStepException;
use App\Ship\Parents\Tasks\Task;

class GetMemberStepOrder extends Task
{
    public function run(string $memberStep): int
    {
        if (!\in_array($memberStep, MemberStepsEnum::values(), true)) {
            throw new IncorrectStepException();
        }

        return (int)array_search($memberStep, MemberStepsEnum::values(), true);
    }
}
