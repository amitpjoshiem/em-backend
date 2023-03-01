<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class GetConcernTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/blueprint/concern/{member_id}';

    /**
     * @test
     */
    public function testGetConcern(): void
    {
        /** @var User $user */
        $user          = $this->getTestingUser();
        $member        = $this->registerMember($user->getKey());
        $monthlyIncome = BlueprintConcern::factory()->create(['member_id' => $member->getKey()]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data      = $content['data'];
        $inputData = Arr::except($monthlyIncome->toArray(), ['id', 'member_id']);
        unset($data['id']);

        Log::info('testGetConcern', [
            'inputData' => $inputData,
            'data'      => $data,
            'diff'      => array_diff($inputData, $data),
        ]);
        $this->assertEmpty(array_diff($inputData, $data));
    }
}
