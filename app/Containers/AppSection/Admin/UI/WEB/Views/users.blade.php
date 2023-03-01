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
                <a class="btn btn-success" href="{{ route('web_admin_register_user') }}"><i class="fa fa-plus"></i>&nbsp;Add</a>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Position</td>
                    <td>Phone</td>
                    <td>NPN</td>
                    <td>Role</td>
                    <td>Company</td>
                    <td class="text-center">Verified</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr data-id="{{ $user->getHashedKey() }}">
                        <td>{{ $user->first_name.' '.$user->last_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->position }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->npn }}</td>
                        <td>{{ $user->roles->implode('display_name') }}</td>
                        <td>{{ $user->company?->name }}</td>
                        <td class="text-center"><i class="fa fa-circle @if($user->email_verified_at === null) text-danger @else text-success @endif"></i></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="actions" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actions">
                                    <li><a class="dropdown-item text-dark" href="{{ route('web_admin_user_page', ['id' => $user->getHashedKey()]) }}"><i class="w-10 fa fa-info"></i> Page</a></li>
                                    <li><a class="dropdown-item text-dark" href="{{ route('web_admin_edit_user', ['id' => $user->getHashedKey()]) }}"><i class="w-10 fa fa-edit"></i> Edit</a></li>
                                    <li><a class="dropdown-item text-danger confirm" href="{{ route('web_admin_delete_user', ['id' => $user->getHashedKey()]) }}"><i class="w-10 fa fa-trash"></i> Delete</a></li>
                                    @if($user->email_verified_at === null)
                                        <li><a class="dropdown-item text-dark" href="{{ route('web_admin_send_create_password', ['id' => $user->getHashedKey()]) }}"><i class="w-10 fa fa-envelope"></i> Send Create Password</a></li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links("pagination::bootstrap-4") }}
    </div>
@stop
