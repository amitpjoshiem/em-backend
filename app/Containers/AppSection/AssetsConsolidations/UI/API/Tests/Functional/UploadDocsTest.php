<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Tests\ApiTestCase;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;

class UploadDocsTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/assets_consolidations/{member_id}/upload';

    public function testUploadPdfDoc(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());
        $this->uploadPdfDoc($member->getKey());
        $this->assertDatabaseHas('media', [
            'model_type'        => Member::class,
            'model_id'          => $member->getKey(),
            'collection_name'   => MediaCollectionEnum::ASSETS_CONSOLIDATIONS_DOCS,
        ]);
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function testUploadPdfDocWithoutData(): void
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
