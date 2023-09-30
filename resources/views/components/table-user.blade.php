<div class="mb-3">
    <h1>All Users</h1>
    <hr>
    <div class="mb-3">
        <form>
            <div class="d-flex align-items-center gap-2">
                <div class="flex-fill">
                    <input value="{{ request('filter.email') }}" name="filter[email]" type="text"
                        placeholder="Search Email" class="form-control"/>
                </div>
                <div class="">
                    <button class="btn btn-outline-dark">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="mb-3">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Email</th>
                <th colspan="2">Name</th>
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
    {{ $pagination }}
</div>