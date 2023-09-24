@extends('layouts.app')

@section('scriptVite')@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('body')
<div class="container">
    <div class="pt-5">
        <div class="border mx-auto w-50 p-5">
            <form method="post">
                @csrf
                <x-inputs.floating inputType="email" inputPlaceholder="Email Address" inputName="email"
                message="" />
                <x-inputs.floating inputType="password" inputPlaceholder="Password" inputName="password"
                message="" />

                <div>
                    <button class="btn btn-success" type="submit">Login</button>
                </div>
                <a href="{{route('register')}}" class="">Buat akun baru</a>
            </form>
        </div>
    </div>
</div>
@endsection