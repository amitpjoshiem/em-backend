<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\BasicElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\NumberElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\StringElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\TotalElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\GroupSchema;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\GetSchemaTransporter;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\RowAdditionsDataTransporter;
use App\Containers\AppSection\AssetsIncome\Models\AssetsIncomeValue;
use App\Containers\AppSection\AssetsIncome\SubActions\GetSchemaSubAction;
use App\Containers\AppSection\AssetsIncome\Tasks\FindRowInDropdownOptionTask;
use App\Containers\AppSection\AssetsIncome\Tasks\GetAllValuesTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class GetSchemaAction extends Action
{
    public function run(GetSchemaTransporter $data): SupportCollection
    {
        return app(GetSchemaSubAction::class)->run($data->member_id);
    }
}
