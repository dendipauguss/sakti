<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
        {{-- <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
            <use xlink:href="{{ env('THM_LINK') }}/assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
            <use xlink:href="{{ env('THM_LINK') }}/assets/brand/coreui.svg#signet"></use>
        </svg> --}}
        <div class="text-wrap text-center">
            <h4>SAKTI</h4>
            <small>Sistem Informasi Analisis Kinerja Transaksi PBK</small>
        </div>
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
        onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
</div>
<ul class="sidebar-nav simplebar-scrollable-y" data-coreui="navigation" data-simplebar="init">
    <div class="simplebar-wrapper" style="margin: -8px;">
        <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
        </div>
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content"
                    style="height: 100%; overflow: hidden scroll;">
                    <div class="simplebar-content" style="padding: 8px;">
                        <li class="nav-title">{{ auth()->user()->role }}</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <svg class="nav-icon">
                                    <use
                                        xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-speedometer">
                                    </use>
                                </svg> Dashboard
                            </a>
                        </li>
                        <li class="nav-group">
                            <a class="nav-link nav-group-toggle" href="#">
                                <svg class="nav-icon">
                                    <use
                                        xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-puzzle">
                                    </use>
                                </svg> Journal Report
                            </a>
                            <ul class="nav-group-items compact">
                                <li class="nav-item">
                                    <a class="nav-link text-wrap" href="{{ route('journal.upload') }}">
                                        <span class="nav-icon">
                                            <span class="nav-icon-bullet"></span>
                                        </span>
                                        Upload Journal Report File
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-wrap" href="{{ route('ip-perusahaan.index') }}">
                                        <span class="nav-icon">
                                            <span class="nav-icon-bullet"></span>
                                        </span>
                                        IP Perusahaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('credit-facility.index') }}"><span
                                            class="nav-icon"><span class="nav-icon-bullet"></span></span>
                                        Credit Facility
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('market-execution.index') }}"><span
                                            class="nav-icon"><span class="nav-icon-bullet"></span></span>
                                        Waktu Eksekusi Market
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('wrong-price.index') }}"><span
                                            class="nav-icon"><span class="nav-icon-bullet"></span></span>
                                        Harga Tidak Sesuai
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-group">
                            <a class="nav-link nav-group-toggle" href="#">
                                <svg class="nav-icon">
                                    <use
                                        xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-puzzle">
                                    </use>
                                </svg> Equity Report
                            </a>
                            <ul class="nav-group-items compact">
                                <li class="nav-item">
                                    <a class="nav-link" href="base/accordion.html"><span class="nav-icon"><span
                                                class="nav-icon-bullet"></span></span>
                                        Apa Saja
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('equity.index') }}">
                                <svg class="nav-icon">
                                    <use
                                        xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-speedometer">
                                    </use>
                                </svg> Equity Report
                            </a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        <div class="simplebar-placeholder" style="width: 255px; height: 823px;"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
    </div>
    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
        <div class="simplebar-scrollbar" style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;">
        </div>
    </div>
</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
