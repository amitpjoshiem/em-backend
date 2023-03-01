@extends('appSection@admin::main')
<?php /** @var \Illuminate\Support\Collection $imports */ ?>
<?php /** @var \Illuminate\Support\Collection $importExceptions */ ?>
<?php /** @var \Illuminate\Support\Collection $exportExceptions */ ?>
<?php
$importExceptions = $importExceptions->groupBy('object');
?>





@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-content-center"><a href="{{ route('web_admin_tools') }}"><h4
                                class="m-0">Tools</h4></a></li>
                    <li class="breadcrumb-item active d-flex align-content-center" aria-current="page"><h4 class="m-0">
                            Salesforce Statuses</h4></li>
                </ol>
            </nav>
        </div>
        <div class="row mt-4" id="salesforce_api_status" data-url="{{ route('web_admin_salesforce_api_status') }}">
            <span class="col-3 d-flex align-items-center"><p class="h3">Connection status:</p></span><span
                class="col-1 d-flex align-items-center"><i class="fa-solid fa-circle fa-xl text-secondary"></i></span>
        </div>
        <div class="table-responsive mt-5">
            <p class="h3">Imports status:</p>
            <table class="table table-bordered import-status-table mt-4" id="import_status_table"
                   data-url="{{ route('web_admin_salesforce_import_status_data') }}">
                <caption>
                    <div id="server_time"></div>
                </caption>
                <thead>
                <tr>
                    <th class="text-center align-middle" scope="col" colspan="1" rowspan="2">Import Object</th>
                    <th class="text-center align-middle" scope="col" colspan="2">Last Import Time</th>
                    <th class="text-center align-middle" scope="col" colspan="1" rowspan="2">Diff</th>
                </tr>
                <tr>
                    <th class="text-center align-middle">Local</th>
                    <th class="text-center align-middle">Server</th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var \App\Containers\AppSection\Salesforce\Models\SalesforceImport $import */ ?>
                @foreach($imports as $import)
                    <tr class="import-row border accordion-toggle"
                        data-timestamp="{{ $import->end_date->getPreciseTimestamp(3) }}"
                        data-object="{{ $import->getObjectName() }}" data-bs-toggle="collapse"
                        data-bs-target="#{{ $import->getObjectName() }}">
                        <td class="d-flex justify-content-between">{{ $import->getObjectName() }}
                            @if ($importExceptions->hasAny($import->object::getObjectModel()) )
                                <span class="fa-stack">
                                        <span class="fa fa-circle fa-stack-2x text-danger"></span>
                                        <strong class="fa-stack-1x text-dark">
                                            {{ $importExceptions->get($import->object::getObjectModel())->count() }}
                                        </strong>
                                    </span>
                            @endif
                        </td>
                        <td class="import-time-local"></td>
                        <td class="import-time-server"></td>
                        <td class="import-diff"></td>
                    </tr>
                    @if ($importExceptions->hasAny($import->object::getObjectModel()))
                        <tr class="collapse" id="{{ $import->getObjectName() }}">
                            <td colspan="4">
                                <div>
                                    <table class="table table-bordered table-sm table-striped">
                                        <thead>
                                        <tr>
                                            <th>Salesforce ID</th>
                                            <th>Message</th>
                                            <th>Salesforce Data</th>
                                            <th>Trace</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php /** @var \App\Containers\AppSection\Salesforce\Models\SalesforceImportException $exception */ ?>
                                        @foreach($importExceptions->get($import->object::getObjectModel()) as $exception)
                                            <tr>
                                                <td>{{ $exception->salesforce_id }}</td>
                                                <td class="w-50">{{ $exception->message }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#data_{{ $exception->getHashedKey() }}">
                                                        Data
                                                    </button>
                                                    <div class="modal fade" id="data_{{ $exception->getHashedKey() }}"
                                                         tabindex="-1"
                                                         aria-labelledby="label_{{ $exception->getHashedKey() }}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="label_{{ $exception->getHashedKey() }}">
                                                                        Salesforce Data</h5>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Key</th>
                                                                            <th>Data</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach  ($exception->salesforce_data as $key => $data)
                                                                            <tr>
                                                                                <td>{{ $key }}</td>
                                                                                <td>{{ is_array($data) ? var_export($data) : $data }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#trace_{{ $exception->getHashedKey() }}">
                                                        Trace
                                                    </button>
                                                    <div class="modal fade" id="trace_{{ $exception->getHashedKey() }}"
                                                         tabindex="-1"
                                                         aria-labelledby="label_trace_{{ $exception->getHashedKey() }}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="label_trace_{{ $exception->getHashedKey() }}">
                                                                        Trace</h5>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-striped">
                                                                        <tbody>
                                                                        @foreach(explode(PHP_EOL, $exception->trace) as $row)
                                                                            <tr>
                                                                                <td><p>{{ $row }}</p></td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-4" id="salesforce_api_status" data-url="{{ route('web_admin_salesforce_api_status') }}">
            <span class="col-3 d-flex align-items-center"><p class="h3">Export Exceptions:</p></span>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Object</th>
                <th>Object ID</th>
                <th>Request Data</th>
                <th>Response Data</th>
                <th>Method</th>
                <th>Url</th>
                <th>Trace</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if($exportExceptions->isEmpty())
                <tr>
                   <td colspan="8">
                       No Exceptions
                   </td>
                </tr>
            @endif
            <?php /** @var \App\Containers\AppSection\Salesforce\Models\SalesforceExportException $exception */ ?>
            @foreach($exportExceptions as $exception)
                <tr>
                    <td>{{ $exception->getObjectName() }}</td>
                    <td>{{ $exception->salesforceObject->getKey() }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#request_{{ $exception->getHashedKey() }}">
                            Data
                        </button>
                        <div class="modal fade" id="request_{{ $exception->getHashedKey() }}"
                             tabindex="-1"
                             aria-labelledby="request_label_{{ $exception->getHashedKey() }}"
                             aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="request_label_{{ $exception->getHashedKey() }}">
                                            Request Data</h5>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Data</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach  ($exception->request as $key => $data)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ is_array($data) ? var_export($data) : $data }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#response_{{ $exception->getHashedKey() }}">
                            Data
                        </button>
                        <div class="modal fade" id="response_{{ $exception->getHashedKey() }}"
                             tabindex="-1"
                             aria-labelledby="response_label_{{ $exception->getHashedKey() }}"
                             aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="response_label_{{ $exception->getHashedKey() }}">
                                            Response Data</h5>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Data</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach  ($exception->response as $message)
                                                @foreach($message as $key => $data)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ is_array($data) ? var_export($data) : $data }}</td>
                                                    </tr>
                                                    <tr></tr>
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $exception->method }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#export_url_{{ $exception->getHashedKey() }}">
                            URL
                        </button>
                        <div class="modal fade" id="export_url_{{ $exception->getHashedKey() }}"
                             tabindex="-1"
                             aria-labelledby="export_label_url_{{ $exception->getHashedKey() }}"
                             aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="export_label_url_{{ $exception->getHashedKey() }}">
                                            URL</h5>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $exception->url }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#export_trace_{{ $exception->getHashedKey() }}">
                            Trace
                        </button>
                        <div class="modal fade" id="export_trace_{{ $exception->getHashedKey() }}"
                             tabindex="-1"
                             aria-labelledby="export_label_trace_{{ $exception->getHashedKey() }}"
                             aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="export_label_trace_{{ $exception->getHashedKey() }}">
                                            Trace</h5>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach(explode(PHP_EOL, $exception->trace) as $row)
                                                <tr>
                                                    <td><p>{{ $row }}</p></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="action_{{ $exception->getHashedKey() }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="action_{{ $exception->getHashedKey() }}">
                                <li><a class="dropdown-item try-exception" href="javascript:void(0);" data-href="{{ route('web_admin_try_export_exception', ['export_exceptions_id' => $exception->getHashedKey()]) }}">Try</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="try_status"
             tabindex="-1"
             aria-labelledby="try_status_label"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="try_status_label"></h5>
                        <button type="button" class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="try_status_text"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
