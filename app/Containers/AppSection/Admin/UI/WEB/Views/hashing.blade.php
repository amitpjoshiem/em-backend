@extends('appSection@admin::main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-content-center"><a href="{{ route('web_admin_tools') }}"><h4 class="m-0">Tools</h4></a></li>
                    <li class="breadcrumb-item active d-flex align-content-center" aria-current="page"><h4 class="m-0">Hashing</h4></li>
                </ol>
            </nav>
        </div>
        <div class="row">
                <div class="mb-3 row">
                    <div class="col-5">
                        <label for="encode_input" class="form-label">Encode</label>
                        <input type="text" class="form-control" id="encode_input" aria-describedby="encodeHelp">
                    </div>
                    <div class="col-2 d-flex d-flex align-items-center justify-content-center">
                        <a class="btn btn-secondary h-50 d-flex align-items-center justify-content-center" data-url="{{ route('web_admin_hashing_encode') }}" id="encode"><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="col-5">
                        <label for="encode_result" class="form-label">Result</label>
                        <input type="text" class="form-control" id="encode_result" aria-describedby="encodeHelp">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-5">
                        <label for="decode_input" class="form-label">Decode</label>
                        <input type="text" class="form-control" id="decode_input" aria-describedby="decodeHelp">
                    </div>
                    <div class="col-2 d-flex d-flex align-items-center justify-content-center">
                        <a class="btn btn-secondary h-50 d-flex align-items-center justify-content-center" data-url="{{ route('web_admin_hashing_decode') }}" id="decode"><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="col-5">
                        <label for="decode_result" class="form-label">Result</label>
                        <input type="text" class="form-control" id="decode_result" aria-describedby="encodeHelp">
                    </div>
                </div>
        </div>
    </div>
@stop
