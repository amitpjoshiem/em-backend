<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Exceptions\CsvValidationException;
use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class ValidateClientReportRowTask extends Task
{
    public function __construct(private UserRepository $userRepository, protected MemberRepository $memberRepository)
    {
    }

    /**
     * @throws CsvValidationException
     */
    public function run(array $csvData): int
    {
        /** @var User | null $user */
        $user = $this->userRepository->findByField('npn', $csvData['AgentNPN'])->first();

        if ($user === null) {
            throw new CsvValidationException('Can`t Find Advisor By NPN');
        }

        $clientFirstName = $csvData['ClientFirst'];
        $clientLastName  = $csvData['ClientLast'];
        $memberId        = $this->findMember($clientFirstName, $clientLastName);

        if ($memberId === null) {
            throw new CsvValidationException('Can`t find Member by FirstName and LastName');
        }

        if ($memberId !== $user->getKey()) {
            throw new CsvValidationException('This Member assign to another Advisor');
        }

        if (Carbon::create($csvData['OriginationDate']) === false) {
            throw new CsvValidationException('Invalid OriginationDate format');
        }

        return $memberId;
    }

    private function findMember(string $firstName, string $lastName): ?int
    {
        /** @var object | null $query */
        $query = $this->memberRepository
            ->getBuilder()
            ->select(['id'])->whereRaw(sprintf(
                "UCASE(name) = '%s' OR UCASE(name) = '%s'",
                sprintf('%s %s', $firstName, $lastName),
                sprintf('%s %s', $lastName, $firstName)
            ))
            ->get()->first();

        return $query?->id;
    }
}
