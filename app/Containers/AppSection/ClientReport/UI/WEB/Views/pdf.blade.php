<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="{{ resource_path('/assets/img/blueprint_report_favicon.svg') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="module" crossorigin src="{{ resource_path('/assets/js/client_report.js') }}"></script>
    <link rel="stylesheet" href="{{ resource_path('/assets/img/client_report_logo.png') }}">
</head>

<body>

<div class="content">
    <!-- START PAGE -->
    <div class="page">
        <div class="flex items-center">
            <div class="w-1/3">
                <img src="{{ resource_path('/assets/img/client_report_logo.png') }}" alt="" class="h-24 ml-10">
            </div>
            <div class="flex flex-col items-center text-xl title-page w-1/3">
                <span>{{ $name }}</span>
                <span>Progress Report {{ $year }}</span>
            </div>
        </div>
        @foreach($clientReportsPages as $page)
            @foreach($page as $clientReport)
                <div class="contract-item">
                    <div class="p-5">
                        <div class="flex justify-between">
                            <div>
                                <span>Registration: </span>
                                <span>{{ $clientReport['carrier'] }}</span>
                            </div>
{{--                            <div>--}}
{{--                                <span>Income Account Value: </span>--}}
{{--                                <span>-</span>--}}
{{--                            </div>--}}
                        </div>

                        <div class="flex justify-between">
                            <div>
                                <span>Contract#: </span>
                                <span>{{ $clientReport['contract_number'] }}</span>
                            </div>
                            <div>
                                <span>Issue/Anniversary Date: </span>
                                <span>{{ $clientReport['formatted_origination_date'] }}</span>
                            </div>
                            <div>
                                <span>Contract Years: </span>
                                <span>{{ $clientReport['contract_years'] }}</span>
                            </div>
{{--                            <div>--}}
{{--                                <span>Lifetime Income: </span>--}}
{{--                                <span>2021</span>--}}
{{--                            </div>--}}
                        </div>

                        <table class="w-full table-auto border-collapse border text-xs font-semibold">
                            <tr>
                                <th colspan="5" scope="colgroup" class="border border-black w-5/10 color-current-year">Current Year</th>
                                <th colspan="5" scope="colgroup" class="border border-black w-5/10 color-since">Since Inception</th>
                            </tr>
                            <tr>
                                <th class="border border-black w-1/10 color-current-year" scope="col">Beginning Balance</th>
                                <th class="border border-black w-1/10 color-current-year" scope="col">Interested Credited</th>
                                <th class="border border-black w-1/10 color-current-year" scope="col">Growth</th>
                                <th class="border border-black w-1/10 color-current-year" scope="col">Withdrawals</th>
                                <th class="border border-black w-1/10 color-current-year" scope="col">Contract value</th>
                                <th class="border border-black w-1/10 color-since" scope="col">Total Premiums</th>
                                <th class="border border-black w-1/10 color-since" scope="col">
                                    Bonus Received
                                    <br>
                                    <span class="font-normal">(if applicable)</span>
                                </th>
                                <th class="border border-black w-1/10 color-since" scope="col">Interested Credited</th>
                                <th class="border border-black w-1/10 color-since" scope="col">Total Withdrawals</th>
                                <th class="border border-black w-1/10 color-since" scope="col">Average Growth</th>
                            </tr>
                            <tr>
{{-- Beginning Balance --}}     <td class="border border-black w-1/10">{{ number_format($clientReport['origination_value'], 3) }}</td>
{{-- Interested Credited --}}   <td class="border border-black w-1/10">-</td>
{{-- Growth --}}                <td class="border border-black w-1/10">-</td>
{{-- Withdrawals --}}           <td class="border border-black w-1/10">-</td>
{{-- Contract value --}}        <td class="border border-black w-1/10">{{ number_format($clientReport['current_value'], 3) }}</td>
{{-- Total Premiums --}}        <td class="border border-black w-1/10">-</td>
{{-- Bonus Received --}}        <td class="border border-black w-1/10">-</td>
{{-- Interested Credited --}}   <td class="border border-black w-1/10">-</td>
{{-- Total Withdrawals --}}     <td class="border border-black w-1/10">-</td>
{{-- Average Growth --}}        <td class="border border-black w-1/10">-</td>
                            </tr>
                        </table>
                        <div class="flex">
                            <span class="pr-2">Total Fees:</span>
                            <span>-</span>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(!$loop->last)
                <div style="page-break-before: always;"></div>
            @endif
        @endforeach
        <div class="p-5 w-96 total-info ml-auto mr-0">
            <div class="border-2 border-black flex justify-between">
                <span class="pl-3 w-7/12">TDA Total Value</span>
                <span class="color-since w-5/12 text-center">-</span>
            </div>
            <div class="border-2 border-black flex justify-between mt-3">
                <span class="pl-3 w-7/12">Total Current Value</span>
                <span class="color-since w-5/12 text-center">-</span>
            </div>
        </div>
    </div>
    <!-- END PAGE -->

</div>

</body>

</html>
