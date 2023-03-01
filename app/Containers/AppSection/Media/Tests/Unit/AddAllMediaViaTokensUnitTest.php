<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tests\Unit;

use App\Containers\AppSection\Media\Actions\CreateTemporaryUploadMediaAction;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Media\Tests\TestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Traits\TestsTraits\PhpUnit\TestsUploadHelperTrait;
use Illuminate\Support\Facades\Storage;
use UnexpectedValueException;
use function app;

/**
 * Class AddAllMediaViaTokensUnitTest.
 *
 * @group media
 * @group unit
 */
class AddAllMediaViaTokensUnitTest extends TestCase
{
    use TestsUploadHelperTrait;

    private ?HasInteractsWithMedia $modelHasMedia = null;

    /**
     * @test
     */
    public function testAddAllMediaViaTokens(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        $this->setModelHasMedia($user);
        $collection = MediaCollectionEnum::DEFAULT;
        Storage::fake('s3');

        $transporter = new CreateTemporaryUploadMediaTransporter([
            'files'      => [$this->createTestingImage('image1.jpg'), $this->createTestingImage('image2.jpg')],
            'collection' => $collection,
        ]);

        $tmp        = app(CreateTemporaryUploadMediaAction::class)->run($transporter);
        $media      = $tmp->getFirstMedia($collection);
        $mediaClass = config('media-library.media_model');

        // Asset the returned object is an instance of the Media
        $this->assertInstanceOf($mediaClass, $media);

        self::assertEquals(TemporaryUpload::class, $media?->model_type);
        self::assertEquals($tmp->getKey(), $media?->model_id);

        $model = app(AttachMediaFromUuidsToModelSubAction::class)->run(
            $this->getModelHasMedia(),
            [$tmp->uuid],
            $collection
        );

        $media?->refresh();

        self::assertEquals($media?->model_type, $model::class);
        self::assertEquals($media?->model_id, $model->getKey());
    }

    private function setModelHasMedia(?HasInteractsWithMedia $userModel = null): self
    {
        if ($this->modelHasMedia === null) {
            /** @var null|HasInteractsWithMedia $userModel */
            $userModel ??= User::factory()->create();

            $this->modelHasMedia = $userModel;
        }

        return $this;
    }

    private function getModelHasMedia(): HasInteractsWithMedia
    {
        if ($this->modelHasMedia === null) {
            throw new UnexpectedValueException('Parameter $modelHasMedia is missing');
        }

        return $this->modelHasMedia;
    }
}
