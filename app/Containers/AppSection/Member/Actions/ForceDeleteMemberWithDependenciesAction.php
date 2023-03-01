<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsExportRepository;
use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsRepository;
use App\Containers\AppSection\AssetsConsolidations\Data\Repositories\AssetsConsolidationsTableRepository;
use App\Containers\AppSection\AssetsIncome\Data\Repositories\AssetsIncomeValueRepository;
use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintConcernRepository;
use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintDocRepository;
use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintMonthlyIncomeRepository;
use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintNetworthRepository;
use App\Containers\AppSection\Client\Data\Repositories\ClientConfirmationRepository;
use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Containers\AppSection\ClientReport\Tasks\GetAllClientReportsDocsByMemberIdTask;
use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\FixedIndexAnnuitiesRepository;
use App\Containers\AppSection\Member\Data\Repositories\MemberAssetAllocationRepository;
use App\Containers\AppSection\Member\Data\Repositories\MemberContactRepository;
use App\Containers\AppSection\Member\Data\Repositories\MemberHouseRepository;
use App\Containers\AppSection\Member\Data\Repositories\MemberOtherRepository;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\MonthlyExpense\Data\Repositories\MonthlyExpenseRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAccountRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAnnualReviewRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceChildOpportunityRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceContactRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceExportExceptionRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceOpportunityRepository;
use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceTemporaryExportRepository;
use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeAccountsRepository;
use App\Containers\AppSection\Yodlee\Data\Repositories\YodleeMemberRepository;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Repositories\Repository;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForceDeleteMemberWithDependenciesAction extends Action
{
    /**
     * @var array<class-string<\Prettus\Repository\Contracts\RepositoryCriteriaInterface>>
     */
    private const RELATIONS_REPOSITORIES = [
        AssetsConsolidationsRepository::class,
        AssetsConsolidationsExportRepository::class,
        AssetsConsolidationsTableRepository::class,
        AssetsIncomeValueRepository::class,
        BlueprintConcernRepository::class,
        BlueprintDocRepository::class,
        BlueprintMonthlyIncomeRepository::class,
        BlueprintNetworthRepository::class,
        ClientConfirmationRepository::class,
        ClientReportRepository::class,
        FixedIndexAnnuitiesRepository::class,
        MemberAssetAllocationRepository::class,
        MemberContactRepository::class,
        MemberHouseRepository::class,
        MemberOtherRepository::class,
        MonthlyExpenseRepository::class,
        YodleeAccountsRepository::class,
        YodleeMemberRepository::class,
    ];

    /**
     * @var array<class-string<\Prettus\Repository\Contracts\RepositoryCriteriaInterface>>
     */
    private const SALESFORCE_OBJECTS_REPOSITORY = [
        SalesforceAccountRepository::class,
        SalesforceAnnualReviewRepository::class,
        SalesforceOpportunityRepository::class,
        SalesforceChildOpportunityRepository::class,
        SalesforceContactRepository::class,
    ];

    public function run(int $memberId): void
    {
        $member = app(FindMemberByIdTask::class)->withRelations(['spouse', 'client.user'])->run($memberId);

        $clientReportsDocs = app(GetAllClientReportsDocsByMemberIdTask::class)->run($memberId);

        /** @var ClientReportsDoc $clientReportDoc */
        foreach ($clientReportsDocs as $clientReportDoc) {
            $clientReportDoc->contracts()->detach();
            $clientReportDoc->delete();
        }

        foreach (self::SALESFORCE_OBJECTS_REPOSITORY as $objectRepository) {
            /** @var Repository $repo */
            $repo    = app($objectRepository);
            $objects = $repo->findByField(['member_id' => $memberId]);
            /** @var Model $object */
            foreach ($objects as $object) {
                app(SalesforceTemporaryExportRepository::class)->deleteWhere([
                    'object_class' => $object::class,
                    'object_id'    => $object->getKey(),
                ]);
                app(SalesforceExportExceptionRepository::class)->deleteWhere([
                    'object_type' => $object::class,
                    'object_id'   => $object->getKey(),
                ]);

                if (\in_array(SoftDeletes::class, class_uses_recursive($object::class), true)) {
                    $object->forceDelete();
                } else {
                    $object->delete();
                }
            }
        }

        $member->employmentHistory()->delete();

        $member->spouse?->employmentHistory()->delete();

        foreach (self::RELATIONS_REPOSITORIES as $repo) {
            /** @var Repository $repo */
            $repo = app($repo);
            $repo->deleteWhere([
                'member_id' => $memberId,
            ]);
        }

        if ($member->client?->user !== null) {
            $member->client->user->forceDelete();
        }

        if ($member->client !== null) {
            $member->client->delete();
        }

        $member->forceDelete();
    }
}
