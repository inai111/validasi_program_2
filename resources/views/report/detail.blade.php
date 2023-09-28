@extends('layouts.app')

@section('scriptsVite')
    @vite('resources/js/bundle/detail.bundle.js')
@endsection

@section('header')
    <x-header />
@endsection

@section('body')
    <div id="app" class="container">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-end">
                <div>
                <h1>Report Detail</h1>
                </div>
                @can('update',$report)
                <div>
                    <button type="button"
                    v-on:click="cancelAction('{{ $report->slug }}')"
                    class="btn shadow mb-2 btn-danger btn-sm">Cancel Report</button>
                </div>
                @endcan
            </div>
            <hr>
        </div>
        <div class="mb-3">
            <div class="d-flex align-items-end mb-3 gap-2">
                <div class="flex-fill">
                    <h3>{{ $report->subject }}</h3>
                    
                    <small>
                        @can('update',$report)
                        <span class="text-muted">To: {{ $report->target->name }}</span>
                        @else
                        <span class="text-muted">From: {{ $report->user->name }}</span>
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
                                        data-bs-target="#collaps{{$file->slug}}" aria-expanded="false"
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
                                <div @class([
                                    "px-3 collapse",
                                    "show"=>$loop->iteration==1
                                    ]) id="collaps{{$file->slug}}">
                                    <div class="mb-2">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('file.show', ['file' => $file->slug]) }}"
                                                class="btn btn-primary btn-sm">View File</a>
                                            <a href="{{ route('file.download', ['file' => $file->slug]) }}"
                                                class="btn btn-primary btn-sm">Unduh File</a>

                                            <div class="btn-group ms-auto">
                                                @can('update', $file)
                                                    <button type="button"
                                                        v-on:click="confirmAction(
                                                        {slug:'{{ $file->slug }}',status:'accepted'})"
                                                        class="btn shadow btn-success btn-sm">Accept</button>
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
@endsection
