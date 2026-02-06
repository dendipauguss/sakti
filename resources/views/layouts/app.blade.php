<!DOCTYPE html>
<html lang="en" data-coreui-theme="light">

    <head>
        <script type="text/javascript" src="https://beacon-v2.helpscout.net/static/js/vendor.0c72b11a.js"></script>
        <script type="text/javascript" src="https://beacon-v2.helpscout.net/static/js/main.6bd68ac0.js"></script>
        <script type="text/javascript" async="" src="https://beacon-v2.helpscout.net"></script>
        <script async="" src="https://scripts.clarity.ms/0.8.49/clarity.js"></script>
        <script async="" src="https://www.clarity.ms/tag/smksdbf05m"></script>
        <script type="text/javascript" async="" src="/ufxf/?id=G-6RN1VRRKRM&amp;cx=c&amp;gtm=4e61k2"></script>
        <script async="" src="/ufxf/"></script>
        <script>
            (function(w, i, g) {
                w[g] = w[g] || [];
                if (typeof w[g].push == 'function') w[g].push(i)
            })
            (window, 'GTM-KX4JH47', 'google_tags_first_party');
        </script>
        <script>
            (function(w, d, s, l) {
                w[l] = w[l] || [];
                (function() {
                    w[l].push(arguments);
                })('set', 'developer_id.dYzg1YT', true);
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s);
                j.async = true;
                j.src = '/ufxf/';
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer');
        </script>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title>{{ env('APP_NAME') }}{{ !empty($title) ? ' | ' . $title : '' }}</title>
        <link rel="apple-touch-icon" sizes="57x57" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180"
            href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"
            href="{{ env('THM_LINK') }}/assets/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32"
            href="{{ env('THM_LINK') }}/assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96"
            href="{{ env('THM_LINK') }}/assets/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16"
            href="{{ env('THM_LINK') }}/assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="{{ env('THM_LINK') }}/assets/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ env('THM_LINK') }}/assets/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <!-- Vendors styles-->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/vendors/simplebar/css/simplebar.css">
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/css/vendors/simplebar.css">
        <!-- Main styles for this application-->
        <link href="{{ env('THM_LINK') }}/css/style.css" rel="stylesheet">
        <!-- We use those styles to show code examples, you should remove them in your application.-->
        <link href="{{ env('THM_LINK') }}/css/examples.css" rel="stylesheet">
        <script src="{{ env('THM_LINK') }}/js/config.js"></script>
        <script src="{{ env('THM_LINK') }}/js/color-modes.js"></script>
        <link href="{{ env('THM_LINK') }}/vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet">
        <style>
            .imageye-selected {
                outline: 2px solid black !important;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) !important;
            }

            /* Pagination container */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                background: transparent;
                color: #aaa !important;
                border: 1px solid #ddd;
                padding: 6px 12px;
                margin: 0 3px;
                border-radius: 6px;
                transition: 0.3s;
            }

            /* Hover */
            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: #00327d !important;
                color: #fff !important;
                border-color: #00327d !important;
            }

            /* Active (Halaman yang sedang dibuka) */
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #00327d !important;
                color: #fff !important;
                border-color: #00327d !important;
            }

            /* Disabled button */
            .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
                background: transparent !important;
                color: #aaa !important;
                border-color: #ddd !important;
            }

            /* Remove default shadows/border */
            .dataTables_wrapper .dataTables_paginate .paginate_button:active {
                box-shadow: none !important;
            }

            /* Memastikan tombol DataTables mengikuti gaya Button Group Bootstrap */
            .dt-buttons.btn-group {
                display: inline-flex;
                vertical-align: middle;
            }

            .dt-buttons .btn {
                margin: 0 !important;
                /* Menghilangkan margin bawaan DataTables */
                border-radius: 0;
            }

            /* Membulatkan ujung tombol pertama dan terakhir */
            .dt-buttons .btn:first-child {
                border-top-left-radius: 4px !important;
                border-bottom-left-radius: 4px !important;
            }

            .dt-buttons .btn:last-child {
                border-top-right-radius: 4px !important;
                border-bottom-right-radius: 4px !important;
            }

            /* Gaya input pencarian agar lebih ramping */
            .dataTables_filter input {
                border-radius: 10px;
                padding: 5px 15px;
                border: 1px solid #ddd;
                margin-left: 5px;
            }

            .dataTables_length {
                width: 40%;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    </head>

    <body>
        <div class="sidebar sidebar-fixed border-end" id="sidebar">
            @include('layouts.nav')
        </div>
        <div class="wrapper d-flex flex-column min-vh-100">
            <header class="header header-sticky p-0 mb-4">
                @include('layouts.head')
            </header>
            <div class="body flex-grow-1">
                @yield('content')
            </div>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <div id="toastSuccess" class="toast border-0">
                        <div class="toast-header bg-success text-white">
                            <strong class="me-auto">Sukses</strong>
                            <button type="button" class="btn-close btn-close-white"
                                data-coreui-dismiss="toast"></button>
                        </div>
                        <div class="toast-body text-dark">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <div id="toastError" class="toast border-0">
                        <div class="toast-header bg-danger text-white">
                            <strong class="me-auto">Peringatan</strong>
                            <button type="button" class="btn-close btn-close-white"
                                data-coreui-dismiss="toast"></button>
                        </div>
                        <div class="toast-body text-dark">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <div id="toastInfo" class="toast border-0">
                        <div class="toast-header bg-info text-white">
                            <strong class="me-auto">Info</strong>
                            <button type="button" class="btn-close btn-close-white"
                                data-coreui-dismiss="toast"></button>
                        </div>
                        <div class="toast-body text-dark">
                            {{ session('info') }}
                        </div>
                    </div>
                </div>
            @endif

            <footer class="footer px-4">
                <div><a href="https://sakti.test/" class="link-info text-decoration-none" target="_blank">Sistem
                        Informasi Analisis
                        Kinerja Transaksi PBK ©
                        2026</a></div>
                <div class="ms-auto"><a href="https://bappebti.go.id/" class="link-info text-decoration-none"
                        target="_blank">Powered by&nbsp;Bappebti</a></div>
            </footer>
        </div>
        <!-- CoreUI and necessary plugins-->
        <script src="{{ env('THM_LINK') }}/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
        <script src="{{ env('THM_LINK') }}/vendors/simplebar/js/simplebar.min.js"></script>
        <script>
            // Theme Toggle Handler
            const htmlElement = document.documentElement;
            const themeButtons = document.querySelectorAll('[data-coreui-theme-value]');
            const themeIcon = document.querySelector('.theme-icon-active');
            const sidebar = document.getElementById('sidebar');

            // Load saved theme preference on page load
            const savedTheme = localStorage.getItem('coreui-theme') || 'dark';
            htmlElement.setAttribute('data-coreui-theme', savedTheme);
            applySidebarTheme(savedTheme);
            updateThemeIcon(savedTheme);

            // Add click handlers to theme buttons
            themeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const selectedTheme = this.getAttribute('data-coreui-theme-value');

                    // Update HTML element theme
                    htmlElement.setAttribute('data-coreui-theme', selectedTheme);

                    // Update sidebar theme
                    applySidebarTheme(selectedTheme);

                    // Save preference to localStorage
                    localStorage.setItem('coreui-theme', selectedTheme);

                    // Update icon and active state
                    updateThemeIcon(selectedTheme);
                    updateActiveButton(selectedTheme);
                });
            });

            // Apply sidebar theme class
            function applySidebarTheme(theme) {
                if (!sidebar) return;

                sidebar.classList.remove('sidebar-light', 'sidebar-dark');

                if (theme === 'light') {
                    sidebar.classList.add('sidebar-light');
                } else {
                    sidebar.classList.add('sidebar-dark');
                }
            }

            // Update theme icon based on selected theme
            function updateThemeIcon(theme) {
                if (!themeIcon) return;
                const svgUse = themeIcon.querySelector('use');
                if (!svgUse) return;

                const iconMap = {
                    'light': '#cil-sun',
                    'dark': '#cil-moon',
                    'auto': '#cil-contrast'
                };

                const href = svgUse.getAttribute('xlink:href');
                const basePath = href.substring(0, href.lastIndexOf('#'));
                svgUse.setAttribute('xlink:href', basePath + (iconMap[theme] || '#cil-moon'));
            }

            // Update active button state
            function updateActiveButton(theme) {
                themeButtons.forEach(button => {
                    if (button.getAttribute('data-coreui-theme-value') === theme) {
                        button.classList.add('active');
                    } else {
                        button.classList.remove('active');
                    }
                });
            }

            const header = document.querySelector('header.header');

            document.addEventListener('scroll', () => {
                if (header) {
                    header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
                }
            });
        </script>
        <!-- Plugins and scripts required by this view-->
        <script src="{{ env('THM_LINK') }}/vendors/chart.js/js/chart.umd.js"></script>
        <script src="{{ env('THM_LINK') }}/vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
        <script src="{{ env('THM_LINK') }}/vendors/@coreui/utils/js/index.js"></script>
        <script src="{{ env('THM_LINK') }}/js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
            $(document).ready(function() {
                var table = $('#dataTables').DataTable({
                    dom: '<"row mb-3 justify-content-between"' +
                        '<"col-md-7 d-flex align-items-center gap-3"lB>' +
                        '<"col-md-3 d-flex justify-content-end"f>' +
                        '>rt' +
                        '<"row mt-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>',
                    buttons: [{
                            extend: 'excelHtml5',
                            className: 'btn btn-sm btn-success',
                            text: '<i class="fas fa-file-excel"></i> Excel'
                        },
                        {
                            extend: 'pdfHtml5',
                            className: 'btn btn-sm btn-danger',
                            text: '<i class="fas fa-file-pdf"></i> PDF'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-sm btn-info',
                            text: '<i class="fas fa-print"></i> Print'
                        }
                    ],
                    lengthMenu: [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    pageLength: 10,
                    ordering: true,
                    searching: true,
                    language: {
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ada data ditemukan",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)",
                        search: "Cari:",
                        paginate: {
                            next: "<svg class='icon icon-lg' width='16' height='16'><use xlink:href='{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-arrow-thick-right'></use></svg>",
                            previous: "<svg class='icon icon-lg' width='16' height='16'><use xlink:href='{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-arrow-thick-left'></use></svg>"
                        }
                    }
                });

                // 🔥 Ubah wrapper dt-buttons jadi btn-group
                table.buttons().container()
                    .addClass('btn-group')
                    .removeClass('dt-buttons');
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                @if (session('info'))
                    const toastEl = document.getElementById('toastInfo');
                    if (toastEl) {
                        const toast = new coreui.Toast(toastEl, {
                            delay: 3000,
                            autohide: true
                        });
                        toast.show();
                    }
                @endif

                @if (session('success'))
                    const toastEl = document.getElementById('toastSuccess');
                    if (toastEl) {
                        const toast = new coreui.Toast(toastEl, {
                            delay: 3000,
                            autohide: true
                        });
                        toast.show();
                    }
                @endif

                @if (session('error'))
                    const toastEl = document.getElementById('toastDanger');
                    if (toastEl) {
                        const toast = new coreui.Toast(toastEl, {
                            delay: 3000,
                            autohide: true
                        });
                        toast.show();
                    }
                @endif

            });
        </script>

        <script defer=""
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon="{&quot;version&quot;:&quot;2024.11.0&quot;,&quot;token&quot;:&quot;496f8c1a159448ef82d6c94971e63824&quot;,&quot;server_timing&quot;:{&quot;name&quot;:{&quot;cfCacheStatus&quot;:true,&quot;cfEdge&quot;:true,&quot;cfExtPri&quot;:true,&quot;cfL4&quot;:true,&quot;cfOrigin&quot;:true,&quot;cfSpeedBrain&quot;:true},&quot;location_startswith&quot;:null}}"
            crossorigin="anonymous"></script>

        <script type="text/javascript" id="" charset="">
            ! function(b, d, f) {
                function e() {
                    var c = d.getElementsByTagName("script")[0],
                        a = d.createElement("script");
                    a.type = "text/javascript";
                    a.async = !0;
                    a.src = "https://beacon-v2.helpscout.net";
                    c.parentNode.insertBefore(a, c)
                }
                if (b.Beacon = f = function(c, a, g) {
                        b.Beacon.readyQueue.push({
                            method: c,
                            options: a,
                            data: g
                        })
                    }, f.readyQueue = [], "complete" === d.readyState) return e();
                b.attachEvent ? b.attachEvent("onload", e) : b.addEventListener("load", e, !1)
            }(window, document, window.Beacon || function() {});
        </script>
        <script type="text/javascript" id="" charset="">
            // window.Beacon("init", "6602a052-8c37-41e0-88af-58bdb45c580e");
        </script>
        <script type="text/javascript" id="" charset="">
            (function(a, e, b, f, g, c, d) {
                a[b] = a[b] || function() {
                    (a[b].q = a[b].q || []).push(arguments)
                };
                c = e.createElement(f);
                c.async = 1;
                c.src = "https://www.clarity.ms/tag/" + g;
                d = e.getElementsByTagName(f)[0];
                d.parentNode.insertBefore(c, d)
            })(window, document, "clarity", "script", "smksdbf05m");
        </script>
        <script type="text/javascript" id="" charset="">
            window._nQc = "89417937";
        </script>
        <script id="" text="" charset="" type="text/javascript" src="https://serve.albacross.com/track.js"></script>
        {{-- <div id="beacon-container">
            <div class="hsds-beacon">
                <div class="Beacon">
                    <div class="BeaconFabButtonFrame"
                        style="border-radius: 60px; height: 60px; position: fixed; transform: scale(1); width: 60px; z-index: 1049; --pulse-background: #527CEB; --pulse-left-offset: 0px; --pulse-top-offset: 0px;">
                        <style>
                            .BeaconFabButtonFrame {
                                border: none;
                                bottom: 40px;
                                box-shadow: 0 4px 7px rgba(0, 0, 0, 0.1);
                                position: fixed;
                                right: 40px;
                                top: auto;
                                transition:
                                    box-shadow 250ms ease,
                                    opacity 0.4s ease,
                                    scale 0.125s ease-in-out,
                                    transform 0.2s ease-in-out;
                            }

                            .BeaconFabButtonFrame:hover {
                                scale: 1.125;
                            }

                            .BeaconFabButtonFrame:active {
                                box-shadow: none;
                            }

                            .BeaconFabButtonFrame iframe {
                                border: none;
                                height: 100%;
                                width: 100%;
                                color-scheme: light !important;
                            }

                            @media (max-height: 740px) {

                                .BeaconFabButtonFrame {
                                    bottom: 10px;
                                    right: 20px;
                                }
                            }

                            @supports (--css: variables) {
                                .BeaconFabButtonPulse svg {
                                    display: none;
                                    position: absolute;
                                    width: 60px;
                                    height: 60px;
                                    top: var(--pulse-top-offset);
                                    left: var(--pulse-left-offset);
                                    fill: var(--pulse-background);
                                    z-index: -1;
                                    pointer-events: none;
                                }

                                .BeaconFabButtonPulse.is-visible svg {
                                    display: block !important;
                                    opacity: 0.2;
                                    animation:
                                        1.03s cubic-bezier(0.28, 0.53, 0.7, 1) pulse-scale 0.13s both,
                                        0.76s cubic-bezier(0.42, 0, 0.58, 1) pulse-fade-out 0.4s both;
                                }

                                @keyframes pulse-scale {
                                    0% {
                                        transform: scale(1);
                                    }

                                    100% {
                                        transform: scale(4);
                                    }
                                }

                                @keyframes pulse-fade-out {
                                    0% {
                                        opacity: 0.2;
                                    }

                                    100% {
                                        opacity: 0;
                                    }
                                }
                            }

                            .BeaconFabButtonFrame--left {
                                left: 40px;
                                right: initial;
                            }

                            @media (max-height: 740px) {

                                .BeaconFabButtonFrame--left {
                                    left: 20px;
                                    right: initial;
                                }
                            }
                        </style>
                        <div class="BeaconFabButtonPulse "><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"
                                preserveAspectRatio="none" aria-hidden="true">
                                <path
                                    d="M60 30C60 51.25 51.25 60 30 60C8.75 60 1.99634e-09 51.25 1.99563e-09 30C1.99492e-09 8.75 8.75 0 30 0C51.25 0 60 8.75 60 30Z">
                                </path>
                            </svg>
                        </div><iframe id="" data-cy="FrameComponent"
                            aria-label="Toggle Customer Support"></iframe>
                    </div>
                </div>
            </div>
        </div> --}}
    </body>

</html>
