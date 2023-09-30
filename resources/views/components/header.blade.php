<nav class="navbar bg-body-tertiary" aria-label="">
    <div class="container-fluid pt-1">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
            aria-controls="offcanvasScrolling"><span class="navbar-toggler-icon"></span></button>
    </div>
</nav>
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
    id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex flex-column h-100">
            <div class="nav flex-column">
                <div><strong>Core</strong></div>
                <a @class(['nav-link', 'active' => request()->routeIs('dashboard')]) href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <div><strong>Interface</strong></div>
                @if (auth()->user()->roles->contains('name_code', 'admin'))
                    <a @class(['nav-link', 'active' => request()->routeIs('user.*')]) href="{{ route('user.index') }}">
                        Users
                    </a>
                @endif
                @can('viewAnyReport')
                    <a @class([
                        'nav-link collapsed d-flex justify-content-between',
                        'active' => request()->routeIs('report.*'),
                    ]) href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseReports" aria-expanded="false" aria-controls="collapseReports">
                        Reports
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div @class(['collapse', 'show' => request()->routeIs('report.*')])
                        id="collapseReports" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="nav ms-2 flex-column" aria-label="">
                            <a @class(['nav-link', 
                            'active' => request()->routeIs('report.create')])
                            href="{{ route('report.create') }}">Make New Report</a>
                            <a @class(['nav-link', 
                            'active' => request()->routeIs('report.index')])
                            href="{{ route('report.index') }}">All Reports</a>
                            <a @class(['nav-link', 
                            'active' => request()->routeIs('report.sent')])
                            href="{{ route('report.sent') }}">Sent Reports</a>
                            @can('viewIncomingReport')
                                <a @class([
                                    'nav-link',
                                    'active' => request()->routeIs('report.incoming'),
                                ]) href="{{ route('report.incoming') }}">Incoming Reports</a>
                            @endcan

                        </nav>
                    </div>
                @endcan
            </div>
            <div class="mt-auto">
                <div class="d-flex justify-content-between">
                    <div>
                        <div>
                            <small>Logged in as:</small>
                        </div>
                        {{ auth()->user()->email }}
                    </div>
                    <div class="dropup">
                        <button type="button" class="btn border-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-gear fs-4 text-muted"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
