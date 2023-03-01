<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;

class SaveNetWorthTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/blueprint/networth/{member_id}';

    /**
     * @test
     */
    public function testSaveEmptyNetWorth(): void
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
        $this->assertDatabaseHas('blueprint_networths', [
            'member_id'     => $member->getKey(),
            'market'        => $data['market']['amount'],
            'liquid'        => $data['liquid']['amount'],
            'income_safe'   => $data['income_safe']['amount'],
        ]);
    }

    /**
     * @test
     */
    public function testSaveNetWorth(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member       = $this->registerMember($user->getKey());
        $inputData    = BlueprintNetworth::factory()->make()->toArray();
        $inputString  = array_map(fn ($value): string => (string)$value, $inputData);
        $response     = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall($inputString);
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data       = $content['data'];

        $this->assertDatabaseHas('blueprint_networths', [
            'member_id'     => $member->getKey(),
            'market'        => $data['market']['amount'],
            'liquid'        => $data['liquid']['amount'],
            'income_safe'   => $data['income_safe']['amount'],
        ]);
    }

    /**
     * @test
     */
    public function testSaveIncorrectNetWorth(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member              = $this->registerMember($user->getKey());
        $data                = BlueprintNetworth::factory()->make()->toArray();
        $data['market']      = $this->faker->word();
        $data['liquid']      = $this->faker->randomFloat(min: 2);
        $data['income_safe'] = null;
        $response            = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall($data);
        $response->assertStatus(422);
        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $response->assertJsonValidationErrors([
            'market'    => 'The market must be a number.',
            'liquid'    => 'The liquid must be a string.',
        ]);
    }
}
