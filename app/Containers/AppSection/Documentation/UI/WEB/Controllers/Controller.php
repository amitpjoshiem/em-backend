<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\UI\WEB\Controllers;

use App\Containers\AppSection\Documentation\Actions\GetPostmanDocumentationAction;
use App\Containers\AppSection\Documentation\UI\WEB\Requests\DocumentationRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class Controller extends WebController
{
    public function showSwaggerPage(DocumentationRequest $request): View
    {
        return view('appSection@documentation::show-swagger');
    }

    /**
     * @throws FileNotFoundException
     */
    public function getSwaggerCollection(DocumentationRequest $request): ResponseFactory | Response
    {
        return response(Storage::disk('local')->get('documentation/swagger-collection.yaml'))
            ->header('Content-Type', 'application/x-yaml');
    }

    public function getPostmanCollection(DocumentationRequest $request): ResponseFactory | Response
    {
        $path = app(GetPostmanDocumentationAction::class)->run();

        return response($path)
            ->header('Content-Type', 'application/json');
    }

    /**
     * @throws FileNotFoundException
     */
    public function getOldSwaggerCollection(DocumentationRequest $request): ResponseFactory | Response
    {
        return response(Storage::disk('local')->get('documentation/openapi-collection.yaml'))
            ->header('Content-Type', 'application/x-yaml');
    }
}
