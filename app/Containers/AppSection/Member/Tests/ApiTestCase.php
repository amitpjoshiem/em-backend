<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Member\Tests\Traits\RegisterMemberTestTrait;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Support\Facades\Storage;

/**
 * Class ApiTestCase.
 *
 * This is the container API TestCase class. Use this class to add your container specific API related helper functions.
 */
class ApiTestCase extends TestCase
{
    use RegisterMemberTestTrait;
    use TestsUploadHelperTrait;

    protected string $mediaEndpoint = 'post@v1/media?include=medias';

    protected string $stressTestUploadEndpoint = 'post@v1/members/stress_test/{member_id}';

    protected function uploadFile(string $fileName, string $filePath, string $fileType, string $collection): string
    {
        Storage::fake('s3');
        $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR;

        $copy = copy($filePath . $fileName, $tmpPath . $fileName);
        $this->assertTrue($copy);
        $stressTestPdf = $this->getTestingFile($fileName, $tmpPath, $fileType);
        $params        = [
            'collection' => $collection,
        ];
        $response = $this->endpoint($this->mediaEndpoint)->makeUploadCall(['files' => [$stressTestPdf]], $params);
        $response->assertStatus(201);

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertArrayHasKey('uuid', $data);
        $uuid = $data['uuid'];
        $this->endpoint($this->endpoint);

        return $uuid;
    }

    protected function uploadStressTest(int $memberId): void
    {
        $uuid = $this->uploadFile(
            'sample.pdf',
            storage_path('app/testing/'),
            'application/pdf',
            MediaCollectionEnum::STRESS_TEST
        );
        $response = $this->endpoint($this->stressTestUploadEndpoint)->injectId($memberId, replace: '{member_id}')->makeCall([
            'uuids' => [
                $uuid,
            ],
        ]);
        $response->assertStatus(204);
        $this->endpoint($this->endpoint);
    }
}
