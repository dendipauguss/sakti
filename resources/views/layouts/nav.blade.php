<div class="mainnav__categoriy py-3">
    <h6 class="mainnav__caption mt-0 px-3 fw-bold">Menu</h6>
    <ul class="mainnav__menu nav flex-column">

        <!-- Regular menu link -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
                class="nav-link mininav-toggle collapsed {{ request()->is('dashboard*') ? 'active' : '' }}"><i
                    class="psi-home fs-5 me-2"></i>

                <span class="nav-label mininav-content ms-1" style="">Dashboard</span>
            </a>
        </li>
        <!-- END : Regular menu link -->

        <!-- Link with submenu -->
        <li class="nav-item has-sub">

            <a href="#"
                class="mininav-toggle nav-link collapsed {{ request()->is('journal*') || request()->is('equity*') ? 'active' : '' }}"><i
                    class="psi-note fs-5 me-2"></i>
                <span class="nav-label ms-1">Transaction Report</span>
            </a>

            <!-- Dashboard submenu list -->
            <ul class="mininav-content nav collapse" style="">
                <li class="nav-item">
                    <a href="{{ route('journal.index') }}"
                        class="nav-link {{ request()->is('journal*') ? 'active' : '' }}">Journal Report</a>
                </li>
                <li class="nav-item">
                    <a href="./dashboard-2.html" class="nav-link">Equity Report</a>
                </li>
            </ul>
            <!-- END : Dashboard submenu list -->

        </li>
        <!-- END : Link with submenu -->

    </ul>
</div>
