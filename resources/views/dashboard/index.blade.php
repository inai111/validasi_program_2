@extends('layouts.app')

@section('scriptsVite')
    @vite('resources/js/bundle/dashboard.bundle.js')
@endsection
@section('header')
    <x-header />
@endsection

@section('body')
    <div class="container">
        <section>
            <div class="m-3">
                <div class="row">
                    @can('viewAny', auth()->user())
                        <div class="col-lg-auto" style="min-width:200px">
                            <div class="card h-100">
                                <div class="card-header">
                                    Users
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="display-5 text-center">
                                        {{ $users->total() }}
                                    </div>
                                    <a href="#editRoleUserModal">see users</a>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('viewAnyReport')
                        @can('viewIncomingReport')
                            <div class="col-lg-auto" style="min-width:200px">
                                <div class="card h-100">
                                    <div class="card-header">
                                        Incoming Report
                                        <span class="badge text-bg-warning">Need Action</span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="text-center">
                                            <span class="display-5">
                                                {{ $reportsIncoming->total()}}
                                            </span>
                                        </div>
                                        <a href="{{ route('report.incoming') }}">see report</a>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <div class="col-lg-auto" style="min-width:200px">
                            <div class="card h-100">
                                <div class="card-header">
                                    All Report
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="display-5 text-center">
                                        {{ $reports->total() }}
                                    </div>
                                    <a class="mt-auto" href="{{ route('report.index') }}">see report</a>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @cannot('noRoles', auth()->user())
                        <div class="text-muted text-center d-flex flex-column" style="height:500px">
                            <h1 class="display-3 my-auto">No Roles</h1>
                        </div>
                    @endcannot()
                </div>
            </div>
        </section>
        <section>
            <div class="mb-3">
                @can('viewAny', auth()->user())
                    <div id="editRoleUserModal">
                        <x-table-user>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->email }}
                                        @if ($user->roles->isEmpty())
                                            <span class="badge text-bg-warning float-end">No Roles</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <button v-on:click="setUser({{ $user->id }})" class="btn" type="button">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <x-slot:pagination>
                                {{ $users->links() }}
                            </x-slot>
                        </x-table-user>

                        <x-modal.edit-user :roles="$roles" />
                    </div>
                @endcan
                @if (!auth()->user()->isAdmin())
                    @can('viewAnyReport')
                        <x-table-report>
                            @if (!$reports->isEmpty())
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-between">
                                                <div>{{ $report->user->email }}</div>
                                                <div class="flex-fill">
                                                    <a href="{{ route('report.show', ['report' => $report->slug]) }}"
                                                        class="d-flex gap-2 nav-link">
                                                        <div @class([
                                                            'badge p-1',
                                                            'text-bg-success' => $report->status == 'approved',
                                                            'text-bg-danger' => in_array($report->status, ['rejected', 'canceled']),
                                                            'text-bg-warning' => in_array($report->status, ['progress', 'revision']),
                                                        ])>{{ $report->status }}</div>
                                                        <div class="flex-fill"
                                                            style="max-height: calc(16px*2*1.4);
                                                    display: -webkit-box;-webkit-box-orient: vertical;
                                                    -webkit-line-clamp:2;overflow:hidden;font-size:16px;
                                                    line-height:1.4;white-space:normal">
                                                            <strong>{{ $report->subject }}</strong>
                                                        </div>
                                                        <small class="ms-auto my-auto">
                                                            {{ $report->created_at }}
                                                        </small>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No Report found</td>
                                </tr>
                            @endif

                            <x-slot:pagination>
                                {{ $reports->links() }}
                            </x-slot>
                        </x-table-report>
                    @endcan
                @endif
            </div>
        </section>
    </div>
@endsection
