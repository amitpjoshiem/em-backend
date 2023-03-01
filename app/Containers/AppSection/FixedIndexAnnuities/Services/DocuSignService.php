<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Services;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\DocusignFileTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Exceptions\DocusignRsaKeyMissingException;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocumentInterface;
use App\Containers\AppSection\FixedIndexAnnuities\Models\DocusignRecipient;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\CreateDocusignEnvelopTask;
use Carbon\Carbon;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Client\ApiException;
use DocuSign\eSign\Client\Auth\OAuthToken;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\EnvelopeDefinition;
use DocuSign\eSign\Model\EnvelopeSummary;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\ReturnUrlRequest;
use DocuSign\eSign\Model\Signer;
use Illuminate\Support\Facades\Cache;

final class DocuSignService
{
    private ApiClient $apiClient;

    /**
     * @var string
     */
    private const CACHE_TOKEN_KEY = 'docusign:token';

    private EnvelopesApi $envelopeApi;

    public function __construct()
    {
        $config = new Configuration();

        $config->setHost(config('appSection-fixedIndexAnnuities.docusign.api_host') . '/restapi');

        $this->apiClient = new ApiClient($config);

        $this->envelopeApi = new EnvelopesApi();

        if (!$this->isAuthenticated()) {
            $this->authenticate();
        }
    }

    /**
     * @throws DocusignRsaKeyMissingException
     * @throws ApiException
     */
    private function authenticate(): void
    {
        $this->apiClient->getOAuth()->setBasePath(config('appSection-fixedIndexAnnuities.docusign.api_host'));

        $response = $this->apiClient->requestJWTUserToken(
            config('appSection-fixedIndexAnnuities.docusign.integration_key'),
            config('appSection-fixedIndexAnnuities.docusign.user_id'),
            $this->getPrivateRsaKey(),
            ApiClient::$SCOPE_SIGNATURE,
        );

        /** @var OAuthToken $token */
        $token = $response[0];

        $this->setToken($token->getAccessToken(), now()->addSeconds((int)$token->getExpiresIn()));

        $this->apiClient->getConfig()->setAccessToken($token->getAccessToken());
    }

    /**
     * @throws DocusignRsaKeyMissingException
     */
    private function getPrivateRsaKey(): string
    {
        $key = file_get_contents(base_path('secret-keys/docusign/docusign_private.key'));

        if (!$key) {
            throw new DocusignRsaKeyMissingException();
        }

        return $key;
    }

    private function setToken(string $token, Carbon $ttl): void
    {
        Cache::add(self::CACHE_TOKEN_KEY, $token, $ttl);
    }

    private function getToken(): string
    {
        return Cache::get(self::CACHE_TOKEN_KEY);
    }

    private function isAuthenticated(): bool
    {
        return Cache::has(self::CACHE_TOKEN_KEY);
    }

    private function createEnvelope(DocusignFileTransporter $file, DocusignRecipient $advisor, DocusignRecipient $client): EnvelopeSummary
    {
        $envelope_definition = new EnvelopeDefinition([
            'email_subject' => 'Please sign this document set',
        ]);
        $document = new Document([
            'document_base64' => $file->b64file,
            'name'            => $file->name,
            'file_extension'  => $file->extension,
            'document_id'     => $file->id,
        ]);
        $envelope_definition->setDocuments([$document]);

        $signer1 = new Signer([
            'email'         => config('app.is_development') ? 'admin+1@swdgroup.net' : $advisor->recipient->getEmail(),
            'name'          => $advisor->recipient->getName(),
            'recipient_id'  => $advisor->getKey(),
            'routing_order' => '1',
        ]);

        $signer2 = new Signer([
            'email'         => config('app.is_development') ? 'admin+2@swdgroup.net' : $client->recipient->getEmail(),
            'name'          => $client->recipient->getName(),
            'recipient_id'  => $client->getKey(),
            'routing_order' => '2',
        ]);

        $recipients = new Recipients([
            'signers' => [$signer1, $signer2],
        ]);

        $envelope_definition->setRecipients($recipients);

        $envelope_definition->setStatus('created');

        $this->envelopeApi->getApiClient()->getConfig()->setAccessToken($this->getToken());
        $this->envelopeApi->getApiClient()->getConfig()->setHost(config('appSection-fixedIndexAnnuities.docusign.api_host') . '/restapi');

        return $this->envelopeApi->createEnvelope(config('appSection-fixedIndexAnnuities.docusign.account_id'), $envelope_definition);
    }

    private function getEnvelopeUri(?string $envelopId): ?string
    {
        $viewRequest = new ReturnUrlRequest(['return_url' => config('appSection-fixedIndexAnnuities.docusign.api_host')]);
        $this->envelopeApi->getApiClient()->getConfig()->setAccessToken($this->getToken());
        $this->envelopeApi->getApiClient()->getConfig()->setHost(config('appSection-fixedIndexAnnuities.docusign.api_host') . '/restapi');

        $results = $this->envelopeApi->createSenderView(config('appSection-fixedIndexAnnuities.docusign.account_id'), $envelopId, $viewRequest);

        return $results->getUrl();
    }

    public function getEnvelopUrl(DocumentInterface $document, DocusignRecipient $advisor, DocusignRecipient $client): ?string
    {
        $file = $this->encodeFile($document);

        $envelope = $this->createEnvelope($file, $advisor, $client);

        $envelopId = $envelope->getEnvelopeId();

        if ($envelopId === null) {
            return null;
        }

        $this->saveEnvelop($envelopId, $document, $advisor, $client);

        return $this->getEnvelopeUri($envelope->getEnvelopeId());
    }

    public function saveEnvelop(string $envelopUuid, DocumentInterface $document, DocusignRecipient $advisor, DocusignRecipient $client): void
    {
        app(CreateDocusignEnvelopTask::class)->run($document, $advisor->getKey(), $client->getKey(), $envelopUuid);
    }

    public function encodeFile(DocumentInterface $document): DocusignFileTransporter
    {
        return new DocusignFileTransporter([
            'b64file'      => base64_encode(file_get_contents($document->getDocument()->getTemporaryUrl(now()->addSeconds(5)))),
            'name'         => $document->getDocument()->file_name,
            'extension'    => $document->getDocument()->extension,
            'id'           => $document->getDocument()->getKey(),
        ]);
    }
}
