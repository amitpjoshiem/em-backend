<?php
    use App\Containers\AppSection\Member\Models\MemberHouse;
    use App\Containers\AppSection\Member\Models\Member;
    use Illuminate\Support\Str;
/** @var App\Containers\AppSection\Member\Models\Member $member */
?>
TEST

<div class="page">
    <div class="flex justify-center">
        <img width="350" src="{{ resource_path('/assets/img/client/big_logo.jpg') }}" alt="logo"/>
    </div>
    <div class="text-center text-2xl">{{ $member->married ? sprintf("%s & %s %s", $member->name, $member->spouse->first_name, $member->spouse->last_name) : $member->name }}</div>
    <div class="text-center text-2xl mb-4">IRIS Financial Fact Finder {{ now()->format('m-d-Y') }}</div>
    <!-- Start: General -->
    <div class="flex items-center mb-2">
        <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
        <div class="text-xl text-primary font-semibold ml-2">General</div>
    </div>
    <div class="border border-main-gray rounded p-5 mb-8">
        <div class="flex flex-wrap">
            <div class="w-6/12 mb-4">
                <span>Retired:</span>
                <span class="font-semibold underline">{{ $member->retired ? 'Yes' : 'No' }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>Spouse/Partner:</span>
                <span class="font-semibold underline">{{ $member->married ? 'Yes' : 'No' }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>Name:</span>
                <span class="font-semibold underline">{{ $member->name }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>E-mail:</span>
                <span class="font-semibold underline">{{ $member->email }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>Date of birth:</span>
                <span class="font-semibold underline">{{ $member->birthday->format('m/d/Y') }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>Phone:</span>
                <span class="font-semibold underline">{{ $member->phone }}</span>
            </div>
            @if($member->retired)
                <div class="w-6/12 mb-4">
                    <span>Retirement date:</span>
                    <span class="font-semibold underline">{{ $member->retirement_date->format('m/d/Y') }}</span>
                </div>
            @endif
            <div class="w-6/12 mb-4">
                <span>Address:</span>
                <span class="font-semibold underline">{{ $member->address }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>State:</span>
                <span class="font-semibold underline">{{ $member->state }}</span>
            </div>
            <div class="w-6/12 mb-4">
                <span>City:</span>
                <span class="font-semibold underline">{{ $member->city }}</span>
            </div>
            <div class="w-6/12">
                <span>ZIP:</span>
                <span class="font-semibold underline">{{ $member->zip }}</span>
            </div>
        </div>
    </div>
    <!-- End: General -->


    @if($member->married)
        <!-- Start: Spouse/Partner -->
        <div class="flex items-center mb-2">
            <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
            <div class="text-xl text-primary font-semibold ml-2">Spouse/Partner</div>
        </div>
        <div class="border border-main-gray rounded p-5 mb-8">
            <div class="flex flex-wrap">
                <div class="w-6/12  mb-4">
                    <span>Retired:</span>
                    <span class="font-semibold underline">{{ $member->spouse->retired ? 'Yes' : 'No' }}</span>
                </div>
                <div class="w-6/12 mb-4">
                    <span>First name:</span>
                    <span class="font-semibold underline">{{ $member->spouse->first_name }}</span>
                </div>
                <div class="w-6/12 mb-4">
                    <span>Last name:</span>
                    <span class="font-semibold underline">{{ $member->spouse->last_name }}</span>
                </div>
                <div class="w-6/12 mb-4">
                    <span>E-mail:</span>
                    <span class="font-semibold underline">{{ $member->spouse->email }}</span>
                </div>
                <div class="w-6/12 mb-4">
                    <span>Date of birth:</span>
                    <span class="font-semibold underline">{{ $member->spouse->birthday->format('m/d/Y') }}</span>
                </div>
                <div class="w-6/12 mb-4">
                    <span>Phone:</span>
                    <span class="font-semibold underline">{{ $member->spouse->phone }}</span>
                </div>
                @if($member->spouse->retired)
                    <div class="w-6/12">
                        <span>Retirement date:</span>
                        <span
                            class="font-semibold underline">{{ $member->spouse->retirement_date->format('m/d/Y') }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif


    <!-- Start: Housing Information -->
    <div class="flex items-center mb-2">
        <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
        <div class="text-xl text-primary font-semibold ml-2">Housing Information</div>
    </div>
    <div class="border border-main-gray rounded p-5 mb-8">
        <!-- Start: Type -->
        <div class="flex mb-4">
            <div class="w-6/12">
                <span>Type:</span>
                <span class="font-semibold underline">{{ $member->house->type === MemberHouse::FAMILY ? "Live  with family" : Str::title($member->house->type) }}</span>
            </div>
        </div>
        <!-- End: Type -->

        <div class="flex flex-wrap">
            @if($member->house->type === MemberHouse::OWN || $member->house->type === MemberHouse::FAMILY)
                <div class="w-6/12 mb-4">
                    <span>Market value:</span>
                    <span class="font-semibold underline">${{ number_format($member->house->market_value) }}</span>
                </div>
            @endif
            <div class="w-6/12">
                <span>Monthly payments:</span>
                <span class="font-semibold underline">${{ number_format($member->house->monthly_payment) }}</span>
            </div>
            @if($member->house->type === MemberHouse::OWN || $member->house->type === MemberHouse::FAMILY)
                <div class="w-6/12">
                    <span>Remaining mortgage:</span>
                    <span class="font-semibold underline">${{ number_format($member->house->remaining_mortgage_amount) }}</span>
                </div>
            @endif
            @if($member->house->type === MemberHouse::RENT)
                <div class="w-6/12">
                    <span>Total monthly expences:</span>
                    <span class="font-semibold underline">${{ number_format($member->house->total_monthly_expenses) }}</span>
                </div>
            @endif
        </div>

    </div>
    <!-- End: Housing Information -->

    <?php

    $countEmploymentHistory = $member->employmentHistory->count() + ($member->married ? $member->spouse->employmentHistory->count() : 0);
    $groups = [];
    $firstPageSize = 7;
    $pageSize = 25;
    $lastPageSize = 0;

    while ($countEmploymentHistory > 0) {
        $size = $pageSize;
        if (empty($groups)) {
            $size = $firstPageSize;
        }
        $memberEmploymentHistory = null;
        $spouseEmploymentHistory = null;
        if ($member->employmentHistory->count() !== 0) {
            $memberEmploymentHistory = $member->employmentHistory->shift($size);
            $memberEmploymentHistory = $memberEmploymentHistory instanceof \Illuminate\Support\Collection ? $memberEmploymentHistory : collect()->push($memberEmploymentHistory);
        }
        if ($memberEmploymentHistory?->count() < $size && $member->married) {
            $spouseEmploymentHistory = $member->spouse->employmentHistory->shift($size - $memberEmploymentHistory?->count());
            $spouseEmploymentHistory = $spouseEmploymentHistory instanceof \Illuminate\Support\Collection ? $spouseEmploymentHistory : collect()->push($spouseEmploymentHistory);
        }

        $groups[] = [
            'member' => $memberEmploymentHistory,
            'spouse' => $spouseEmploymentHistory,
        ];
        $lastPageSize = $memberEmploymentHistory?->count() ?? 0 + ($spouseEmploymentHistory?->count() ?? 0);
        $countEmploymentHistory = $member->employmentHistory->count() + ($member->married ? $member->spouse->employmentHistory->count() : 0);
    }
    ?>

    @foreach($groups as $group)
        @if(!$loop->first)
</div>
<div class="page">
@endif
<!-- Start: Employment history -->
<div class="flex items-center mb-2">
    <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
    <div class="text-xl text-primary font-semibold ml-2">Employment history</div>
</div>
<div class="border border-main-gray rounded p-5 mb-8">
    @if($group['member'] !== null)
        <div class="mb-2">CONTACT</div>
            <?php /** @var App\Containers\AppSection\Member\Models\MemberEmploymentHistory $employmentHistory */ ?>
        @foreach($group['member'] as $employmentHistory)
            <div class="flex flex-wrap">
                <div class="w-4/12 mb-4">
                    <span>Company name:</span>
                    <span class="font-semibold underline">{{ $employmentHistory->company_name }}</span>
                </div>
                <div class="w-4/12">
                    <span>Occupation:</span>
                    <span class="font-semibold underline">{{ $employmentHistory->occupation }}</span>
                </div>
                <div class="w-4/12">
                    <span>Years:</span>
                    <span class="font-semibold underline">{{ $employmentHistory->years }}</span>
                </div>
            </div>
        @endforeach
    @endif
    @if($member->married && $group['spouse'] !== null)
        <div class="mb-2 mt-4">SPOUSE/PARTNER</div>
            <?php /** @var App\Containers\AppSection\Member\Models\MemberEmploymentHistory $employmentHistory */ ?>
        @foreach($group['spouse'] as $employmentHistory)
            <div class="flex flex-wrap">
                <div class="w-4/12 mb-4">
                    <span>Company name:</span>
                    <span class="font-semibold underline">{{ $employmentHistory->company_name }}</span>
                </div>
                <div class="w-4/12">
                    <span>Occupation:</span>
                    <span class="font-semibold underline">{{ $employmentHistory->occupation }}</span>
                </div>
                <div class="w-4/12">
                    <span>Years:</span>
                    <span class="font-semibold underline">{{ $employmentHistory->years }}</span>
                </div>
            </div>
        @endforeach
    @endif

</div>
@endforeach

    </div>
    <div class="page">

        <!-- Start: Other -->
        <div class="flex items-center mb-2">
            <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
            <div class="text-xl text-primary font-semibold ml-2">Other</div>
        </div>
        <div class="border border-main-gray rounded p-5 mb-8">
            <div class="flex mb-4">
                <span>Have you watched us during the news on any channel? (If yes, Please specify the channel)?</span>
                <span class="font-semibold underline pl-2">{{ $member->is_watch ? 'Yes' : 'No' }}</span>
            </div>
            @if($member->is_watch)
                <div class="flex mb-4">
                    <span>Channels:</span>
                    <span class="pl-2 font-semibold">{{ $member->channels }}</span>
                </div>
            @endif
            <div class="flex mb-4">
                <span>I have saved the following amount for retirement:</span>
                <?php
                    $key = array_search($member->amount_for_retirement, Member::AMOUNT_FOR_RETIREMENT_TYPE);
                    $amount_for_retirement = match(array_key_last(Member::AMOUNT_FOR_RETIREMENT_TYPE) === $key) {
                        true => sprintf("$%s+", number_format(Member::AMOUNT_FOR_RETIREMENT_TYPE[$key])),
                        false => sprintf("$%s-$%s", number_format(Member::AMOUNT_FOR_RETIREMENT_TYPE[$key]), number_format(Member::AMOUNT_FOR_RETIREMENT_TYPE[$key + 1])),
                    };
                ?>
                <span class="font-semibold underline pl-2">{{ $amount_for_retirement }}</span>
            </div>
            <div class="mb-4">
                <div>My biggest financial concerns are:</div>
                <div class="border border-main-gray rounded p-5">
                    {{ $member->biggest_financial_concern }}
                </div>
            </div>
            <div class="flex mb-4">
                <span>Risk tolerance:</span>
                <span class="font-semibold underline pl-2">{{ Str::replace('_', ' ', Str::title($member->other?->risk)) }}</span>
            </div>
            <div class="mb-4">
                <div>Do you have any specific question to discuss?</div>
                <div class="border border-main-gray rounded p-5">
                    {{ $member->other?->questions }}
                </div>
            </div>
            <div class="mb-4">
                <div>What are your goals for Retirement?</div>
                <div class="border border-main-gray rounded p-5">
                    {{ $member->other?->retirement }}
                </div>
            </div>
            <div class="mb-4">
                <div>What are your goals for Retirement money?</div>
                <div class="border border-main-gray rounded p-5">
                    {{ $member->other?->retirement_money }}
                </div>
            </div>
            <div class="flex">
                <span>Are you currently working with an Advisor?</span>
                <span class="font-semibold underline pl-2">{{ $member->other?->work_with_advisor ? 'Yes' : 'No' }}</span>
            </div>
        </div>
        <!-- End: Other -->
    </div>
