<!DOCTYPE html>
<html lang="en" data-coreui-theme="dark">

    <head>
        <script type="text/javascript" src="https://beacon-v2.helpscout.net/static/js/vendor.0c72b11a.js"></script>
        <script type="text/javascript" src="https://beacon-v2.helpscout.net/static/js/main.6bd68ac0.js"></script>
        <script type="text/javascript" async="" src="https://beacon-v2.helpscout.net"></script>
        <script async="" src="https://scripts.clarity.ms/0.8.49/clarity.js"></script>
        <script async="" src="https://www.clarity.ms/tag/smksdbf05m"></script>
        <script type="text/javascript" async="" src="/ufxf/?id=G-6RN1VRRKRM&amp;cx=c&amp;gtm=4e61g1"></script>
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
        <title>CoreUI Free Bootstrap Admin Template</title>
        <link rel="apple-touch-icon" sizes="57x57" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ env('THM_LINK') }}/assets/favicon/apple-icon-180x180.png">
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
        <style>
            .imageye-selected {
                outline: 2px solid black !important;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) !important;
            }
        </style>
    </head>

    <body>
        <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card-group d-block d-md-flex row">
                            <div class="card col-md-7 p-4 mb-0">
                                <div class="card-body">
                                    <h1>Login</h1>
                                    <p class="text-body-secondary">Sign In to your account</p>
                                    <form action="{{ url('/login') }}" method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-user">
                                                    </use>
                                                </svg>
                                            </span>
                                            <input class="form-control" type="text" placeholder="Username"
                                                name="username_or_email">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-lock-locked">
                                                    </use>
                                                </svg>
                                            </span>
                                            <input class="form-control" type="password" placeholder="Password"
                                                name="password">
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-info px-4" type="submit">Login</button>
                                            </div>
                                            <div class="col-6 text-end">
                                                <button class="btn btn-link text-decoration-none px-0"
                                                    type="button">Forgot password?</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card col-md-5 text-white bg-info py-5">
                                <div class="card-body text-center">
                                    <div>
                                        {{-- <h2>Sign up</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <button class="btn btn-lg btn-outline-light mt-3" type="button">Register
                                            Now!</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CoreUI and necessary plugins-->
        <script src="{{ env('THM_LINK') }}/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
        <script src="{{ env('THM_LINK') }}/vendors/simplebar/js/simplebar.min.js"></script>
        <script>
            const header = document.querySelector('header.header');

            document.addEventListener('scroll', () => {
                if (header) {
                    header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
                }
            });
        </script>
        <script></script>

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
            window.Beacon("init", "6602a052-8c37-41e0-88af-58bdb45c580e");
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
        <div id="beacon-container">
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
                        <div class="BeaconFabButtonPulse "><svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 60 60" preserveAspectRatio="none" aria-hidden="true">
                                <path
                                    d="M60 30C60 51.25 51.25 60 30 60C8.75 60 1.99634e-09 51.25 1.99563e-09 30C1.99492e-09 8.75 8.75 0 30 0C51.25 0 60 8.75 60 30Z">
                                </path>
                            </svg>
                        </div><iframe id="" data-cy="FrameComponent"
                            aria-label="Toggle Customer Support"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
