@extends('layouts.app')

@section('scriptVite')@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('body')
<div class="container">
    <div class="pt-5">
        <div class="border mx-auto w-50 p-5">
            <form method="post">
                @csrf
                <x-inputs.floating inputType="email" inputPlaceholder="Email Address" value="{{old('email','')}}"
                inputName="email" message="{{$errors->first('email')}}"
                />
                <x-inputs.floating value="{{old('name','')}}" inputType="text" inputPlaceholder="Nama" inputName="name"
                message="{{$errors->first('name')}}" />
                <x-inputs.floating inputType="password" inputPlaceholder="Password" inputName="password"
                message="{{$errors->first('password')}}" />

                <div>
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
                <a href="{{route('login')}}" class="">Sudah punya akun</a>
            </form>
        </div>
    </div>
</div>
@endsection