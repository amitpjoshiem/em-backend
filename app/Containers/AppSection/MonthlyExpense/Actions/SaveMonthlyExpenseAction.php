<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Actions;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Containers\AppSection\MonthlyExpense\Models\MonthlyExpense;
use App\Containers\AppSection\MonthlyExpense\Tasks\GetMonthlyExpensesTask;
use App\Containers\AppSection\MonthlyExpense\Tasks\SaveMonthlyExpenseTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class SaveMonthlyExpenseAction extends Action
{
    public function run(int $memberId, array $monthlyExpenseData): object
    {
        foreach ($monthlyExpenseData as $group => $monthlyExpense) {
            if (\is_array(array_values($monthlyExpense)[0])) {
                foreach ($monthlyExpense as $item => $values) {
                    app(SaveMonthlyExpenseTask::class)->run([
                        'group'         => $group,
                        'item'          => $item,
                        'essential'     => $values['essential'],
                        'discretionary' => $values['discretionary'],
                        'member_id'     => $memberId,
                    ]);
                }
            } else {
                app(SaveMonthlyExpenseTask::class)->run([
                    'group'         => MonthlyExpense::OTHER_GROUP,
                    'item'          => $group,
                    'essential'     => $monthlyExpense['essential'],
                    'discretionary' => $monthlyExpense['discretionary'],
                    'member_id'     => $memberId,
                ]);
            }
        }

        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($memberId);

        $currentStepCount   = app(GetMemberStepOrder::class)->run($member->step);
        $assetsAccountsStep = app(GetMemberStepOrder::class)->run(MemberStepsEnum::MONTHLY_EXPENSE);

        if ($currentStepCount < $assetsAccountsStep) {
            app(UpdateMemberTask::class)->run($member->getKey(), ['step' => MemberStepsEnum::MONTHLY_EXPENSE]);
        }

        /** @var Collection $monthlyExpenses */
        $monthlyExpenses = app(GetMonthlyExpensesTask::class)->filterByMemberId($memberId)->run();

        return (object)$monthlyExpenses->groupBy('group')->map(function (Collection $group): Collection {
            return $group->keyBy('item');
        })->toArray();
    }
}
