<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;

class GetAllDocsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/assets_consolidations/{member_id}/docs';

    public function testGetAllPdfDoc(): void
    {
        $countOfTestingFiles = random_int(1, 5);
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());
        for ($i = 1; $i <= $countOfTestingFiles; $i++) {
            $this->uploadPdfDoc($member->getKey());
        }

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

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
