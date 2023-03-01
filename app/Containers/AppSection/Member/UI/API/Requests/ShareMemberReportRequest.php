<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Containers\AppSection\Member\Data\Transporters\ShareMemberReportTransporter;
use App\Ship\Parents\Requests\Request;

class ShareMemberReportRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = ShareMemberReportTransporter::class;

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
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'emails.*'   => 'string|email',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::MEMBER_REPORT])->run($rules);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
