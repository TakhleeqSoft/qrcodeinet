<!doctype html>
@php($dir = Cookie::get('front_dir', $language->direction ?? 'rtl'))
<html lang="en" dir="{{$dir}}">
<head
    <meta charset="utf-8" />
    <title> @yield('title', 'Welcome') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />
    
    @if($dir=='rtl')
        <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    @endif
    
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @if($dir=='rtl')
        <link rel="stylesheet" href="{{ asset('assets/css/app-rtl.min.css') }}" type="text/css" />
    @endif
    
    @stack('third_party_stylesheets')
    @stack('page_css')
</head>
<body data-topbar="dark">
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xxl-7 col-lg-7 d-md-none d-lg-block" style="display:none !important;">
                    <div class="col-md-12 d-none d-md-block"  >
                        <div class="auth-bg pt-md-5 p-4 " style="position: fixed;width: 100%">
                            <div class="bg-overlay"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>

                            <div class="row justify-content-center align-items-end">
                                <div class="col-xl-12">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators auth-carousel carousel-indicators-rounded justify-content-center mb-0">

                                            </div>

                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-center text-white" style="position: fixed;width: 75%;">
                                                        <div class="mt-4 pt-1 pb-5 mb-5"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5 col-lg-5 col-md-12">

                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">

                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="{{ url('/') }}" class="d-block auth-logo">
                                        <img src="{{ asset(config('app.ligth_sm_logo')) }}" alt="" height="60" class="lazyload">
                                    </a>
                                </div>

                                @if (session()->has('Success'))
                                    <div class="alert alert-success alert-border-left alert-dismissible fade show success_error_alerts " role="alert">
                                        <i class="mdi mdi-check-all me-3 align-middle"></i>{{session('Success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session()->has('Error'))
                                    <div class="alert alert-danger alert-border-left alert-dismissible fade show success_error_alerts" role="alert">
                                        <i class="mdi mdi-block-helper me-3 align-middle"></i>{{session('Error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @yield('content')

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> {{ __('auth.copyright') }} | <a href="{{ route('/') }}">{{ config('app.name') }}</a> {{ __('auth.all_rights_reserved') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/pass-addon.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/feather-icon.init.js') }}"></script>
    <script src="{{ asset('assets/libs/pristinejs/pristine.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    @stack('third_party_scripts')
    @stack('page_scripts')
</body>
</html>
