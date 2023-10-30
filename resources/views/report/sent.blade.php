@extends('layouts.app')

@section('body')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Report Sent</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{route('report.index')}}">Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Sent
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
            <div>
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
                                        <div class="dropdown">
                                            <button data-bs-toggle="dropdown" aria-expanded="false" class="btn border-0"
                                                type="button">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                {{-- <li><a class="dropdown-item" href="#"></a></li> --}}
                                                @if ($report->status == 'progress')
                                                    <li><a class="dropdown-item" href="#"
                                                            v-on:click="cancelAction('{{ $report->slug }}')">Cancel</a></li>
                                                @else
                                                    <li><a v-on:click="deleteAction('{{ $report->slug }}')"
                                                            class="dropdown-item" href="#">Delete</a></li>
                                                @endif
                                            </ul>
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
    
        <x-modal.confirm-report />
    
    </div>
</div>
<!--end::App Content-->

    <script type="module">
        import {
            createApp
        } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

        const app = createApp({
            data() {
                return {
                    file: {},
                    slug: '',
                    action: '',
                    myModal: {}
                }
            },
            mounted() {
                this.initModal();
            },
            methods: {
                initModal() {
                    this.myModal = {
                        modal: new bootstrap.Modal(document.querySelector('#confirmationAction')),
                        showModal: function() {
                            this.modal.show();
                        },
                        closeModal: function() {
                            this.modal.hide();
                        }
                    }
                },
                confirmAction(obj) {
                    this.file = obj
                    this.myModal.showModal();
                    console.log(obj)
                    fetch(`/report/${this.file.slug}`, {
                            headers: {
                                'content-type': 'application/json',
                                'accept': 'application/json'
                            }
                        })
                        .then(ee => ee.json())
                    //     .then(user => {
                    //         if (user.roles) {
                    //             this.roles = user.roles.map(obj => obj.id);
                    //         }
                    //         delete(user.roles)
                    //         this.user = user;
                    //         this.myModal.showModal();
                    //     })
                },
                cancelAction(slug) {
                    this.action = 'canceled';
                    this.slug = slug;
                    this.myModal.showModal();
                },
                deleteAction(slug) {
                    this.action = 'delete';
                    this.slug = slug;
                    this.myModal.showModal();
                },
            }
        }).mount('#app')
    </script>
@endsection
