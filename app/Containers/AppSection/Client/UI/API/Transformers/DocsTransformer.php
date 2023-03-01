<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Models\ClientDocsAdditionalInfo;
use App\Containers\AppSection\Client\Tasks\FindClientDocsAdditionalInfoTask;
use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Transformers\Transformer;
use Carbon\Carbon;

class DocsTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(Media $doc): array
    {
        $linkExpire = Carbon::now()->addMinutes(config('appSection-client.doc_link_expire_minutes'));

        /** @var ClientDocsAdditionalInfo|null $additionalInfo */
        $additionalInfo = app(FindClientDocsAdditionalInfoTask::class)->run($doc->model_id, $doc->getKey());

        $data = [
            'id'                => $doc->getHashedKey(),
            'name'              => $doc->file_name,
            'url'               => $this->getUrl($doc, $linkExpire),
            'extension'         => $doc->extension,
            'link_expire'       => $linkExpire->toDateTimeString(),
            'created_at'        => $doc->created_at?->toDateTimeString(),
            'additional_info'   => null,
        ];

        if ($additionalInfo !== null) {
            $data['additional_info'] = [
                'name'        => $additionalInfo->name,
                'description' => $additionalInfo->description,
                'is_spouse'   => $additionalInfo->is_spouse,
                'type'        => $additionalInfo->type,
            ];
        }

        return $data;
    }
}
