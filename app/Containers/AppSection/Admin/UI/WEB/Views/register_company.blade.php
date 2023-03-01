@extends('appSection@admin::main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-content-center"><a href="{{ route('web_admin_companies') }}"><h4 class="m-0">Companies</h4></a></li>
                    <li class="breadcrumb-item active d-flex align-content-center" aria-current="page"><h4 class="m-0">Register</h4></li>
                </ol>
            </nav>
        </div>
        @foreach($errors->all() as $key => $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
        <div class="row">
            <form class="col-md-8 offset-md-2" method="POST" action="{{ route('web_admin_submit_company_register') }}">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @if($errors->has('name')) border border-danger @endif" id="name" name="name" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="domain" class="form-label">Domain</label>
                    <input type="text" class="form-control @if($errors->has('domain')) border border-danger @endif" id="domain" name="domain" value="{{ old('domain') }}">
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
        </div>
    </div>
@stop
