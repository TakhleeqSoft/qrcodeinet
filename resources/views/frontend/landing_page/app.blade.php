<!DOCTYPE html>
@php($dir = Cookie::get('front_dir', $language->direction ?? 'rtl'))
<html lang="en" dir="{{$dir}}">
@php($metaDatas = getSiteSetting())
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title', 'Home') | {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <meta name="keywords" content="{{ $metaDatas['seo_keyword']??"" }}">
    <meta name="description" content="{{ $metaDatas['seo_description']??"" }}">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" />
    @if(isset($metaDatas['analytics_code']) && $metaDatas['analytics_code']!=null && $metaDatas['analytics_code']!="")
        {!! $metaDatas['analytics_code'] !!}
    @endif
</head>

<body class="animation">
    <header class="header">
        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container position-relative">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset(config('app.ligth_sm_logo')) }}" alt="{{ config('app.name') }}" width="150">
                </a>
                <div class="offcanvas-collapse1 ml-auto">
                    <ul class="navbar-nav flex-row">
                        @if (auth()->check())
                            <li class="nav-item nav-item--btn">
                                <a id="buyBtn" href="{{ url('/register') }}" class="btn btn-primary btn-sm btn--has-shadow btn-default">
                                    <span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M4 4V6H20V4M4 7L3 12V14H4V20H13C12.95 19.66 12.92 19.31 12.92 18.95C12.92 17.73 13.3 16.53 14 15.53V14H15.54C16.54 13.33 17.71 12.96 18.91 12.96C19.62 12.96 20.33 13.09 21 13.34V12L20 7M6 14H12V18H6M18 15V18H15V20H18V23H20V20H23V18H20V15">
                                            </path>
                                        </svg>
                                        <font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">{{ __('system.dashboard.title') }}
                                            </font>
                                        </font>
                                    </span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item nav-item--btn me-2">
                                <a class="btn btn-secondary btn-sm btn--has-shadow btn-default" href="{{ url('/login') }}">
                                    <span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                            </path>
                                        </svg>
                                        <font style="vertical-align: inherit;" class="d-none d-lg-inline">
                                            {{ __('auth.sign_in') }}</font>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item nav-item--btn">
                                <a id="buyBtn" href="{{ url('/register') }}" class="btn btn-primary btn-sm btn--has-shadow btn-default">
                                    <span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M4 4V6H20V4M4 7L3 12V14H4V20H13C12.95 19.66 12.92 19.31 12.92 18.95C12.92 17.73 13.3 16.53 14 15.53V14H15.54C16.54 13.33 17.71 12.96 18.91 12.96C19.62 12.96 20.33 13.09 21 13.34V12L20 7M6 14H12V18H6M18 15V18H15V20H18V23H20V20H23V18H20V15">
                                            </path>
                                        </svg>
                                        <font style="vertical-align: inherit;" class="d-none d-lg-inline">
                                            {{ __('auth.register_your_business') }}
                                        </font>
                                    </span>
                                </a>
                            </li>
                        @endif


                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="main">
        <section class="contact-section">
            <div class="container">
                @yield('content')
            </div>
        </section>
    </main>
    @include('frontend.landing_page.footer')

    <script src="{{ asset('assets/js/font-awesome.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/notification.init.js') }}"></script>
    @yield('custom-js')
    <script>
        @if (session()->has('Success'))
            alertify.success('{{ session('Success') }}');
        @endif

        @if (session()->has('Error'))
            alertify.error('{{ session('Error') }}');
        @endif
        $(window).on('scroll', function() {
            if ($(".btn").is(':visible')) {
                $(".btn").addClass("btn-default");
            }
        });
    </script>
</body>

</html>
