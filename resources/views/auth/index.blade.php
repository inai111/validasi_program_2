@extends('layouts.app')

@section('scriptVite')@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('body')
<div class="container">
    <div class="pt-5">
        <div class="border mx-auto w-50 p-5">
            <div class="mb-3">
                <h1>Login</h1>
                <hr>
            </div>
            <form method="post">
                @csrf
                <x-inputs.floating type="email" placeholder="Email Address" name="email"
                message="{{$errors->first('email')}}" value="{{old('email')}}" required/>
                <x-inputs.floating type="password" placeholder="Password" name="password"
                message="{{$errors->first('password')}}" required/>

                <div>
                    <button class="btn btn-success" type="submit">Login</button>
                </div>
                <a href="{{route('register')}}" class="">Buat akun baru</a>
            </form>
        </div>
    </div>
</div>
@endsection