<?php

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\GroupSchema;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\RowSchema;
use Illuminate\Support\Collection;

/** @var Collection $schema */

/** @var GroupSchema $currentIncome */
$currentIncome = $schema[GroupsEnum::CURRENT_INCOME];

/** @var GroupSchema $liquidAssets */
$liquidAssets = $schema[GroupsEnum::LIQUID_ASSETS];

$liquidAssetsRows = $liquidAssets->rows->filter(fn (RowSchema $row) => !$row->isDropdown());

$groups = [];
$firstPageSize = 29;
$pageSize = 40;

while ($liquidAssetsRows->count() > 0) {
    $size = $pageSize;
    if (empty($groups)) {
        $size = $firstPageSize;
    }

    $lastPageSize = $liquidAssetsRows->count();
    $groups[] = $liquidAssetsRows->shift($size);
}


/** @var GroupSchema $liquidAssets */
$otherAssetsInvestments = $schema[GroupsEnum::OTHER_ASSETS_INVESTMENTS];
?>
<div class="page">
    <div class="text-center font-semibold text-2xl">Assets & Income</div>
    <!-- Start: Current Income -->
    <div class="flex items-center mb-2">
        <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
        <div class="text-xl text-primary font-semibold ml-2">Current Income</div>
    </div>
    <div class="border border-main-gray rounded pt-5 px-5 mb-8">
        <div class="flex items-center mb-4">
            <div class="w-4/12"></div>
            <div class="w-2/12">{{ $currentIncome->headers['owner']['label'] }}</div>
            @if(isset($currentIncome->headers['spouse']))
                <div class="w-2/12">{{ $currentIncome->headers['spouse']['label'] }}</div>
            @endif
        </div>
        <?php /** @var RowSchema $row */ ?>
        @foreach($currentIncome->rows as $row)
            <div class="flex mb-4">
                <div class="w-3/12 font-semibold">{{ $row->label }}</div>
                <div class="w-1/12"></div>
                <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                    ${{ number_format($values->current_income[$row->name]['owner'] ?? 0) }}</div>
                @if(array_key_exists('spouse', $values->current_income[$row->name]))
                    <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                        ${{ number_format($values->current_income[$row->name]['spouse'] ?? 0) }}</div>
                @endif
            </div>
        @endforeach
    </div>
    <!-- End: Current Income -->


    @foreach($groups as $group)
        @if(!$loop->first)
            </div>
            <div class="page">
        @endif
        <!-- Start: Liquid Assets -->
        <div class="flex items-center mb-2">
            <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
            <div class="text-xl text-primary font-semibold ml-2">Liquid Assets</div>
        </div>
        <div class="border border-main-gray rounded pt-5 px-5 mb-8">
            <div class="flex items-center mb-4">
                <div class="w-4/12"></div>
                <div class="w-2/12">{{ $liquidAssets->headers['owner']['label'] }}</div>
                @if(isset($liquidAssets->headers['spouse']))
                    <div class="w-2/12">{{ $liquidAssets->headers['spouse']['label'] }}</div>
                @endif
                <div class="w-2/12">Institution</div>
                <div class="w-2/12">Household</div>
            </div>
                <?php /** @var RowSchema $row */ ?>
            @foreach($group as $row)
                <div class="flex items-center mb-4">
                    <div class="w-3/12 font-semibold">{{ $row->label }}</div>
                    <div class="w-1/12"></div>
                    <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                        ${{ number_format($values->liquid_assets[$row->name]['owner'] ?? 0) }}</div>
                    @if(array_key_exists('spouse', $values->liquid_assets[$row->name]))
                        <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                            ${{ number_format($values->liquid_assets[$row->name]['spouse'] ?? 0) }}</div>
                    @endif
                    <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">@if($row->name === 'total')
                            -
                        @else
                            {{ $values->liquid_assets[$row->name]['institution'] }}
                        @endif</div>
                    <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                        ${{ number_format($values->liquid_assets[$row->name]['household']) }}</div>
                </div>
            @endforeach
        </div>
        <!-- End: Liquid Assets -->
        @if(!$loop->last || $lastPageSize > 20)
            </div>
            <div class="page">
        @endif
    @endforeach


    @if($lastPageSize > 20)
        </div>
        <div class="page">
    @endif
    <!-- Start: Other Assets/Investments -->
    <div class="flex items-center mb-2">
        <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done"/>
        <div class="text-xl text-primary font-semibold ml-2">Other Assets/Investments</div>
    </div>
    <div class="border border-main-gray rounded pt-5 px-5 mb-8">
        <div class="flex items-center mb-4">
            <div class="w-4/12"></div>
            <div class="w-2/12">{{ $otherAssetsInvestments->headers['owner']['label'] }}</div>
            @if(isset($otherAssetsInvestments->headers['spouse']))
                <div class="w-2/12">{{ $otherAssetsInvestments->headers['spouse']['label'] }}</div>
            @endif
            <div class="w-2/12">Institution</div>
            <div class="w-2/12">Household</div>
        </div>
        <?php /** @var RowSchema $row */ ?>
        @foreach($otherAssetsInvestments->rows as $row)
            @if($row->isDropdown())
                @continue
            @endif
            <div class="flex items-center mb-4">
                <div class="w-3/12 font-semibold">{{ $row->label }}</div>
                <div class="w-1/12"></div>
                <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                    ${{ number_format($values->other_assets_investments[$row->name]['owner'] ?? 0)}}</div>
                @if(array_key_exists('spouse', $values->other_assets_investments[$row->name]))
                    <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                        ${{ number_format($values->other_assets_investments[$row->name]['spouse'] ?? 0)}}</div>
                @endif
                <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">@if($row->name === 'total')
                        -
                    @else
                        {{ $values->other_assets_investments[$row->name]['institution'] }}
                    @endif</div>
                <div class="w-2/12 @if($row->name === 'total') font-semibold @endif">
                    ${{ number_format($values->other_assets_investments[$row->name]['household']) }}</div>
            </div>
        @endforeach
    </div>
    <!-- End: Other Assets/Investments -->
</div>
