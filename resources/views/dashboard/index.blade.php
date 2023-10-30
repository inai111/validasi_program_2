@extends('layouts.app')

@section('scriptsVite')
    @vite('resources/js/bundle/dashboard.bundle.js')
@endsection

@section('body')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
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
            <section>
                <div class="m-3">
                    <div class="row">
                        @can('viewAny', auth()->user())
                            <div class="col-lg-auto" style="min-width:200px">
                                <div class="small-box text-bg-primary">
                                    <div class="inner">
                                        <h3>{{ $users->total() }}</h3>
                                        <p>Users</p>
                                    </div>
                                    <a href="#editRoleUserModal"
                                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                        More info <i class="bi bi-link-45deg"></i></a>
                                </div>
                            </div>
                        @endcan

                        @can('viewAnyReport')
                            @can('viewIncomingReport')
                                <div class="col-lg-auto" style="min-width:200px">
                                    <div class="small-box text-bg-warning">
                                        <div class="inner">
                                            <h3>{{ $reportsIncoming->total() }}</h3>
                                            <p>Incoming Report</p>
                                        </div>
                                        <a href="{{ route('report.incoming') }}"
                                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                            More info <i class="bi bi-link-45deg"></i></a>
                                    </div>
                                </div>
                            @endcan
                            <div class="col-lg-auto" style="min-width:200px">
                                <div class="small-box text-bg-primary">
                                    <div class="inner">
                                        <h3>{{ $reports->total() }}</h3>
                                        <p>All Report</p>
                                    </div>
                                    <a href="{{ route('report.index') }}"
                                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                        More info <i class="bi bi-link-45deg"></i></a>
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
    </div>
    <!--end::App Content-->
@endsection
