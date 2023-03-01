@extends('appSection@admin::main')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" class="col-10" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><h4>Videos</h4></li>
                </ol>
            </nav>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>Type</td>
                    <td>Text</td>
                    <td>Video</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($help as $type => $data)
                    <tr>
                        <td>{{ \Illuminate\Support\Str::of($type)->snake()->replace('_', ' ')->title() }}</td>
                        <td>{{ $data['text'] }}</td>
                        <td>
                            @if($data['media'] !== null)
                                <button type="button" class="btn btn-info"><i class="fa-solid fa-download"></i></button>
                            @endif
                        </td>
                        <td><a class="btn btn-success" href="{{ route('web_admin_edit_client_videos', ['type' => $type]) }}"><i class="fa-solid fa-pen-to-square"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
