@extends('layouts.app')

@section('body')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Create Report</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{route('report.index')}}">Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Create
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
    <div class="container-fluid">
        <div class="border p-4 w-75 mx-auto">
            <form method="post" action="{{route('report.store')}}" enctype="multipart/form-data">
                @csrf
                <x-inputs.floating class="rounder-pill" type="text" placeholder="Subject Report" value="{{ old('subject', '') }}"
                    name="subject" message="{{ $errors->first('subject') }}" required />
                <x-inputs.floating-select placeholder="Send To" name="to" message="{{ $errors->first('to') }}"
                    required>
                    <option selected disabled>Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected($user->id == old('to', ''))>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </x-inputs.floating-select>
                <x-inputs.floating type="file" placeholder="File Report" value="{{ old('file', '') }}"
                    name="file" accept="application/pdf" message="{{ $errors->first('file') }}"/>
                <x-inputs.floating-textarea placeholder="Description" name="description"
                style="height:150px;resize:none" message="{{ $errors->first('description') }}">
                    {{ old('description', '') }}
                </x-inputs.floating-textarea>
                <button class="btn btn-primary" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
<!--end::App Content-->
@endsection
