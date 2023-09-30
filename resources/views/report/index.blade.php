@extends('layouts.app')

@section('header') <x-header />
@section('body')
    <div class="container">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-end">
                <h1>All Report</h1>
                <a href="{{ route('report.create') }}" class="mb-2">Make New Report</a>
            </div>
            <hr>
            <form>
                <div class="d-flex align-items-center gap-2">
                    <div class="">
                        <div class="dropdown">
                            <button data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-outline-dark"
                                type="button">
                                Status Report :
                            </button>
                            <div class="dropdown-menu p-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                        value="accepted" @checked(in_array('accepted', request('filter.status') ?? [])) id="acceptedSwitch">
                                    <label class="form-check-label" for="acceptedSwitch">Accepted</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                        value="progress" @checked(in_array('progress', request('filter.status') ?? [])) id="progressSwitch">
                                    <label class="form-check-label" for="progressSwitch">Progress</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                        value="revision" @checked(in_array('revision', request('filter.status') ?? [])) id="revisionSwitch">
                                    <label class="form-check-label" for="revisionSwitch">Revision</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <input value="{{ request('search') }}" name="filter[subject]" type="text"
                            placeholder="Search subject" class="form-control" />
                    </div>
                    <div class="">
                        <button class="btn btn-outline-dark">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mb-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Subject</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($reports)
                        @foreach ($reports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2 justify-content-between">
                                        <div>{{$report->user->email}}</div>
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
                </tbody>
            </table>
        </div>
    </div>
@endsection
