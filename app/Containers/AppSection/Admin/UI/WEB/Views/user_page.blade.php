@extends('appSection@admin::main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item d-flex align-content-center"><a href="{{ route('web_admin_users') }}"><h4 class="m-0">Users</h4></a></li>
                        <li class="breadcrumb-item active d-flex align-content-center" aria-current="page"><h4 class="m-0">{{ $user->username }}</h4></li>
                    </ol>
                </nav>
            </div>
            <div class="col-4 row d-flex flex-row-reverse">
                <div class="col-4">
                    <a type="button" class="btn btn-labeled btn-danger confirm w-100" href="{{ route('web_admin_delete_user', ['id' => $user->getHashedKey()]) }}">
                        <span class="btn-label"><i class="fa fa-trash"></i></span> Delete
                    </a>
                </div>
                <div class="col-4">
                    <a type="button" class="btn btn-labeled btn-success w-100" href="{{ route('web_admin_edit_user', ['id' => $user->getHashedKey()]) }}">
                        <span class="btn-label"><i class="fa fa-edit"></i></span> Edit
                    </a>
                </div>
                @if($user->email_verified_at === null)
                    <div class="col-4">
                        <a title="Send Create Password" type="button" class="btn btn-labeled btn-primary w-100" href="{{ route('web_admin_send_create_password', ['id' => $user->getHashedKey()]) }}">
                            <span class="btn-label"><i class="fa fa-envelope"></i></span> Send
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <table>
                <tr>
                    <td><p class="fs-3">First Name:</p></td>
                    <td><p class="fs-3">{{ $user->first_name }}</p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Last Name:</p></td>
                    <td><p class="fs-3">{{ $user->last_name }}</p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Email:</p></td>
                    <td><p class="fs-3"><a class="text-dark text-decoration-none" href="mailto:{{ $user->email }}">{{ $user->email }}</a></p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Username:</p></td>
                    <td><p class="fs-3">{{ $user->username }}</p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Position:</p></td>
                    <td><p class="fs-3">{{ $user->position }}</p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Phone:</p></td>
                    <td><p class="fs-3"><a class="text-dark text-decoration-none font-italic" href="tel:{{ $user->phone }}">{{ $user->phone }}</a></p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">NPN:</p></td>
                    <td><p class="fs-3">{{ $user->npn }}</p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Roles:</p></td>
                    <td><p class="fs-3">{{ $user->roles->implode('display_name', ' ,') }}</p></td>
                </tr>
                <tr>
                    <td><p class="fs-3">Company:</p></td>
                    <td><p class="fs-3">{{ $user->company->name }}</p></td>
                </tr>
                @if(!$user->assistants->isEmpty())
                    <tr>
                        <td><p class="fs-3">Assistants:</p></td>
                        <td>
                            @foreach($user->assistants as $assistant)
                                <p class="fs-3"><a class="text-dark text-decoration-none font-italic" href="{{ route('web_admin_user_page', ['id' => $assistant->getHashedKey()]) }}">{{ $assistant->username }}</a></p><br>
                            @endforeach
                        </td>
                    </tr>
                @endif
                @if(!$user->advisors->isEmpty())
                    <tr>
                        <td><p class="fs-3">Advisors:</p></td>
                        <td>
                            @foreach($user->advisors as $advisor)
                                <p class="fs-3"><a class="text-dark text-decoration-none font-italic" href="{{ route('web_admin_user_page', ['id' => $advisor->getHashedKey()]) }}">{{ $advisor->username }}</a></p>
                            @endforeach
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@stop
