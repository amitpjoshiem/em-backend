<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Arr;

class SaveConcernTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/blueprint/concern/{member_id}';

    /**
     * @test
     */
    public function testSaveEmptyConcern(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member   = $this->registerMember($user->getKey());
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data       = $content['data'];
        $this->assertDatabaseHas('blueprint_concerns', array_merge(
            ['member_id' => $member->getKey()],
            Arr::except($data, ['id'])
        ));
    }

    /**
     * @test
     */
    public function testSaveConcern(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member       = $this->registerMember($user->getKey());
        $inputData    = BlueprintConcern::factory()->make()->toArray();
        $response     = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall($inputData);
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data       = $content['data'];
        $this->assertDatabaseHas('blueprint_concerns', array_merge(
            ['member_id' => $member->getKey()],
            Arr::except($data, ['id'])
        ));
    }

    /**
     * @test
     */
    public function testSaveIncorrectConcern(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member            = $this->registerMember($user->getKey());
        $data              = BlueprintConcern::factory()->make()->toArray();
        $data['high_fees'] = $this->faker->word();
        $data['simple']    = $this->faker->randomFloat(min: 2);
        $response          = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall($data);
        $response->assertStatus(422);
        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $response->assertJsonValidationErrors([
            'high_fees' => 'The high fees field must be true or false.',
            'simple'    => 'The simple field must be true or false.',
        ]);
    }
}
