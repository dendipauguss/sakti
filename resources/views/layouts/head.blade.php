<div class="container-fluid border-bottom px-4">
    <button class="header-toggler" type="button"
        onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
        style="margin-inline-start: -14px;">
        <svg class="icon icon-lg">
            <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
        </svg>
    </button>


    <ul class="header-nav">
        <li class="nav-item dropdown">
            <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                aria-expanded="false" data-coreui-toggle="dropdown">
                <svg class="icon icon-lg theme-icon-active">
                    <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-moon">
                    </use>
                </svg>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                <li>
                    <button class="dropdown-item d-flex align-items-center" type="button"
                        data-coreui-theme-value="light">
                        <svg class="icon icon-lg me-3">
                            <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-sun">
                            </use>
                        </svg>Light
                    </button>
                </li>
                <li>
                    <button class="dropdown-item d-flex align-items-center active" type="button"
                        data-coreui-theme-value="dark">
                        <svg class="icon icon-lg me-3">
                            <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-moon">
                            </use>
                        </svg>Dark
                    </button>
                </li>
                <li>
                    <button class="dropdown-item d-flex align-items-center" type="button"
                        data-coreui-theme-value="auto">
                        <svg class="icon icon-lg me-3">
                            <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-contrast">
                            </use>
                        </svg>Auto
                    </button>
                </li>
            </ul>
        </li>
        <li class="nav-item py-1">
            <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
        </li>
        <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#"
                role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img"
                        src="{{ env('THM_LINK') }}/assets/img/avatars/8.jpg" alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                    Account
                </div>
                <a class="dropdown-item" href="#">
                    <svg class="icon me-2">
                        <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-user">
                        </use>
                    </svg> Profile
                </a>
                {{-- <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                    <div class="fw-semibold">Settings</div>
                </div> --}}
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <svg class="icon me-2">
                        <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-account-logout">
                        </use>
                    </svg> Logout
                </a>
            </div>
        </li>
    </ul>
</div>
<div class="container-fluid px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0">
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!empty($breadcrumb['url']))
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none link-info">
                            {{ $breadcrumb['label'] }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>{{ $breadcrumb['label'] }}</span>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
