<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Events\Handlers;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use Closure;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\Format\Video\X264;
use FFMpeg\Media\Audio;
use FFMpeg\Media\Video;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\Facades\Image;
use RuntimeException;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Image as ImageGenerator;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProcessUploadedMedia implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @throws \Exception
     */
    public function handle(MediaHasBeenAdded $event): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        if ($event->media->getCustomProperty('status') === 'processed') {
            // Skipped Processing Media File
            return;
        }

        $path = null;

        try {
            if ($this->isImage($event->media)) {
                $this->processImage($event->media);
            } elseif ($this->isDocument($event->media)) {
                $this->processDocument($event->media);
            } elseif ($this->isVideo($event->media)) {
                $path = $this->processVideo($event->media);
            } elseif ($this->isAudio($event->media)) {
                $path = $this->processAudio($event->media);
            }

            $this->processingDone($event->media, $path);
        } catch (RuntimeException) {
            $this->processingFailed($event->media);
        }

        $event->media->setCustomProperty('status', 'processing')->save();
    }

    /**
     * Determine if the media file is an image.
     */
    protected function isImage(Media $media): bool
    {
        return (new ImageGenerator())->canHandleMime($media->mime_type);
    }

    /**
     * Determine if the media file is a document.
     */
    protected function isDocument(Media $media): bool
    {
        return \in_array(
            $media->mime_type,
            config('media-container.documents-mime-types'),
            true
        );
    }

    /**
     * Determine if the media file is a video and initiate the required driver.
     */
    protected function isVideo(Media $media): bool
    {
        return app('ffmpeg-driver')->open($media->getPath()) instanceof Video;
    }

    /**
     * Determine if the media file is an audio and the initiate required driver.
     */
    protected function isAudio(Media $media): bool
    {
        return app('ffmpeg-driver')->open($media->getPath()) instanceof Audio;
    }

    /**
     * Process Image File.
     */
    protected function processImage(Media $media): void
    {
        $image = Image::make($media->getPath())->orientate();

        $media
            ->setCustomProperty('type', 'image')
            ->setCustomProperty('width', $image->width())
            ->setCustomProperty('height', $image->height())
            ->setCustomProperty('ratio', (string) round($image->width() / $image->height(), 3))
            ->save();
    }

    /**
     * Process Document File.
     */
    protected function processDocument(Media $media): void
    {
        $media->setCustomProperty('type', 'document')->save();
    }

    /**
     * Process Video File.
     */
    protected function processVideo(Media $media): string
    {
        $media->setCustomProperty('type', 'video')->save();

        $video = app('ffmpeg-driver')->open($media->getPath());

        $format = new X264();

        $format->on('progress', $this->increaseProcessProgress($media));

        $format->setAudioCodec('aac');

        $format->setAdditionalParameters(['-vf', 'pad=ceil(iw/2)*2:ceil(ih/2)*2']);

        $video->save($format, $processedFile = $this->generatePathForProcessedFile($media, 'mp4'));

        return $processedFile;
    }

    /**
     * Process Audio File.
     */
    protected function processAudio(Media $media): string
    {
        $media->setCustomProperty('type', 'audio')->save();

        $audio = app('ffmpeg-driver')->open($media->getPath());

        $format = new Mp3();

        $format->on('progress', $this->increaseProcessProgress($media));

        $audio->save($format, $processedFile = $this->generatePathForProcessedFile($media, 'mp3'));

        return $processedFile;
    }

    protected function increaseProcessProgress(Media $media): Closure
    {
        return function (
            mixed $file,
            mixed $format,
            mixed $percentage
        ) use ($media): void {
            // Progress Percentage is $percentage
            $media->setCustomProperty('progress', $percentage);
            $media->save();
        };
    }

    /**
     * @throws \Exception
     */
    protected function processingDone(Media $media, ?string $processedFilePath = null): void
    {
        // If the processing does not ended with generating a new file.
        if (\is_null($processedFilePath)) {
            $media->setCustomProperty('status', 'processed')
                ->setCustomProperty('progress', 100)
                ->save();
        } else {
            /** @psalm-suppress InaccessibleProperty*/
            $model = $media->model;

            if (!($model instanceof HasInteractsWithMedia)) {
                return;
            }

            // New Converted Media Will Be Added
            /** @var FFMpeg $driver */
            $driver   = app('ffmpeg-driver');
            $duration = $driver
                ->getFFProbe()
                ->format($processedFilePath)
                ->get('duration');

            $model
                ->addMedia($processedFilePath)
                ->withCustomProperties([
                    'type'     => $media->getCustomProperty('type'),
                    'status'   => 'processed',
                    'progress' => 100,
                    'duration' => $duration,
                ])
                ->preservingOriginal()
                ->toMediaCollection($media->collection_name);

            (clone $media)->delete();
        }
    }

    /**
     * Mark media status as failed.
     */
    protected function processingFailed(Media $media): void
    {
        $media->setCustomProperty('status', 'failed')->save();
    }

    protected function generatePathForProcessedFile(Media $media, string $extension = ''): string
    {
        $path = $media->getPath();

        return sprintf(
            '%s%s%s.processed.%s',
            pathinfo($path, PATHINFO_DIRNAME),
            DIRECTORY_SEPARATOR,
            pathinfo($path, PATHINFO_FILENAME),
            $extension
        );
    }
}
