@extends('layouts.app')

@section('scriptVite')@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('body')
<div class="container">
    <div class="pt-5">
        <div class="border mx-auto w-50 p-5">
            <form method="post">
                @csrf
                <x-inputs.floating type="email" placeholder="Email Address" value="{{old('email','')}}"
                name="email" message="{{$errors->first('email')}}" required />
                <x-inputs.floating value="{{old('name','')}}" type="text" placeholder="Nama" name="name"
                message="{{$errors->first('name')}}" required />
                <x-inputs.floating type="password" placeholder="Password" name="password"
                message="{{$errors->first('password')}}" required />

                <div>
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
                <a href="{{route('login')}}" class="">Sudah punya akun</a>
            </form>
        </div>
    </div>
</div>
@endsection