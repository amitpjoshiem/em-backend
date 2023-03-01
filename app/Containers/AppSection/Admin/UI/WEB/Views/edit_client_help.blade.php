@extends('appSection@admin::main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-content-center"><a href="{{ route('web_admin_client_videos') }}"><h4 class="m-0">Videos</h4></a></li>
                    <li class="breadcrumb-item active d-flex align-content-center" aria-current="page"><h4 class="m-0">Edit</h4></li>
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
            <form class="col-md-8 offset-md-2" method="POST" action="{{ route('web_admin_submit_client_videos', ['type' => $help['type']]) }}">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="text" class="form-label">Text</label>
                    <textarea rows="3" class="form-control @if($errors->has('text')) border border-danger @endif" id="text" name="text">{{ old('text', $help['text']) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="media" class="form-label">Media</label>
                    <?php
                        /** @var \App\Containers\AppSection\Media\Models\Media | null $media */
                        $media = $help['media']
                    ?>
                    <input type="file" class="form-control @if($errors->has('text')) border border-danger @endif" id="media" name="media">{{ old('media', $media?->getTemporaryUrl(now()->addMinutes(5))) }}</input>
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
        </div>
    </div>
@stop
