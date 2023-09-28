@extends('layouts.app')

@section('header') <x-header />
@section('body')
    <div class="container">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-end">
                <h1>Incoming Report</h1>
                {{-- <a href="{{ route('report.create') }}" class="mb-2">Make New Report</a> --}}
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
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                        value="rejected" @checked(in_array('rejected', request('filter.status') ?? [])) id="rejectedSwitch">
                                    <label class="form-check-label" for="rejectedSwitch">Rejected</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                        value="cancelled" @checked(in_array('cancelled', request('filter.status') ?? [])) id="cancelledSwitch">
                                    <label class="form-check-label" for="cancelledSwitch">Cancelled</label>
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
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-fill">
                                            <a href="{{ route('report.show', ['report' => $report->slug]) }}"
                                                class="d-flex gap-2 nav-link">
                                                <div @class([
                                                    'badge p-2',
                                                    'text-bg-success' => $report->status == 'approved',
                                                    'text-bg-danger' =>
                                                    in_array($report->status, ['rejected', 'cancelled']),
                                                    'text-bg-warning' =>
                                                    in_array($report->status, ['progress', 'revision']),
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

                                        @if($report->user_id === auth()->user()->id)
                                        <div class="dropdown">
                                            <button data-bs-toggle="dropdown" aria-expanded="false" class="btn"
                                                type="button">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                {{-- <li><a class="dropdown-item" href="#"></a></li> --}}
                                                @if ($report->status == 'progress')
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateModelConfirmation">Cancel</a></li>
                                                @else
                                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                        @endif
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

    <!-- Modal -->
    <div class="modal fade" id="updateModelConfirmation" tabindex="-1" aria-labelledby="updateModelConfirmationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateModelConfirmationLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    cancel report
                </div>
                <div class="modal-footer">
                    <form>
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="report" value="1">
                        <input type="hidden" name="status" value="approved">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
