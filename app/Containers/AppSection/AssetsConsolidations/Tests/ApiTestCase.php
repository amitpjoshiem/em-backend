<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Support\Facades\Storage;

/**
 * Class ApiTestCase.
 *
 * This is the container API TestCase class. Use this class to add your container specific API related helper functions.
 */
class ApiTestCase extends TestCase
{
    use TestsUploadHelperTrait;

    protected string $mediaEndpoint = 'post@v1/media?include=medias';

    protected string $docsUploadEndpoint = 'post@v1/assets_consolidations/{member_id}/upload';

    public function convertFromPercents(array $assetConsolidation): array
    {
        $percentFields = [
            'management_expense',
            'turnover',
            'trading_cost',
            'wrap_fee',
        ];
        array_map(function ($field) use (&$assetConsolidation): void {
            $assetConsolidation[$field] = round($assetConsolidation[$field] / 100, 4);
        }, $percentFields);

        return $assetConsolidation;
    }

    protected function uploadFile(string $fileName, string $filePath, string $fileType, string $collection): string
    {
        Storage::fake('s3');
        /** @psalm-suppress UndefinedInterfaceMethod */
        $tmpPath = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix();

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

    public function uploadPdfDoc(int $memberId): void
    {
        $uuid = $this->uploadFile(
            'sample.pdf',
            storage_path('app/testing/'),
            'application/pdf',
            MediaCollectionEnum::ASSETS_CONSOLIDATIONS_DOCS
        );
        $response = $this->endpoint($this->docsUploadEndpoint)->injectId($memberId, replace: '{member_id}')->makeCall([
            'uuids' => [
                $uuid,
            ],
        ]);
        dd($response->content());
        $response->assertStatus(204);
        $this->endpoint($this->endpoint);
    }
}
