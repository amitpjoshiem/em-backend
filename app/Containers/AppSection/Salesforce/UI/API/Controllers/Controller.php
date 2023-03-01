<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Controllers;

use App\Containers\AppSection\Salesforce\Actions\Account\DeleteAccountAction;
use App\Containers\AppSection\Salesforce\Actions\Account\FindAccountAction;
use App\Containers\AppSection\Salesforce\Actions\Account\UpdateAccountAction;
use App\Containers\AppSection\Salesforce\Actions\AnnualReview\CreateAnnualReviewAction;
use App\Containers\AppSection\Salesforce\Actions\AnnualReview\DeleteAnnualReviewAction;
use App\Containers\AppSection\Salesforce\Actions\AnnualReview\FindAnnualReviewByIdAction;
use App\Containers\AppSection\Salesforce\Actions\AnnualReview\GetAllAnnualReviewByMemberIdAction;
use App\Containers\AppSection\Salesforce\Actions\AnnualReview\UpdateAnnualReviewAction;
use App\Containers\AppSection\Salesforce\Actions\CancelConvertCloseWinAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\CreateChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\DeleteChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\FindAllChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\FindChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\InitChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\UpdateChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\CreateMemberInSaleforceAction;
use App\Containers\AppSection\Salesforce\Actions\CreateOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\GetSalesforceAuthSettingsAction;
use App\Containers\AppSection\Salesforce\Actions\GetSalesforceOpportunityStagesAction;
use App\Containers\AppSection\Salesforce\Actions\Opportunity\StageOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\SalesforceLogoutUserAction;
use App\Containers\AppSection\Salesforce\Actions\SalesforceMemberStatusAction;
use App\Containers\AppSection\Salesforce\Actions\SalesforceOpportunityStageSchemaAction;
use App\Containers\AppSection\Salesforce\Actions\SalesforceUpdateOpportunityStageAction;
use App\Containers\AppSection\Salesforce\Actions\UploadAccountAttachmentAction;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceAuthLinkException;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AccountCRUD\CreateSalesforceAccountRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AccountCRUD\DeleteSalesforceAccountRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AccountCRUD\FindSalesforceAccountRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AccountCRUD\UpdateSalesforceAccountRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD\CreateSalesforceAnnualReviewRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD\DeleteSalesforceAnnualReviewRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD\FindSalesforceAnnualReviewRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD\GetAllSalesforceAnnualReviewForMemberRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\AnnualReviewCRUD\UpdateSalesforceAnnualReviewRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\CancelConvertCloseWinRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD\CreateSalesforceChildOpportunityRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD\DeleteSalesforceChildOpportunityRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD\FindAllSalesforceChildOpportunityRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD\FindSalesforceChildOpportunityRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\ChildOpportunityCRUD\UpdateSalesforceChildOpportunityRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\CreateOpportunityRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\SalesforceMemberStatusRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\SalesforceOpportunityStageSchemaRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\SalesforceUpdateOpportunityStageRequest;
use App\Containers\AppSection\Salesforce\UI\API\Requests\UploadAccountAttachmentRequest;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\AnnualReviewTransformer;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\ChildOpportunityTransformer;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\InitTransformer;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\MemberStatusTransformer;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\OpportunityTransformer;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\StageListTransformer;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    /**
     * @throws SalesforceAuthLinkException
     * @throws UserNotFoundException
     */
    public function authSettings(): JsonResponse
    {
        $link = app(GetSalesforceAuthSettingsAction::class)->run();

        return $this->json($link);
    }

    /**
     * @throws UserNotFoundException
     */
    public function authLogout(): JsonResponse
    {
        app(SalesforceLogoutUserAction::class)->run();

        return $this->noContent();
    }

    public function getAccountByMemberId(FindSalesforceAccountRequest $request): JsonResponse
    {
        $account = app(FindAccountAction::class)->run($request->toTransporter());

        return $this->json($account);
    }

    public function createAccount(CreateSalesforceAccountRequest $request): JsonResponse
    {
        app(CreateMemberInSaleforceAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function updateAccount(UpdateSalesforceAccountRequest $request): JsonResponse
    {
        app(UpdateAccountAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function deleteAccount(DeleteSalesforceAccountRequest $request): JsonResponse
    {
        app(DeleteAccountAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function opportunityStageList(): array
    {
        $stageList = app(StageOpportunityAction::class)->run();

        return $this->transform($stageList, StageListTransformer::class, resourceKey: 'stage');
    }

    public function childOpportunityInit(): array
    {
        $init = app(InitChildOpportunityAction::class)->run();

        return $this->transform($init, InitTransformer::class, resourceKey: 'init');
    }

    public function getChildOpportunityById(FindSalesforceChildOpportunityRequest $request): array
    {
        $childOpportunity = app(FindChildOpportunityAction::class)->run($request->toTransporter());

        return $this->transform($childOpportunity, ChildOpportunityTransformer::class, resourceKey: 'child_opportunity');
    }

    public function getAllMembersChildOpportunities(FindAllSalesforceChildOpportunityRequest $request): array
    {
        $childOpportunities = app(FindAllChildOpportunityAction::class)->run($request->toTransporter());

        return $this->transform($childOpportunities, ChildOpportunityTransformer::class, resourceKey: 'childOpportunities');
    }

    public function createChildOpportunity(CreateSalesforceChildOpportunityRequest $request): array
    {
        $childOpportunity = app(CreateChildOpportunityAction::class)->run($request->toTransporter());

        return $this->transform($childOpportunity, ChildOpportunityTransformer::class, resourceKey: 'childOpportunity');
    }

    public function updateChildOpportunity(UpdateSalesforceChildOpportunityRequest $request): array
    {
        $childOpportunity = app(UpdateChildOpportunityAction::class)->run($request->toTransporter());

        return $this->transform($childOpportunity, ChildOpportunityTransformer::class, resourceKey: 'childOpportunity');
    }

    public function deleteChildOpportunity(DeleteSalesforceChildOpportunityRequest $request): JsonResponse
    {
        app(DeleteChildOpportunityAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function memberStatus(SalesforceMemberStatusRequest $request): array
    {
        $status = app(SalesforceMemberStatusAction::class)->run($request->toTransporter());

        return $this->transform($status, new MemberStatusTransformer(), resourceKey: 'status');
    }

    public function uploadAccountAttachment(UploadAccountAttachmentRequest $request): JsonResponse
    {
        app(UploadAccountAttachmentAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function updateOpportunityStage(SalesforceUpdateOpportunityStageRequest $request): array
    {
        $opportunity = app(SalesforceUpdateOpportunityStageAction::class)->run($request->toTransporter());

        return $this->transform($opportunity, new OpportunityTransformer());
    }

    public function getOpportunityStageSchema(SalesforceOpportunityStageSchemaRequest $request): JsonResponse
    {
        $schema = app(SalesforceOpportunityStageSchemaAction::class)->run($request->toTransporter());

        return $this->json(['data' => $schema]);
    }

    public function getOpportunityStages(): JsonResponse
    {
        $stages = app(GetSalesforceOpportunityStagesAction::class)->run();

        return $this->json(['data' => $stages]);
    }

    public function cancelConvertCloseWin(CancelConvertCloseWinRequest $request): JsonResponse
    {
        app(CancelConvertCloseWinAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function createOpportunity(CreateOpportunityRequest $request): JsonResponse
    {
        app(CreateOpportunityAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAnnualReviewById(FindSalesforceAnnualReviewRequest $request): array
    {
        $annualReview = app(FindAnnualReviewByIdAction::class)->run($request->toTransporter());

        return $this->transform($annualReview, new AnnualReviewTransformer());
    }

    public function getAllAnnualReviews(GetAllSalesforceAnnualReviewForMemberRequest $request): array
    {
        $annualReviews = app(GetAllAnnualReviewByMemberIdAction::class)->run($request->toTransporter());

        return $this->transform($annualReviews, new AnnualReviewTransformer(), resourceKey: 'AnnualReviews');
    }

    public function createAnnualReview(CreateSalesforceAnnualReviewRequest $request): array
    {
        $annualReview = app(CreateAnnualReviewAction::class)->run($request->getInputByKey('member_id'), $request->toTransporter());

        return $this->transform($annualReview, new AnnualReviewTransformer());
    }

    public function updateAnnualReview(UpdateSalesforceAnnualReviewRequest $request): array
    {
        $annualReview = app(UpdateAnnualReviewAction::class)->run($request->getInputByKey('id'), $request->toTransporter());

        return $this->transform($annualReview, new AnnualReviewTransformer());
    }

    public function deleteAnnualReview(DeleteSalesforceAnnualReviewRequest $request): JsonResponse
    {
        app(DeleteAnnualReviewAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
