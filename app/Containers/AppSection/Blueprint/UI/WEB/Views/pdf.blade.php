<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="{{ resource_path('/assets/img/blueprint_report_favicon.svg') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vite App</title>
    <script type="module" crossorigin src="{{ resource_path('/assets/js/blueprint_report.js') }}"></script>
    <link rel="stylesheet" href="{{ resource_path('/assets/css/blueprint_report.css') }}">
</head>

<body>

<div class="content">
    <!-- START PAGE -->
    <div class="page">
        <div class="flex items-center">
            <div class="w-1/3">
                <img src="{{ resource_path('/assets/img/blueprint_report_logo.png') }}" alt="" class="h-24 ml-10">
            </div>
            <div class="flex flex-col items-center text-xl title-page w-1/3">
                <span>{{ $name }}</span>
                <span>Blueprint report {{ $year }}</span>
            </div>
        </div>

        <div class="flex">
            <div class="w-7/12 mr-2">
                <div class="border border-color-grey rounded-lg mr-5 p-5">
                    <span class="text-main text-base font-semibold">Net Worth</span>
                    <div class="flex text-sm mb-3">
                        <div class="mt-5">
                            <div class="flex items-center">
                                <div class="bg-dark-blue-charts w-2 h-2 rounded-full mr-2"></div>
                                <div class="w-4/12">Liquid</div>
                                <div class="border rounded-lg w-32 text-center mx-2 py-0.5">${{ number_format($netWorth['liquid']['amount'], 3) }}</div>
                                <div class="font-semibold">{{ $netWorth['liquid']['percentage'] }}%</div>
                            </div>
                            <div class="flex items-center my-2">
                                <div class="bg-activity w-2 h-2 rounded-full mr-2"></div>
                                <div class="w-4/12">Market</div>
                                <div class="border rounded-lg w-32 text-center mx-2 py-0.5">${{ number_format($netWorth['market']['amount'], 3) }}</div>
                                <div class="font-semibold">{{ $netWorth['market']['percentage'] }}%</div>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-color-error w-2 h-2 rounded-full mr-2"></div>
                                <div class="w-4/12">Income safe</div>
                                <div class="border rounded-lg w-32 text-center mx-2 py-0.5">${{ number_format($netWorth['income_safe']['amount'], 3) }}</div>
                                <div class="font-semibold">{{ $netWorth['income_safe']['percentage'] }}%</div>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center w-1/2">
                            <span class="font-semibold mb-2">Total</span>
                            <span>${{ number_format($netWorth['sum'], 3) }}</span>
                        </div>
                    </div>
                </div>

                <div class="border border-color-grey rounded-lg mr-5 p-5 mt-5">
                    <span class="text-main text-base font-semibold">Concerns</span>
                    <div class="flex pt-5">
                        <div class="text-sm flex flex-col mr-10 font-medium">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="custom-checkbox" @if ($concern !== null && $concern['high_fees'] === true) checked @endif>
                                <span class="ml-2">High Fees</span>
                            </label>
                            <label class="inline-flex items-center my-2">
                                <input type="checkbox" class="custom-checkbox" @if ($concern !== null && $concern['extremely_high_market_exposure'] === true) checked @endif>
                                <span class="ml-2">Extremely high market exposure</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="custom-checkbox" @if ($concern !== null && $concern['design_implement_monitoring_income_strategy'] === true) checked @endif>
                                <span class="ml-2 text-gray-400">Design, implement and monitoring income strategy</span>
                            </label>
                        </div>
                        <div class="flex flex-col text-sm">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="custom-checkbox" @if ($concern !== null && $concern['keep_the_money_safe'] === true) checked @endif>
                                <span class="ml-2">Keep the money safe</span>
                            </label>
                            <label class="inline-flex items-center my-2">
                                <input type="checkbox" class="custom-checkbox" @if ($concern !== null && $concern['massive_overlap'] === true) checked @endif>
                                <span class="ml-2 text-gray-400">Massive Overlap</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="custom-checkbox" @if ($concern !== null && $concern['simple'] === true) checked @endif>
                                <span class="ml-2 text-gray-400">Simple</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border border-color-grey rounded-lg mr-5 p-5 mt-5">
                    <span class="text-main text-base font-semibold">Notes</span>
                    <div class="text-sm pt-5">
                        <p>Notes text</p>
                    </div>
                </div>
            </div>


            <div class="w-5/12 ml-2 text-sm">
                <div class="bg-widget-bg pt-5 pl-5 pb-2 rounded-tr-lg rounded-tl-lg font-medium">
                    Monthly Income analysis
                </div>
                <div class="flex border-b border-r border-l border-color-grey py-4">
                    <div class="w-4/12"></div>
                    <div class="w-4/12 text-gray03">Current</div>
                    <div class="w-4/12 text-gray03">Future</div>
                </div>
                <div>
                    <!-- Member -->
                    <div class="flex justify-center items-center px-3 border-b border-r border-l border-color-grey py-4">
                        <div class="w-4/12">Member</div>
                        <span class="w-4/12 mr-1">${{ number_format($monthlyIncome->current_member, 3) }}</span>
                        <span class="w-4/12 ml-1">${{ number_format($monthlyIncome->future_member, 3) }}</span>
                    </div>
                    <!-- Spouse -->
                    <div class="flex justify-center items-center px-3 border-b border-r border-l border-color-grey py-4">
                        <div class="w-4/12 ">Spouse</div>
                        <span class="w-4/12 mr-1">${{ number_format($monthlyIncome->current_spouse, 3) }}</span>
                        <span class="w-4/12 ml-1">${{ number_format($monthlyIncome->future_spouse, 3) }}</span>
                    </div>
                    <!-- Pensions -->
                    <div class="flex justify-center items-center px-3 border-b border-r border-l border-color-grey py-4">
                        <div class="w-4/12 ">Pensions</div>
                        <span class="w-4/12 mr-1">${{ number_format($monthlyIncome->current_pensions, 3) }}</span>
                        <span class="w-4/12 ml-1">${{ number_format($monthlyIncome->future_pensions, 3) }}</span>
                    </div>
                    <!-- Rental income -->
                    <div class="flex justify-center items-center px-3 border-b border-r border-l border-color-grey py-4">
                        <div class="w-4/12">Rental income</div>
                        <span class="w-4/12 mr-1">${{ number_format($monthlyIncome->current_rental_income, 3) }}</span>
                        <span class="w-4/12 ml-1">${{ number_format($monthlyIncome->future_rental_income, 3) }}</span>
                    </div>
                    <!-- Investments -->
                    <div class="flex justify-center items-center px-3 border-r border-l border-color-grey py-4">
                        <div class="w-4/12 ">Investments</div>
                        <span class="w-4/12 mr-1">${{ number_format($monthlyIncome->current_investment, 3) }}</span>
                        <span class="w-4/12 ml-1">${{ number_format($monthlyIncome->future_investment, 3) }}</span>
                    </div>

                    <div class="bg-widget-bg px-3 py-2 font-medium flex justify-between">
                        <div class="w-8/12">Total</div>
                        <span class="w-4/12">${{ number_format($monthlyIncome->total, 3) }}</span>
                    </div>

                    <!-- Tax -->
                    <div class="flex justify-center items-center border-b border-r border-l border-color-grey py-4 px-3">
                        <div class="w-8/12">Tax</div>
                        <span class="w-4/12">${{ number_format($monthlyIncome->tax, 3) }}</span>
                    </div>
                    <!-- IRA -->
                    <div class="flex justify-center items-center border-b border-r border-l border-color-grey py-4 px-3">
                        <div class="w-8/12">IRA</div>
                        <span class="w-4/12">${{ number_format($monthlyIncome->ira_first, 3) }}</span>
                    </div>
                    <!-- IRA SECOND-->
                    <div class="flex justify-center items-center border-b border-r border-l border-color-grey py-4 px-3">
                        <div class="w-8/12">IRA</div>
                        <span class="w-4/12">${{ number_format($monthlyIncome->ira_second, 3) }}</span>
                    </div>
                </div>
                <div
                        class="flex justify-center items-center bg-color-light-blue py-3 px-3 rounded-br-lg rounded-bl-lg font-medium">
                    <div class="w-8/12">Monthly Expenses:</div>
                    <span class="w-4/12">${{ number_format($monthlyIncome->monthly_expenses, 3) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>


</body>

</html>