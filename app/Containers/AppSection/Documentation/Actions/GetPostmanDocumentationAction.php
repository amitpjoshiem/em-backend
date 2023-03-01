<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Actions;

use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * Class GetPostmanDocumentationAction.
 */
class GetPostmanDocumentationAction extends Action
{
    public function run(): string
    {
        $url = config('documentation-container.postman.url');

        if (isset($url) && filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $path = Http::get($url)->body();
        } else {
            try {
                $path = Storage::disk('local')->get('documentation/postman-collection.json');
            } catch (FileNotFoundException) {
                $path = json_encode(['Message' => 'Postman collection not found!'], JSON_THROW_ON_ERROR);
            }
        }

        return $path;
    }
}
