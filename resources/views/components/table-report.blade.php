<div class="mb-3">
    <div class="d-flex justify-content-between align-items-end">
        <h1>{{ $title ?? 'All Reports' }}</h1>
        <a href="{{ route('report.create') }}" class="mb-2">Make New Report</a>
    </div>
    <hr>
    <form>
        <div class="d-flex align-items-center gap-2">
            <div class="">
                <div class="dropdown">
                    <button data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-outline-dark" type="button">
                        Status Report :
                    </button>
                    <div class="dropdown-menu p-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                value="accepted" id="acceptedSwitch">
                                @checked(in_array('accepted', request('filter.status') ?? []))
                            <label class="form-check-label" for="acceptedSwitch">Accepted</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                value="progress" id="progressSwitch">
                                @checked(in_array('progress', request('filter.status') ?? []))
                            <label class="form-check-label" for="progressSwitch">Progress</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="filter[status][]"
                                value="revision" id="revisionSwitch">
                                @checked(in_array('revision', request('filter.status') ?? []))
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
    <div class="mb-3"></div>
    <table class="table table-striped">
        <thead class="table-primary">
            <tr>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
    {{ $pagination }}
</div>
