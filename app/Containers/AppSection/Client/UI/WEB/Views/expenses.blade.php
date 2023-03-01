<?php
    use \Illuminate\Support\Str;
?>
<div class="page">
    <div class="text-center font-semibold text-2xl">Expenses</div>
    @foreach($expenses['data'] as $name => $group)
        @if($name === 'total' || $name === 'subtotal')
            @continue
        @endif
        @if($name === 'hobbies')
            </div>
            <div class="page">
        @endif
        <div class="flex items-center mb-2">
            <img src="{{ resource_path('/assets/img/client/icon-done-step.svg') }}" alt="icon-done" />
            <div class="text-xl text-primary font-semibold ml-2">{{ Str::replace('_', ' ', Str::title($name)) }}</div>
        </div>
        <div class="border border-main-gray rounded pt-5 px-5 mb-8">
            <div class="flex mb-4">
                <div class="w-4/12"></div>
                <div class="w-4/12">ESSENTIAL</div>
                <div class="w-4/12">DISCRETIONARY</div>
            </div>
            @foreach($group as $name => $row)
                <div class="flex mb-4">
                    <div class="w-4/12 font-semibold">{{ Str::replace('_', ' ', Str::title($name)) }}</div>
                    <div class="w-4/12">${{ number_format($row['essential'] ?? 0)}}</div>
                    <div class="w-4/12">${{ number_format($row['discretionary'] ?? 0)}}</div>
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="pt-5 px-5 mb-8">
        <div class="flex mb-8">
            <div class="w-4/12 font-semibold">Subtotal</div>
            <div class="w-4/12">${{ number_format($expenses['data']['subtotal']['essential']) }}</div>
            <div class="w-4/12">${{ number_format($expenses['data']['subtotal']['discretionary']) }}</div>
        </div>
        <div class="flex">
            <div class="w-8/12 font-semibold">TOTAL MONTHLY EXPENSES</div>
            <div class="w-4/12">${{ number_format($expenses['data']['total']) }}</div>
        </div>
    </div>
</div>
