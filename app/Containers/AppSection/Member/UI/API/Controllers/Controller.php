<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Controllers;

use App\Containers\AppSection\Member\Actions\AssetAllocation\GetAssetAllocationAction;
use App\Containers\AppSection\Member\Actions\AssetAllocation\SaveAssetAllocationAction;
use App\Containers\AppSection\Member\Actions\ConfirmMemberAssetsAccountsAction;
use App\Containers\AppSection\Member\Actions\ConfirmStressTestAction;
use App\Containers\AppSection\Member\Actions\Contacts\CreateContactAction;
use App\Containers\AppSection\Member\Actions\Contacts\DeleteContactAction;
use App\Containers\AppSection\Member\Actions\Contacts\GetAllContactsAction;
use App\Containers\AppSection\Member\Actions\Contacts\GetContactAction;
use App\Containers\AppSection\Member\Actions\Contacts\UpdateContactAction;
use App\Containers\AppSection\Member\Actions\ConvertLeadAction;
use App\Containers\AppSection\Member\Actions\ConvertMemberAction;
use App\Containers\AppSection\Member\Actions\CreateMemberAction;
use App\Containers\AppSection\Member\Actions\DeleteEmploymentHistoryAction;
use App\Containers\AppSection\Member\Actions\DeleteMemberAction;
use App\Containers\AppSection\Member\Actions\FindMemberByIdAction;
use App\Containers\AppSection\Member\Actions\GetAllEmploymentHistoryAction;
use App\Containers\AppSection\Member\Actions\GetAllMembersAction;
use App\Containers\AppSection\Member\Actions\GetAllStressTestsAction;
use App\Containers\AppSection\Member\Actions\GetMemberStatisticsAction;
use App\Containers\AppSection\Member\Actions\ShareMemberReportAction;
use App\Containers\AppSection\Member\Actions\UpdateMemberAction;
use App\Containers\AppSection\Member\Actions\UploadStressTestAction;
use App\Containers\AppSection\Member\UI\API\Requests\ConfirmMemberAssetsAccountsRequest;
use App\Containers\AppSection\Member\UI\API\Requests\ConfirmStressTestRequest;
use App\Containers\AppSection\Member\UI\API\Requests\Contacts\CreateContactRequest;
use App\Containers\AppSection\Member\UI\API\Requests\Contacts\DeleteContactRequest;
use App\Containers\AppSection\Member\UI\API\Requests\Contacts\GetAllContactRequest;
use App\Containers\AppSection\Member\UI\API\Requests\Contacts\GetContactRequest;
use App\Containers\AppSection\Member\UI\API\Requests\Contacts\UpdateContactRequest;
use App\Containers\AppSection\Member\UI\API\Requests\ConvertMemberRequest;
use App\Containers\AppSection\Member\UI\API\Requests\CreateMemberRequest;
use App\Containers\AppSection\Member\UI\API\Requests\DeleteEmploymentHistoryRequest;
use App\Containers\AppSection\Member\UI\API\Requests\DeleteMemberRequest;
use App\Containers\AppSection\Member\UI\API\Requests\FindMemberByIdRequest;
use App\Containers\AppSection\Member\UI\API\Requests\GetAllMembersRequest;
use App\Containers\AppSection\Member\UI\API\Requests\GetAllStressTestsRequest;
use App\Containers\AppSection\Member\UI\API\Requests\GetAssetAllocationRequest;
use App\Containers\AppSection\Member\UI\API\Requests\MemberEmploymentHistoryRequest;
use App\Containers\AppSection\Member\UI\API\Requests\SaveAssetAllocationRequest;
use App\Containers\AppSection\Member\UI\API\Requests\ShareMemberReportRequest;
use App\Containers\AppSection\Member\UI\API\Requests\UpdateMemberRequest;
use App\Containers\AppSection\Member\UI\API\Requests\UploadStressTestRequest;
use App\Containers\AppSection\Member\UI\API\Transformers\AllMemberEmploymentHistoryTransformer;
use App\Containers\AppSection\Member\UI\API\Transformers\AssetAllocationsTransformer;
use App\Containers\AppSection\Member\UI\API\Transformers\ContactsTransformer;
use App\Containers\AppSection\Member\UI\API\Transformers\MemberStatsTransformer;
use App\Containers\AppSection\Member\UI\API\Transformers\MemberStressTestTransformer;
use App\Containers\AppSection\Member\UI\API\Transformers\MemberTransformer;
use App\Ship\Core\Exceptions\InvalidTransformerException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createMember(CreateMemberRequest $request): JsonResponse
    {
        $member = app(CreateMemberAction::class)->run($request->toTransporter());

        return $this->created($this->transform($member, MemberTransformer::class));
    }

    /**
     * @throws InvalidTransformerException
     */
    public function findMemberById(FindMemberByIdRequest $request): array
    {
        $member = app(FindMemberByIdAction::class)->run($request->toTransporter());

        return $this->transform($member, MemberTransformer::class);
    }

    public function getAllMembers(GetAllMembersRequest $request): array
    {
        $members = app(GetAllMembersAction::class)->run($request->toTransporter());

        return $this->transform($members, MemberTransformer::class);
    }

    public function updateMember(UpdateMemberRequest $request): array
    {
        $member = app(UpdateMemberAction::class)->run($request->toTransporter());

        return $this->transform($member, MemberTransformer::class);
    }

    public function deleteMember(DeleteMemberRequest $request): JsonResponse
    {
        app(DeleteMemberAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    /**
     * @throws InvalidTransformerException
     */
    public function convertToClient(ConvertMemberRequest $request): array
    {
        $member = app(ConvertMemberAction::class)->run($request->toTransporter());

        return $this->transform($member, MemberTransformer::class);
    }

    public function getEmploymentHistory(MemberEmploymentHistoryRequest $request): array
    {
        $employmentHistory = app(GetAllEmploymentHistoryAction::class)->run($request->toTransporter());

        return $this->transform($employmentHistory, AllMemberEmploymentHistoryTransformer::class, resourceKey: 'employment_history');
    }

    public function shareMemberReport(ShareMemberReportRequest $request): JsonResponse
    {
        app(ShareMemberReportAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function saveAssetAllocation(SaveAssetAllocationRequest $request): array
    {
        $assetAllocation = app(SaveAssetAllocationAction::class)->run($request->toTransporter());

        return $this->transform($assetAllocation, new AssetAllocationsTransformer());
    }

    public function getAssetAllocation(GetAssetAllocationRequest $request): array
    {
        $assetAllocation = app(GetAssetAllocationAction::class)->run($request->toTransporter());

        return $this->transform($assetAllocation, new AssetAllocationsTransformer());
    }

    public function uploadMemberStressTest(UploadStressTestRequest $request): JsonResponse
    {
        app(UploadStressTestAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllMemberStressTests(GetAllStressTestsRequest $request): array
    {
        $stressTests = app(GetAllStressTestsAction::class)->run($request->toTransporter());

        return $this->transform($stressTests, new MemberStressTestTransformer());
    }

    public function confirmMemberAssetsAccounts(ConfirmMemberAssetsAccountsRequest $request): JsonResponse
    {
        app(ConfirmMemberAssetsAccountsAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function confirmMemberStressTest(ConfirmStressTestRequest $request): JsonResponse
    {
        app(ConfirmStressTestAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllMemberContacts(GetAllContactRequest $request): array
    {
        $contacts = app(GetAllContactsAction::class)->run($request->toTransporter());

        return $this->transform($contacts, new ContactsTransformer());
    }

    public function createMemberContact(CreateContactRequest $request): array
    {
        $contact = app(CreateContactAction::class)->run($request->toTransporter());

        return $this->transform($contact, new ContactsTransformer());
    }

    public function updateMemberContact(UpdateContactRequest $request): array
    {
        $contact = app(UpdateContactAction::class)->run($request->toTransporter());

        return $this->transform($contact, new ContactsTransformer());
    }

    public function deleteMemberContact(DeleteContactRequest $request): JsonResponse
    {
        app(DeleteContactAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getMemberContact(GetContactRequest $request): array
    {
        $contact = app(GetContactAction::class)->run($request->toTransporter());

        return $this->transform($contact, new ContactsTransformer());
    }

    public function convertToProspect(ConvertMemberRequest $request): array
    {
        $member = app(ConvertLeadAction::class)->run($request->toTransporter());

        return $this->transform($member, new MemberTransformer());
    }

    public function memberStatistics(): array
    {
        $stats = app(GetMemberStatisticsAction::class)->run();

        return $this->transform($stats, new MemberStatsTransformer(), resourceKey: 'stats');
    }

    public function deleteEmploymentHistory(DeleteEmploymentHistoryRequest $request): JsonResponse
    {
        app(DeleteEmploymentHistoryAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
