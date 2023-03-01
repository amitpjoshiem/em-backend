<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;

class GetMemberAgeTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/pipeline/member/statistics/age';

    /**
     * @test
     */
    public function testGetAUM(): void
    {
        $user = $this->getTestingUser();

        $memberCount = 50;
        $members     = Member::factory()->count($memberCount)->create([
            'user_id'   => $user->getKey(),
        ]);

        $response = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];

        $configAgesGroups = config('appSection-pipeline.age_groups');
        $this->assertCount(\count($configAgesGroups), $data);

        foreach ($data as $key => $ageGroup) {
            $this->assertArrayHasKey('startAge', $configAgesGroups[$key]);
            $this->assertArrayHasKey('endAge', $configAgesGroups[$key]);
            $startAge = $configAgesGroups[$key]['startAge'];
            $endAge   = $configAgesGroups[$key]['endAge'];
            $this->assertEquals($startAge, $ageGroup['start_age']);
            $this->assertEquals($endAge, $ageGroup['end_age']);
            $currentCount = $members->filter(static function (Member $member) use ($startAge, $endAge): bool {
                return $member->birthday?->age >= $startAge && $member->birthday?->age <= $endAge;
            })->count();
            $this->assertEquals(round($currentCount / $memberCount * 100, 2), $ageGroup['percent']);
        }
    }
}
