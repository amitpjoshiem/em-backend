<?php
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;

$advisorName = RolesEnum::ADVISOR;
$assistantName = RolesEnum::ASSISTANT;
?>

@extends('appSection@admin::main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-content-center"><a href="{{ route('web_admin_users') }}"><h4 class="m-0">Users</h4></a></li>
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
            <form class="col-md-8 offset-md-2" method="POST" onsubmit="submitForm()" action="{{ route('web_admin_submit_user_register') }}">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control @if($errors->has('first_name')) border border-danger @endif" id="first_name" name="first_name" value="{{ old('first_name') }}">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control @if($errors->has('last_name')) border border-danger @endif" id="last_name" name="last_name" value="{{ old('last_name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @if($errors->has('email')) border border-danger @endif" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position Title</label>
                    <input type="text" class="form-control @if($errors->has('position')) border border-danger @endif" id="position" name="position" value="{{ old('position') }}">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @if($errors->has('username')) border border-danger @endif" id="username" name="username" value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @if($errors->has('phone')) border border-danger @endif" id="phone" name="phone" value="{{ old('phone') }}">
                </div>
                <div class="mb-3">
                    <label for="npn" class="form-label">NPN</label>
                    <input type="text" class="form-control @if($errors->has('npn')) border border-danger @endif" id="npn" name="npn" value="{{ old('npn') }}">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" onchange="selectRole()">
                        @foreach($roles as $role)
                            <option value="{{ $role['id'] }}"  type="{{ $role['name'] }}"
                                @if (old('role') == $role['id'])
                                    selected
                                @endif
                            >
                                {{ $role['display_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="company_id" class="form-label">Company</label>
                    <select id="company_id" name="company_id" onchange="setUpAdvisors()" class="form-select">
                        @foreach($companies as $company)
                            <option value="{{ $company['id'] }}" @if (old('company_id', 1) == $company['id']) selected @endif>
                                {{ $company['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 d-none" id="advisors_group">
                    <label for="advisors" class="form-label">Advisors</label>
                    <select multiple class="form-control" id="advisors" name="advisors[]"></select>
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
        </div>
    </div>
@stop
@push('custom')
    <script>
        let advisors = @json($advisorsList);
        let assistantName = '{{ $assistantName }}';
        let oldAdvisors = @json(old('advisors', []));
        let roleId = document.getElementById('role').value;
        let roleName = document.querySelector('option[value=\'' + roleId + '\']').getAttribute('type');
        if (roleName === assistantName) {
            document.getElementById('advisors_group').classList.remove('d-none');
        }
        setUpAdvisors();


        function setUpAdvisors() {
            let companyId = document.getElementById('company_id').value;
            window.advisorChoices.clearChoices();
            window.advisorChoices.removeActiveItems();
            let items = [];
            advisors[companyId].forEach(function (advisor) {
                let selected = false;
                if (oldAdvisors.length !== 0 && oldAdvisors.includes(advisor['id'].toString())) {
                    selected = true;
                }
                items.push({
                    value: advisor['id'],
                    label: advisor['username'],
                    selected: selected,
                })
            });
            window.advisorChoices.setChoices(items, 'value', 'label', false);
        }

        function selectRole() {
            let roleId = document.getElementById('role').value;
            let roleName = document.querySelector('option[value=\'' + roleId + '\']').getAttribute('type');
            if (roleName === assistantName) {

                document.getElementById('advisors_group').classList.remove('d-none');
                return;
            }
            document.getElementById('advisors_group').classList.add('d-none');
        }
    </script>
@endpush
