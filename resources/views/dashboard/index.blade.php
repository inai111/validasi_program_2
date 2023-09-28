@extends('layouts.app')

@section('scriptVite')

@section('header')
    <x-header />
@endsection

@section('body')
    <div class="container">
        <div class="m-3">
            <section>
                <div class="row">
                    @if (auth()->user()->roles->contains('name_code', '=', 'admin'))
                        <div class="col-sm-2">
                            <div class="card">
                                <div class="card-header">
                                    Users
                                </div>
                                <div class="card-body">
                                    <div class="display-5 text-center">
                                        {{ $countingAllUser }}
                                    </div>
                                    <a href="{{ route('user.index') }}">see users</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!auth()->user()->roles->contains('name_code', '=', 'admin'))

                        @if (auth()->user()->roles->contains('name_code', '=', 'kabag') ||
                                auth()->user()->roles->contains('name_code', '=', 'direct'))
                            <div class="col-lg-2">
                                <div class="card">
                                    <div class="card-header">
                                        Incoming Report
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <span class="display-5">
                                                {{ $countingIncomingReport }}
                                            </span>
                                        </div>
                                        <a href="{{ route('report.incoming') }}">see report</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-2">
                            <div class="card">
                                <div class="card-header">
                                    All Report
                                </div>
                                <div class="card-body">
                                    <div class="display-5 text-center">
                                        {{ $countingAllReport }}
                                    </div>
                                    <a href="{{ route('report.index') }}">see report</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
