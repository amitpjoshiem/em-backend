<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Criterias;

use App\Containers\AppSection\Member\Exceptions\OwnerIdMissedFieldException;
use App\Containers\AppSection\User\Helper\UserHelper;
use App\Ship\Parents\Criterias\Criteria;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Vinkla\Hashids\Facades\Hashids;

class FilterByOwnerCriteria extends Criteria
{
    public function __construct()
    {
    }

    /**
     * @psalm-param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder | Model
    {
        /** @var Request $request */
        $request = app(Request::class);

        $loggedUser = UserHelper::instance()->mainUser();

        $type = $request->get('owner');

        return match ($type) {
            'my'       => $model->where('user_id', '=', $loggedUser->getKey()),
            'selected' => $this->filterBySelected($model, $request),
            default    => $model,
        };
    }

    private function filterBySelected(Builder $model, Request $request): Builder
    {
        $ownerId = Hashids::decode($request->get('owner_id'));

        if (empty($ownerId)) {
            throw new OwnerIdMissedFieldException();
        }
        $ownerId = $ownerId[0];

        return $model->where('user_id', '=', $ownerId);
    }
}
