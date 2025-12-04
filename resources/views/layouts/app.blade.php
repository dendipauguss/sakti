<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="generator" content="Hugo 0.87.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <meta name="description"
            content="General form-control live preview. You can copy our examples and paste them into your project!">
        <title>General | Nifty - Admin Template</title>

        <!-- STYLESHEETS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->

        <!-- Fonts [ OPTIONAL ] -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;family=Ubuntu:wght@400;500;700&amp;display=swap"
            rel="stylesheet">

        <!-- Bootstrap CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/brand/ocean/bootstrap.min.css">

        <!-- Nifty CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/nifty.min.css">

        <!-- Nifty Line Icons -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/premium/icon-sets/icons/line-icons/premium-line-icons.min.css">

        <!-- Nifty Solid Icons -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css">

        <!-- Demo purpose CSS [ DEMO ] -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/brand/ocean/nifty.min.css">

        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~---

        [ REQUIRED ]
        You must include this category in your project.


        [ OPTIONAL ]
        This is an optional plugin. You may choose to include it in your project.


        [ DEMO ]
        Used for demonstration purposes only. This category should NOT be included in your project.


        [ SAMPLE ]
        Here's a sample script that explains how to initialize plugins and/or components: This category should NOT be included in your project.


        Detailed information and more samples can be found in the documentation.

        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->
        <style>
            .imageye-selected {
                outline: 2px solid black !important;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) !important;
            }
        </style>
        <style id="_dm-customLoadScreen">
            ._dm-load-scheme-css>._dm-loading-screen {
                align-items: center;
                background-color: #fff;
                color: #2b2c2d;
                display: flex;
                flex-direction: column;
                inset: 0;
                justify-content: center;
                position: fixed
            }

            ._dm-load-scheme-css>._dm-loading-screen:before {
                animation-duration: 1s;
                animation-iteration-count: infinite;
                animation-name: _dm-spin;
                animation-timing-function: linear;
                color: #28292b;
                content: "⚆";
                display: block;
                font-family: Arial;
                font-size: 5rem;
                height: 2ex;
                line-height: 1;
                opacity: .1;
                width: 2ex;
                transform-origin: center center
            }

            ._dm-load-scheme-css>._dm-loading-screen:after {
                content: "Please wait while loading . . .";
                font-family: Poppins, "Open Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-size: 1rem;
                font-weight: 700;
                line-height: 1.5;
                margin-top: 2rem
            }

            ._dm-load-scheme-css>:not(._dm-loading-screen) {
                opacity: 0;
                pointer-events: none;
                visibility: none
            }

            @keyframes _dm-spin {
                from {
                    transform: rotate(0)
                }

                to {
                    transform: rotate(360deg)
                }
            }
        </style>
    </head>

    <body class="jumping" style="">

        <!-- PAGE CONTAINER -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div id="root" class="root mn--max">

            <!-- CONTENTS -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <section id="content" class="content">
                <div class="content__header content__boxed rounded-0">
                    <div class="content__wrap">

                        <!-- Breadcrumb -->
                        {{-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="./index.html">Home</a></li>
                                <li class="breadcrumb-item"><a href="./forms.html">Forms</a></li>
                                <li class="breadcrumb-item active" aria-current="page">General</li>
                            </ol>
                        </nav> --}}
                        <!-- END : Breadcrumb -->

                        <h1 class="page-title mb-0 mt-2">{{ $title }}</h1>

                        <p class="lead">

                        </p>

                    </div>

                </div>

                <div class="content__boxed">
                    <div class="content__wrap">
                        @yield('content')
                    </div>
                </div>
                <!-- FOOTER -->
                <footer class="mt-auto">
                    <div class="content__boxed">
                        <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
                            <div class="text-nowrap mb-4 mb-md-0">Copyright © 2022 <a href="#"
                                    class="ms-1 btn-link fw-bold">My Company</a></div>
                            <nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto"
                                style="row-gap: 0 !important;">
                                <a class="nav-link px-0" href="#">Policy Privacy</a>
                                <a class="nav-link px-0" href="#">Terms and conditions</a>
                                <a class="nav-link px-0" href="#">Contact Us</a>
                            </nav>
                        </div>
                    </div>
                </footer>
                <!-- END - FOOTER -->

            </section>

            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - CONTENTS -->

            <!-- HEADER -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <header class="header">
                <div class="header__inner">

                    <!-- Brand -->
                    <div class="header__brand">
                        <div class="brand-wrap">

                            <!-- Brand logo -->
                            <a href="./index.html" class="brand-img stretched-link">
                                <img src="{{ env('THM_LINK') }}/assets/img/logo.svg" alt="Nifty Logo" class="Nifty logo"
                                    width="40" height="40">
                            </a>

                            <!-- Brand title -->
                            <div class="brand-title">SAKTI</div>

                            <!-- You can also use IMG or SVG instead of a text element. -->

                        </div>
                    </div>
                    <!-- End - Brand -->

                    <div class="header__content">

                        <!-- Content Header - Left Side: -->
                        <div class="header__content-start">

                            <!-- Navigation Toggler -->
                            <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm"
                                aria-label="Nav Toggler">
                                <i class="psi-list-view"></i>
                            </button>

                            <!-- Searchbox -->
                            {{-- <div class="header-searchbox">

                                <!-- Searchbox toggler for small devices -->
                                <label for="header-search-input"
                                    class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm"
                                    type="button">
                                    <i class="psi-magnifi-glass"></i>
                                </label>

                                <!-- Searchbox input -->
                                <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                                    <input id="header-search-input"
                                        class="searchbox__input form-control bg-transparent" type="search"
                                        placeholder="Type for search . . ." aria-label="Search">
                                    <div class="searchbox__backdrop">
                                        <button
                                            class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm"
                                            type="button" id="button-addon2">
                                            <i class="pli-magnifi-glass"></i>
                                        </button>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                        <!-- End - Content Header - Left Side -->

                    </div>
                </div>
            </header>
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - HEADER -->

            <!-- MAIN NAVIGATION -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <nav id="mainnav-container" class="mainnav">
                <div class="mainnav__inner">

                    <!-- Navigation menu -->
                    <div class="mainnav__top-content scrollable-content pb-5">

                        <!-- Profile Widget -->
                        <div class="mainnav__profile mt-3 d-flex3">

                            <div class="mt-2 d-mn-max"></div>

                            <!-- Profile picture  -->
                            <div class="mininav-toggle text-center py-2 collapsed">
                                <img class="mainnav__avatar img-md rounded-circle border"
                                    src="{{ env('THM_LINK') }}/assets/img/profile-photos/1.png" alt="Profile Picture">
                            </div>

                            <div class="mininav-content d-mn-max collapse" style="">
                                <div class="d-grid">

                                    <!-- User name and position -->
                                    <div class="d-block btn shadow-none p-2">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <h6 class="mb-0">Coy</h6>
                                        </span>
                                        <small class="text-muted">Admin</small>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- End - Profile widget -->

                        <!-- Navigation -->
                        @include('layouts.nav')
                        <!-- END : Navigation -->

                    </div>
                    <!-- End - Navigation menu -->

                    <!-- Bottom navigation menu -->
                    <div class="mainnav__bottom-content border-top pb-2">
                        <ul id="mainnav" class="mainnav__menu nav flex-column">
                            <li class="nav-item has-sub">
                                <a href="#" class="nav-link mininav-toggle collapsed" aria-expanded="false">
                                    <i class="pli-unlock fs-5 me-2"></i>
                                    <span class="nav-label ms-1">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End - Bottom navigation menu -->

                </div>
            </nav>
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - MAIN NAVIGATION -->

        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - PAGE CONTAINER -->

        <!-- SCROLL TO TOP BUTTON -->
        <div class="scroll-container">
            <a href="#root" class="scroll-page rounded-circle ratio ratio-1x1" aria-label="Scroll button"></a>
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - SCROLL TO TOP BUTTON -->

        <!-- JAVASCRIPTS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

        <!-- Popper JS [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/vendors/popperjs/popper.min.js" defer=""></script>

        <!-- Bootstrap JS [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/vendors/bootstrap/bootstrap.min.js" defer=""></script>

        <!-- Nifty JS [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/js/nifty.js" defer=""></script>

        <!-- Nifty Settings [ DEMO ] -->
        <script src="{{ env('THM_LINK') }}/assets/js/demo-purpose-only.js" defer=""></script>

        <script defer=""
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon="{&quot;version&quot;:&quot;2024.11.0&quot;,&quot;token&quot;:&quot;281c8ce144eb4533a36e841b30b677c5&quot;,&quot;r&quot;:1,&quot;server_timing&quot;:{&quot;name&quot;:{&quot;cfCacheStatus&quot;:true,&quot;cfEdge&quot;:true,&quot;cfExtPri&quot;:true,&quot;cfL4&quot;:true,&quot;cfOrigin&quot;:true,&quot;cfSpeedBrain&quot;:true},&quot;location_startswith&quot;:null}}"
            crossorigin="anonymous"></script>
    </body>

</html>
