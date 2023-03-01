@extends('appSection@admin::main')
<?php
   $items = [
       [
           'title' => 'Swagger',
           'route' => 'documentation-page-swagger-collection',
           'logo'  => 'assets/img/admin_tools/swagger_logo.png',
           'description' => 'API Routes Documentation',
           'blank'  => true,
       ],
       [
           'title' => 'Log Viewer',
           'route' => 'blv.index',
           'logo'  => 'assets/img/admin_tools/log_viewer_icon.png',
           'description' => 'Simple Way to View Logs',
           'blank'  => true,
       ],
       [
           'title' => 'Horizon',
           'route' => 'horizon.index',
           'logo'  => 'vendor/horizon/img/favicon.png',
           'description' => 'Dashboard For Queues',
           'blank'  => true,
       ],
       [
           'title' => 'Telescope',
           'route' => 'telescope',
           'logo'  => 'vendor/telescope/favicon.ico',
           'description' => 'Simple App Dashboard',
           'blank'  => true,
       ],
       [
           'title' => 'Prequel',
           'route' => 'prequel.index',
           'logo'  => 'vendor/prequel/favicon.png',
           'description' => 'Simple Database Dashboard',
           'blank'  => true,
       ],
       [
           'title' => 'Hashing',
           'route' => 'web_admin_hashing_view',
           'logo'  => 'assets/img/admin_tools/hashing-logo.png',
           'description' => 'Encode or Decode Hash IDs',
           'blank'  => false,
       ],
       [
           'title' => 'XHProf',
           'route' => 'web_admin_xhprof',
           'logo'  => 'assets/img/admin_tools/xhprof_logo.png',
           'description' => 'Profiler for All requests',
           'blank'  => true,
       ],
       [
           'title' => 'Centrifugo',
           'route' => 'web_admin_centrifugo',
           'logo'  => 'assets/img/admin_tools/centrifugo_logo.svg',
           'description' => 'Admin Panel for WebSockets',
           'blank'  => true,
       ],
       [
           'title' => 'Statuses',
           'route' => 'web_admin_salesforce_import_status',
           'logo'  => 'assets/img/admin_tools/salesforce_logo.png',
           'description' => 'Get Status of Salesforce',
           'blank'  => false,
       ],
       [
           'title' => 'RabbitMQ',
           'route' => 'web_admin_rabbitmq',
           'logo'  => 'assets/img/admin_tools/rabbitmq_logo.png',
           'description' => 'RabbitMQ Dashboard',
           'blank'  => true,
       ],
       [
           'title' => 'RedisUI',
           'route' => 'redis_ui',
           'logo'  => 'assets/img/admin_tools/redis_logo.png',
           'description' => 'Redis Dashboard',
           'blank'  => true,
       ],
       [
           'title' => 'PHPInfo',
           'route' => 'api_ping_get_phpinfo',
           'logo'  => 'assets/img/admin_tools/php_logo.png',
           'description' => 'PHP Config Info',
           'blank'  => true,
       ],
   ]
?>
@section('content')
    <div class="container-fluid">
        @foreach(array_chunk($items, 3) as $chunk)
            <div class="row mt-5">
                @foreach($chunk as $item)
                    <div class="@if($loop->first) offset-1 @endif col-3 me-3">
                        <a href="{{ route($item['route']) }}" @if($item['blank']) target="_blank" @endif class="row p-0 justify-content-center d-flex border tool-button btn btn-outline-secondary">
                            <div class="d-flex align-items-center justify-content-center h-75 py-2">
                                <div class=""><img class="admin-icon" src="{{ asset($item['logo']) }}" alt="logo"></div>
                                <div class="ms-4"><p class="h3 text-dark">{{ $item['title'] }}</p></div>
                            </div>
                            <div class="row col-12 h-25 border-top d-flex align-items-center py-1"><p class="mb-0 text-dark">{{ $item['description'] }}</p></div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@stop
