<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Containers\AppSection\Member\Data\Transporters\UploadStressTestTransporter;
use App\Ship\Parents\Requests\Request;

class UploadStressTestRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UploadStressTestTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'member_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'member_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'member_id'    => 'required',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::STRESS_TEST])->run($rules);
    }
}
