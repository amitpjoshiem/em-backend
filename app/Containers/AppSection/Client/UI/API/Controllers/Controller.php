<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Controllers;

use App\Containers\AppSection\Client\Actions\DeleteClientAction;
use App\Containers\AppSection\Client\Actions\DeleteClientTokenAction;
use App\Containers\AppSection\Client\Actions\GetAllClientDocsByMemberAction;
use App\Containers\AppSection\Client\Actions\GetClientConfirmationsAction;
use App\Containers\AppSection\Client\Actions\GetClientConfirmationsByMemberAction;
use App\Containers\AppSection\Client\Actions\GetClientDocsAction;
use App\Containers\AppSection\Client\Actions\GetClientDocsTypes;
use App\Containers\AppSection\Client\Actions\GetClientInfoAction;
use App\Containers\AppSection\Client\Actions\HelpClientVideoAction;
use App\Containers\AppSection\Client\Actions\RestoreClientAction;
use App\Containers\AppSection\Client\Actions\SaveClientConfirmationsAction;
use App\Containers\AppSection\Client\Actions\SubmitClientInfoAction;
use App\Containers\AppSection\Client\Actions\UpdateClientAction;
use App\Containers\AppSection\Client\Actions\UpdateClientStepsAction;
use App\Containers\AppSection\Client\Actions\UploadClientDocsAction;
use App\Containers\AppSection\Client\UI\API\Requests\DeleteClientRequest;
use App\Containers\AppSection\Client\UI\API\Requests\DeleteClientTokenRequest;
use App\Containers\AppSection\Client\UI\API\Requests\GetAllClientDocsByMemberRequest;
use App\Containers\AppSection\Client\UI\API\Requests\GetClientDocsRequest;
use App\Containers\AppSection\Client\UI\API\Requests\GetConfirmationsByMemberRequest;
use App\Containers\AppSection\Client\UI\API\Requests\HelpClientVideoRequest;
use App\Containers\AppSection\Client\UI\API\Requests\RestoreClientRequest;
use App\Containers\AppSection\Client\UI\API\Requests\SaveClientConfirmationRequest;
use App\Containers\AppSection\Client\UI\API\Requests\UpdateClientRequest;
use App\Containers\AppSection\Client\UI\API\Requests\UpdateClientStepsRequest;
use App\Containers\AppSection\Client\UI\API\Requests\UploadClientDocsRequest;
use App\Containers\AppSection\Client\UI\API\Transformers\ClientConfirmationTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\ClientDocsTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\ClientInfoTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\ClientTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\DocsTypeTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\HelpVideoTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function clientInfo(): array
    {
        $client = app(GetClientInfoAction::class)->run();

        return $this->transform($client, ClientInfoTransformer::class, resourceKey: 'info');
    }

    public function updateClientSteps(UpdateClientStepsRequest $request): array
    {
        $client = app(UpdateClientStepsAction::class)->run($request->toTransporter());

        return $this->transform($client, new ClientTransformer());
    }

    public function uploadClientDocs(UploadClientDocsRequest $request): array
    {
        $docs = app(UploadClientDocsAction::class)->run($request->toTransporter());

        return $this->transform($docs, new ClientDocsTransformer(), resourceKey: 'docs');
    }

    public function getClientDocs(GetClientDocsRequest $request): array
    {
        $docs = app(GetClientDocsAction::class)->run($request->toTransporter());

        return $this->transform($docs, new ClientDocsTransformer(), resourceKey: 'docs');
    }

    public function submitClientInfo(): JsonResponse
    {
        app(SubmitClientInfoAction::class)->run();

        return $this->noContent();
    }

    public function saveClientConfirmation(SaveClientConfirmationRequest $request): array
    {
        $data = app(SaveClientConfirmationsAction::class)->run($request->toTransporter());

        return $this->transform($data, new ClientConfirmationTransformer(), resourceKey: 'confirmation');
    }

    public function getClientConfirmation(): array
    {
        $data = app(GetClientConfirmationsAction::class)->run();

        return $this->transform($data, new ClientConfirmationTransformer(), resourceKey: 'confirmation');
    }

    public function getAllClientDocsByMember(GetAllClientDocsByMemberRequest $request): array
    {
        $docs = app(GetAllClientDocsByMemberAction::class)->run($request->toTransporter());

        return $this->transform($docs, new ClientDocsTransformer(), resourceKey: 'client_docs');
    }

    public function getClientConfirmationByMember(GetConfirmationsByMemberRequest $request): array
    {
        $data = app(GetClientConfirmationsByMemberAction::class)->run($request->toTransporter());

        return $this->transform($data, new ClientConfirmationTransformer(), resourceKey: 'confirmation');
    }

    public function deleteClientToken(DeleteClientTokenRequest $request): JsonResponse
    {
        app(DeleteClientTokenAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function deleteClient(DeleteClientRequest $request): JsonResponse
    {
        app(DeleteClientAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function restoreClient(RestoreClientRequest $request): JsonResponse
    {
        app(RestoreClientAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function updateClient(UpdateClientRequest $request): array
    {
        $client = app(UpdateClientAction::class)->run($request->toTransporter());

        return $this->transform($client, ClientInfoTransformer::class, resourceKey: 'info');
    }

    public function helpClientVideo(HelpClientVideoRequest $request): array
    {
        $url = app(HelpClientVideoAction::class)->run($request->toTransporter());

        return $this->transform($url, new HelpVideoTransformer(), resourceKey: 'help');
    }

    public function getClientDocsTypes(): array
    {
        $types = app(GetClientDocsTypes::class)->run();

        return $this->transform($types, new DocsTypeTransformer(), resourceKey: 'types');
    }
}
