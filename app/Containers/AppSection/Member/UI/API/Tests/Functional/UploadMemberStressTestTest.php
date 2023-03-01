<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;

class UploadMemberStressTestTest extends ApiTestCase
{
    use TestsUploadHelperTrait;

    protected string $endpoint = 'post@v1/members/stress_test/{member_id}';

    /**
     * @test
     */
    public function testUploadStressTest(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());
        $this->uploadStressTest($member->getKey());
        $this->assertDatabaseHas('media', [
            'model_type'        => Member::class,
            'model_id'          => $member->getKey(),
            'collection_name'   => MediaCollectionEnum::STRESS_TEST,
        ]);
    }

    /**
     * @test
     */
    public function testUploadStressTestWithoutData(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member   = $this->registerMember($user->getKey());
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall([
            'uuids' => [],
        ]);
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
        $response->assertJsonValidationErrors([
            'uuids' => 'The uuids field must have a value.',
        ]);
    }
}
