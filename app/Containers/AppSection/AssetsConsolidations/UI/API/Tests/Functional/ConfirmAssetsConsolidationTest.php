<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\User\Models\User;

class ConfirmAssetsConsolidationTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/assets_consolidations/{member_id}/confirm';

    /**
     * @test
     */
    public function testConfirmAssetsConsolidationStep(): void
    {
        /** @var User $user */
        $user     = $this->getTestingUser();
        $member   = $this->registerMember($user->getKey());
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        if ($member->step === MemberStepsEnum::STRESS_TEST) {
            $this->assertDatabaseHas('members', [
                'id'   => $member->getKey(),
                'step' => MemberStepsEnum::STRESS_TEST,
            ]);
        } else {
            $this->assertDatabaseHas('members', [
                'id'   => $member->getKey(),
                'step' => MemberStepsEnum::ASSETS_CONSOLIDATION,
            ]);
        }
    }
}
