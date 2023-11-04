@extends('layouts.app')

@section('scriptsVite')
    @vite('resources/js/bundle/detail.bundle.js')
@endsection

@section('body')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Report</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Report</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detail
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
                <div class="d-flex gap-2">
                    @can('update', $report)
                        <button type="button" v-on:click="cancelAction('{{ $report->slug }}')"
                            class="btn shadow mb-2 btn-danger btn-sm">Cancel Report</button>
                    @endcan
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-end mb-3 gap-2">
                    <div class="flex-fill">
                        <h3>{{ $report->subject }}</h3>

                        <small>
                            @can('validator', $report)
                                <span class="text-muted">From: {{ $report->user->name }}</span>
                            @else
                                <span class="text-muted">To: {{ $report->target->name }}</span>
                            @endcan
                            , Date: {{ $report->created_at }}</small>
                    </div>
                    <div>
                        <span @class([
                            'badge p-2 mb-2',
                            'text-bg-success' => $report->status == 'approved',
                            'text-bg-danger' => in_array($report->status, ['canceled', 'rejected']),
                            'text-bg-warning' => $report->status == 'progress',
                        ])>
                            {{ $report->status }}
                            </small>
                    </div>
                </div>
                <div class="mb-3">
                    @foreach ($report->files->sortByDesc('created_at') as $file)
                        <div class="mb-1">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="mb-2">
                                        <button class="btn text-start fw-800 w-100" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collaps{{ $file->slug }}" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            <strong class="fs-5">
                                                #File {{ $file->created_at }}
                                            </strong>
                                            <span @class([
                                                'badge p-1',
                                                'text-bg-danger' => $file->status == 'rejected',
                                                'text-bg-warning' => $file->status == 'revision',
                                                'text-bg-success' => $file->status == 'accepted',
                                            ])>{{ $file->status }}</span>
                                        </button>
                                    </div>
                                    <div @class(['px-3 collapse', 'show' => $loop->iteration == 1]) id="collaps{{ $file->slug }}">
                                        <div class="mb-2">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('file.show', ['file' => $file->slug]) }}"
                                                    class="btn btn-primary btn-sm">View File</a>
                                                <a href="{{ route('file.download', ['file' => $file->slug]) }}"
                                                    class="btn btn-primary btn-sm">Unduh File</a>

                                                <div class="btn-group ms-auto">
                                                    @can('update', $file)
                                                        {{-- <button type="button"
                                                        v-on:click="confirmAction(
                                                        {slug:'{{ $file->slug }}',status:'accepted'})"
                                                        class="btn shadow btn-success btn-sm">Accept</button> --}}
                                                        <a href="{{ route('file.edit', ['file' => $file->slug]) }}"
                                                            v-on:click="confirmAction(
                                                        {slug:'{{ $file->slug }}',status:'accepted'})"
                                                            class="btn shadow btn-success btn-sm">Accept</a>
                                                        <button type="button"
                                                            v-on:click="confirmAction(
                                                        {slug:'{{ $file->slug }}',status:'revision'})"
                                                            class="btn shadow btn-warning btn-sm">Revision</button>
                                                        <button type="button"
                                                            v-on:click="confirmAction(
                                                        {slug:'{{ $file->slug }}',status:'rejected'})"
                                                            class="btn shadow btn-danger btn-sm">Reject</button>
                                                    @endcan
                                                    @can('update', $report)
                                                        @if ($file->status == 'revision')
                                                            <button type="button"
                                                                v-on:click="uploadFile('{{ $report->slug }}')"
                                                                class="btn shadow btn-warning btn-sm">
                                                                Upload Revision</button>
                                                        @endif
                                                    @endcan
                                                    @can('validator', $report)
                                                        @if ($report->status == 'approved')
                                                            <a href="{{route('file.reset',['file'=>$file->slug])}}" class="btn shadow btn-secondary btn-sm">
                                                                Reset File</a>
                                                            <a href="{{route('file.edit',['file'=>$file->slug])}}"
                                                                class="btn shadow btn-warning btn-sm">
                                                                Edit Accepted File</a>
                                                        @endif
                                                    @endcan
                                                </div>

                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="text-muted">Description:</div>
                                            <p>{{ $file->description }}</p>
                                        </div>
                                        <div class="mb-2">
                                            <div class="text-muted">Comment:</div>
                                            @if ($file->comment)
                                                <p>{{ $file->comment }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-modal.confirm-report />

        </div>
    </div>
    <!--end::App Content-->
@endsection
