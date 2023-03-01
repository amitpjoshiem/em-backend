<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Requests;

use App\Containers\AppSection\Pipeline\Data\Transporters\PipelinePeriodTypeTransporter;
use App\Ship\Parents\Requests\Request;

class PipelinePeriodTypeRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = PipelinePeriodTypeTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function rules(): array
    {
        return [
            'type'     => 'required|string|in:year,month,quarter',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
