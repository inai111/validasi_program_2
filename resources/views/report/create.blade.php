@extends('layouts.app')

@section('header') <x-header />
@section('body')
    <div class="container">
        <div class="border p-4 w-75 mx-auto">
            <form method="post" action="{{route('report.store')}}" enctype="multipart/form-data">
                @csrf
                <x-inputs.floating inputType="text" inputPlaceholder="Subject Report" value="{{ old('subject', '') }}"
                    inputName="subject" message="{{ $errors->first('subject') }}" required />
                <x-inputs.floating-select inputPlaceholder="Send To" inputName="to" message="{{ $errors->first('to') }}"
                    required>
                    <option selected disabled>Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected($user->id == old('to', ''))>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-inputs.floating-select>
                <x-inputs.floating inputType="file" inputPlaceholder="File Report" value="{{ old('file', '') }}"
                    inputName="file" accept="application/pdf" message="{{ $errors->first('file') }}"/>
                <x-inputs.floating-textarea inputPlaceholder="Description" inputName="description"
                style="height:150px;resize:none" message="{{ $errors->first('description') }}">
                    {{ old('description', '') }}
                </x-inputs.floating-textarea>
                <button class="btn btn-primary" type="submit">Send</button>
            </form>
        </div>
    </div>
@endsection
