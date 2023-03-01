<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\UI\API\Requests;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Traits\RequestWithoutRulesTrait;

/**
 * Class GetAllSystemStatusesRequest.
 */
class GetAllSystemStatusesRequest extends Request
{
    use RequestWithoutRulesTrait;

    /**
     * Check if the authenticated user actually has the authority to change a given resource.
     */
    public function authorize(): bool
    {
        return true;
    }
}
