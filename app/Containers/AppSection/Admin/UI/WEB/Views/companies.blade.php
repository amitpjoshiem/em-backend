@extends('appSection@admin::main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" class="col-10" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><h4>Users</h4></li>
                </ol>
            </nav>
            <div class="col-2">
                <a class="btn btn-outline-success" href="{{ route('web_admin_register_company') }}"><i class="fa fa-plus"></i>&nbsp;Add</a>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Domain</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr data-id="{{ $company->getHashedKey() }}">
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->domain }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actions">
                                    <li><a class="dropdown-item" href="{{ route('web_admin_edit_company', ['id' => $company->getHashedKey()]) }}"><i class="w-10 fa fa-edit"></i> Edit</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
