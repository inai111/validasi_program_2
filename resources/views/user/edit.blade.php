@extends('layouts.app')

@section('scriptVite')
@endsection

@section('header')
    <x-header />
@endsection

@section('body')
    <div id="app" class="container">
        <div class="mb-3">
            <h1>Profile</h1>
            <small class="text-muted">Change Password</small>
            <hr>
        </div>
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
@endsection
