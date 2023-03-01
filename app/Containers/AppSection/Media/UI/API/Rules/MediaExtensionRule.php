<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Rules;

use App\Ship\Parents\Rules\Rule;
use Illuminate\Http\UploadedFile;

class MediaExtensionRule extends Rule
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
        $allowedExtensions = config(sprintf('media-container.collection_types.%s', $this->collection));

        if ($allowedExtensions === null) {
            return true;
        }

        if (!($value instanceof UploadedFile)) {
            return false;
        }

        return \in_array($value->extension(), $allowedExtensions, true);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'This File Type not supported';
    }
}
