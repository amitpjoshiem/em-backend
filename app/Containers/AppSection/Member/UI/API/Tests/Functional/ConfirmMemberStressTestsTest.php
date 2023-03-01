<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;

class ConfirmMemberStressTestsTest extends ApiTestCase
{
    use TestsUploadHelperTrait;

    protected string $endpoint = 'post@v1/members/stress_test/{member_id}/confirm';

    /**
     * test.
     */
    public function testConfirmStressTestStep(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member   = $this->registerMember($user->getKey());
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();
        $this->assertDatabaseHas('members', [
            'id'    => $member->getKey(),
            'step'  => MemberStepsEnum::STRESS_TEST,
        ]);
    }
}
