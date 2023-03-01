<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Traits\TestsTraits\PhpUnit;

use App\Ship\Core\Exceptions\UndefinedMethodException;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;

/**
 * Class TestsCreateNewTemporaryImageHelperTrait.
 *
 * Tests helper for create and upload files.
 */
trait TestsCreateNewTemporaryImageHelperTrait
{
    use TestsUploadHelperTrait;

    /**
     * @throws UndefinedMethodException
     */
    public function createAndGetTemporaryImage(array $mediaParams = [], string $fileName = 'model', string $ext = 'jpg'): TestResponse
    {
        Storage::fake('s3');

        $file = $this->createTestingImage(sprintf('%s.%s', $fileName, $ext));

        // Send the HTTP request
        $response = $this->endpoint('post@v1/media')->makeUploadCall(['file' => $file], $mediaParams);

        $response->assertSuccessful();

        // Reset $endpoint to the base endpoint
        $this->endpoint(null);
        $this->responseContentArray  = null;
        $this->responseContentObject = null;

        return $response;
    }

    /**
     * @throws UndefinedMethodException
     */
    public function createManyAndGetTemporaryImages(array $mediaParams = [], int $iteration = 2, string $fileName = 'model', string $ext = 'jpg'): TestResponse
    {
        Storage::fake('s3');

        $files = [];

        foreach (range(0, $iteration) as $step) {
            $files[] = $this->createTestingImage(sprintf('%s-%s.%s', $fileName, $step + 1, $ext));
        }

        // Send the HTTP request
        $response = $this->endpoint('post@v1/media')->makeUploadCall(['files' => $files], $mediaParams);

        $response->assertSuccessful();

        // Reset $endpoint to the base endpoint
        $this->endpoint(null);
        $this->responseContentArray  = null;
        $this->responseContentObject = null;

        return $response;
    }

    /**
     * Override the default class endpoint property before making the call
     * to be used as follow: $this->endpoint('verb@uri')->makeCall($data).
     *
     * @param string $endpoint
     *
     * @return static
     */
    abstract public function endpoint($endpoint);

    /**
     * @throws UndefinedMethodException
     */
    abstract public function makeUploadCall(array $files = [], array $params = [], array $headers = []): TestResponse;
}
