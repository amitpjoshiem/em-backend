<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Rules;

use App\Ship\Parents\Rules\Rule;
use Illuminate\Http\UploadedFile;

class MediaSizeRule extends Rule
{
    /**
     * Create a new rule instance.
     */
    public function __construct(private string $collection)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string             $attribute
     * @param UploadedFile|mixed $value
     */
    public function passes($attribute, $value): bool
    {
        $allowedSize = config(sprintf('media-container.collection_size.%s', $this->collection));

        if ($allowedSize === null) {
            return true;
        }

        if (!($value instanceof UploadedFile)) {
            return false;
        }

        return $value->getSize() < $allowedSize * 1024;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'File is too Large';
    }
}
