<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Rules;

use App\Ship\Parents\Rules\Rule;
use FFMpeg\Exception\RuntimeException;
use Illuminate\Http\UploadedFile;
use LogicException;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Image;

class MediaRule extends Rule
{
    private array $types;

    /**
     * Create a new rule instance.
     *
     * @param string $types
     */
    public function __construct(...$types)
    {
        $this->types = $types;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string             $attribute
     * @param UploadedFile|mixed $value
     */
    public function passes($attribute, $value): bool
    {
        if (\is_string($value) && base64_decode(base64_encode($value), true) === $value) {
            return true;
        }

        if (!$value instanceof UploadedFile) {
            return false;
        }

        try {
            $type = $this->getTypeString($value);
        } catch (RuntimeException) {
            return false;
        }

        return \in_array($type, $this->types, true);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return (string)trans('appSection@media::validation.invalid');
    }

    protected function getTypeString(UploadedFile $value): string
    {
        $fileFullPath = $value->getRealPath();
        $mimeType     = $value->getMimeType();

        if ($mimeType === null) {
            throw new LogicException('You cannot use a File with the null value of mime type.');
        }

        if ((new Image())->canHandleMime($mimeType)) {
            $type = 'image';
        } elseif (\in_array($mimeType, $this->documentsMimeTypes(), true)) {
            $type = 'document';
        } else {
            $type = strtolower(class_basename(app('ffmpeg-driver')->open($fileFullPath)::class));
        }

        return $type; // either: image, video or audio.
    }

    /**
     * The supported mime types for document files.
     *
     * @return string[]
     */
    protected function documentsMimeTypes(): array
    {
        return config('media-container.documents-mime-types');
    }
}
