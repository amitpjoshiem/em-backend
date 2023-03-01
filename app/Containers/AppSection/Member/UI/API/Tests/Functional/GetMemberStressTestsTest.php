<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Support\Facades\Log;

class GetMemberStressTestsTest extends ApiTestCase
{
    use TestsUploadHelperTrait;

    protected string $endpoint = 'get@v1/members/stress_test/{member_id}';

    /**
     * test.
     */
    public function testGetUploadedStressTest(): void
    {
        $countOfTestingFiles = random_int(1, 5);
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());
        for ($i = 1; $i <= $countOfTestingFiles; $i++) {
            $this->uploadStressTest($member->getKey());
        }

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        Log::info('testGetUploadedStressTest', [
            'response'  => $response,
            'content'   => $response->getOriginalContent(),
        ]);
        $response->assertStatus(200);

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertEquals($countOfTestingFiles, \count($data));
        foreach ($data as $media) {
            $this->assertArrayHasKey('id', $media);
            $this->assertArrayHasKey('name', $media);
            $this->assertArrayHasKey('url', $media);
            $this->assertArrayHasKey('link_expire', $media);
            $this->assertArrayHasKey('created_at', $media);
        }
    }
}
