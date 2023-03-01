<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('/assets/css/admin.css') }}"/>
    <link rel="icon" href="{{ asset('assets/img/logo.svg') }}">
</head>
<body>
<div class="container-fluid">
    @include('appSection@admin::header')
    @include('appSection@admin::sidebar', ['menu_items' => [
        'Home'  => [
            'route' => 'web_admin_home',
            'icon'  => 'fa fa-home'
        ],
        'Users' => [
            'route' => 'web_admin_users',
            'icon'  => 'fa fa-user'
        ],
        'Companies' => [
            'route' => 'web_admin_companies',
            'icon'  => 'fa fa-building'
        ],
        'Client Videos' => [
            'route' => 'web_admin_client_videos',
            'icon'  => 'fa-solid fa-video'
        ],
        'Admin Tools' => [
            'route' => 'web_admin_tools',
            'icon'  => 'fa fa-toolbox'
        ]
    ]])
</div>
</body>
<script src="{{ mix('/assets/js/admin.js') }}"></script>
@stack('custom')
</html>
