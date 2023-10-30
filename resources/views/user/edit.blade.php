@extends('layouts.app')

@section('scriptVite')
@endsection

@section('header')
    <x-header />
@endsection

@section('body')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Profile</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item active" aria-current="page">
                        Change Password
                    </li>
                </ol>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div id="app" class="container-fluid">
        <div class="mb-3">
            <form method="post">
                @method('PUT')
                @csrf
                <x-inputs.floating placeholder="Current Password" id="password" name="current_password" type="password"
                    message="{{ $errors->first('current_password') }}" />
                <x-inputs.floating placeholder="New Password" id="newPassword" name="password" type="password"
                    message="{{ $errors->first('password') }}" value="{{old('password')}}" />
                <x-inputs.floating placeholder="Confirm Password" id="confirmPassword"
                name="password_confirmation" type="password" />
                <button type="submit" class="btn btn-success">Update</button>
            </form>
    
        </div>
    </div>
</div>
<!--end::App Content-->
@endsection
