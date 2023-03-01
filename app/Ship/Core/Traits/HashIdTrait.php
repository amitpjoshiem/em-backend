<?php

namespace App\Ship\Core\Traits;

use App\Ship\Core\Exceptions\IncorrectIdException;
use Illuminate\Routing\Route as Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;
use function is_null;
use function strtolower;

trait HashIdTrait
{
    /**
     * Endpoint to be skipped from decoding their ID's (example for external ID's).
     */
    private array $skippedEndpoints = [
        //        'orders/{id}/external',
    ];

    /**
     * Hashes the value of a field (e.g., ID)
     * Will be used by the Eloquent Models (since it's used as trait there).
     *
     * @param string|null $field The field of the model to be hashed
     *
     * @psalm-return mixed
     */
    public function getHashedKey(?string $field = null)
    {
        // If no key is set, use the default key name (i.e., id)
        if ($field === null) {
            $field = $this->getKeyName();
        }

        // Hash the ID only if hash-id enabled in the config
        if (Config::get('apiato.hash-id')) {
            // We need to get the VALUE for this KEY (model field)
            $value = $this->getAttribute($field);

            return $this->encoder($value);
        }

        return $this->getAttribute($field);
    }

    /**
     * @param int $id
     */
    public function encoder($id): string
    {
        return Hashids::encode($id);
    }

    public function decodeArray(array $ids): array
    {
        $result = [];
        foreach ($ids as $id) {
            $result[] = $this->decode($id);
        }

        return $result;
    }

    public function decode(?string $id): ?int
    {
        // Check if passed as null, (could be an optional decodable variable)
        if (is_null($id) || strtolower($id) === 'null') {
            return null;
        }

        $value = $this->decoder($id);

        if (empty($value)) {
            return null;
        }

        // Do the decoding if the ID looks like a hashed one
        return (int)$value[0];
    }

    /**
     * @param string $id
     */
    private function decoder($id): array
    {
        return Hashids::decode($id);
    }

    /**
     * @param int $id
     */
    public function encode($id): string
    {
        return $this->encoder($id);
    }

    /**
     * Automatically decode any found `id` in the URL, no need to be used anymore.
     * Since now the user will define what needs to be decoded in the request.
     * All ID's passed with all endpoints will be decoded before entering the Application.
     */
    public function runHashedIdsDecoder(): void
    {
        if (Config::get('apiato.hash-id')) {
            Route::bind('id', function (string $id, Router $route) {
                // Skip decoding some endpoints
                if (!in_array($route->uri(), $this->skippedEndpoints)) {

                    // Decode the ID in the URL
                    $decoded = $this->decoder($id);

                    if (empty($decoded)) {
                        throw new IncorrectIdException('ID (' . $id . ') is incorrect, consider using the hashed ID
                        instead of the numeric ID.');
                    }

                    return $decoded[0];
                }
            });
        }
    }

    /**
     * Without decoding the encoded ID's you won't be able to use
     * validation features like `exists:table,id`.
     */
    protected function decodeHashedIdsBeforeValidation(array $requestData): array
    {
        // The hash ID feature must be enabled to use this decoder feature.
        if (Config::get('apiato.hash-id') && isset($this->decode) && !empty($this->decode)) {
            // Iterate over each key (ID that needs to be decoded) and call keys locator to decode them
            foreach ($this->decode as $key) {
                $requestData = $this->locateAndDecodeIds($requestData, $key);
            }
        }

        return $requestData;
    }

    /**
     * Search the IDs to be decoded in the request data.
     */
    private function locateAndDecodeIds(array $requestData, string $key): array
    {
        // Split the key based on the "."
        $fields = explode('.', $key);
        // Loop through all elements of the key.
        return (array)($this->processField($requestData, $fields));
    }

    /**
     * Recursive function to process (decode) the request data with a given key.
     *
     * @psalm-return array|string|int|null
     */
    private function processField(array|string $data, ?array$keysTodo = null)
    {
        // Check if there are no more fields to be processed
        if (empty($keysTodo)) {
            if (!is_string($data)) {
                return $data;
            }

            // There are no more keys left - so basically we need to decode this entry
            return $this->decode($data);
        }

        // Take the first element from the field
        $field = array_shift($keysTodo);

        // Is the current field an array?! we need to process it like crazy
        if ($field === '*') {
            // Make sure field value is an array
            $data = is_array($data) ? $data : [$data];

            // Process each field of the array (and go down one level!)
            $fields = $data;
            foreach ($fields as $key => $value) {
                $data[$key] = $this->processField($value, $keysTodo);
            }

            return $data;
        } else {
            // Check if the key we are looking for does, in fact, really exist
            if (!is_array($data) || !array_key_exists($field, $data)) {
                return $data;
            }

            // Go down one level
            $value        = $data[$field];
            $data[$field] = $this->processField($value, $keysTodo);

            return $data;
        }
    }
}
