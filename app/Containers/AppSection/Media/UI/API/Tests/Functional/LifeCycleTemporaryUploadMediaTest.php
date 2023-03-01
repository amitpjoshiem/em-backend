<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Tests\Functional;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tests\ApiTestCase;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class LifeCycleTemporaryUploadMediaTest.
 *
 * @group media
 * @group api
 */
class LifeCycleTemporaryUploadMediaTest extends ApiTestCase
{
    use TestsUploadHelperTrait;

    // The endpoint to be called within this test (e.g., get@v1/users)
    protected string $endpoint = 'post@v1/media?include=medias';

    /**
     * @test
     */
    public function itCanUploadAndDisplayTemporaryFiles(): void
    {
        Storage::fake('s3');

        $files = [$this->createTestingImage('image1.jpg'), $this->createTestingImage('image2.jpg')];

        $params = [
            'collection' => MediaCollectionEnum::DEFAULT,
        ];

        // Send the HTTP request
        $response = $this->makeUploadCall(['files' => $files], $params);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'object',
                'id',
                'uuid',
                'medias' => [
                    [
                        'object',
                        'id',
                        'url',
                        'name',
                        'file_name',
                        'extension',
                        'conversions',
                        'links' => [
                            'delete' => [
                                'href',
                                'method',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $data = [
            'uuids' => [$response->json('data.uuid')],
        ];

        // Display recently uploaded files via token.
        $response = $this->endpoint('get@v1/media')->makeCall($data);

        $response->assertSuccessful();

        $this->assertCount(2, $response->json('data'));

        // Delete one of the uploaded files by links.
        $linksDelete = $this->getResponseContentObject()->data[0]->links->delete;
        $endpoint    = $linksDelete->href;
        $method      = Str::lower($linksDelete->method);

        $response = $this->endpoint(sprintf('%s@v1%s', $method, $endpoint))->makeCall();

        $response->assertSuccessful();

        // Display remainder uploaded files via token.
        $response = $this->endpoint('get@v1/media')->makeCall($data);

        $response->assertSuccessful();

        $this->assertCount(1, $response->json('data'));
    }
}
