<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script type="module" crossorigin src="{{ resource_path('/assets/js/client/basic_info.js') }}"></script>
    <script type="module" crossorigin src="{{ resource_path('/assets/js/client/assets_income.js') }}"></script>
    <script type="module" crossorigin src="{{ resource_path('/assets/js/client/expenses.js') }}"></script>
    <link rel="stylesheet" href="{{ resource_path('/assets/css/client/basic_info.css') }}">
    <link rel="stylesheet" href="{{ resource_path('/assets/css/client/assets_income.css') }}">
    <link rel="stylesheet" href="{{ resource_path('/assets/css/client/expenses.css') }}">
</head>

<body>
<div class="content">
    @include('appSection@client::basic_info', ['member' => $member])
    @include('appSection@client::assets_income', [
                             'schema' => $assets_income['schema'],
                             'values' => $assets_income['values'],
                         ])
    @include('appSection@client::expenses', [
                             'expenses' => $expenses,
                         ])
</div>
</body>
</html>
