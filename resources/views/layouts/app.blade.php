<!doctype html>
@php($dir = 'rtl')
<?php // @php($ dir = Cookie::get('front_dir', $language->direction ?? 'rtl'))
?>
<html lang="en" dir="{{ $dir }}">
@php($metaDatas = getSiteSetting())

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Home') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />
    @if ($dir == 'rtl')
        <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet"
            type="text/css" />
    @else
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
            type="text/css" />
    @endif
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" />
    @if ($dir == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/css/app-rtl.min.css') }}" type="text/css" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/cdns/intlTelInput.css') }}" />

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    @stack('third_party_stylesheets')
    <style>
        .iti__flag {
            background-image: url("{{ asset('assets/cdns/flags.png') }}");
        }
    </style>
    @stack('page_css')
    @if (isset($metaDatas['analytics_code']) && $metaDatas['analytics_code'] != null && $metaDatas['analytics_code'] != '')
        {!! $metaDatas['analytics_code'] !!}
    @endif
</head>
@php($theme = Cookie::get('resto_defult_theme', 'light'))

<body data-sidebar="{{ $theme }}" data-layout-mode="{{ $theme }}" data-topbar="{{ $theme }}">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="{{ route('home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img class="lazyload" data-src="{{ asset(config('app.favicon_icon')) }}" alt=""
                                    height="30">
                            </span>
                            <span class="logo-lg">
                                <img class="lazyload" data-src="{{ asset(config('app.ligth_sm_logo')) }}"
                                    alt="" height="60">
                            </span>
                        </a>

                        <a href="{{ route('home') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img class="lazyload" data-src="{{ auth()->user()->profile_url }}" alt=""
                                    height="30">
                            </span>
                            <span class="logo-lg">
                                <img class="lazyload" data-src="{{ auth()->user()->profile_url }}" alt=""
                                    height="60">



                                <img class="lazyload" data-src="{{ asset(config('app.dark_sm_logo')) }}" alt=""
                                    height="60" style="display:none;">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">


                    <div class="dropdown ">
                        @hasanyrole('Super-Admin')
                            <div class="dropdown d-inline-block">
                                <a href="{{ route('/') }}" target="_blank" class="btn">
                                    <i class="font-size-16 fas fa-external-link-alt ms-2 " aria-hidden="true"></i>
                                </a>
                            </div>
                        @else
                            @if (auth()->user()->restaurant != null &&
                                    isset(auth()->user()->restaurant->slug) &&
                                    auth()->user()->restaurant->slug != null)
                                <div class="dropdown d-inline-block">
                                    <a href="{{ route('frontend.restaurant', ['restaurant' => auth()->user()->restaurant->slug]) }}"
                                        target="_blank" class="btn">
                                        <i class="font-size-16 fas fa-external-link-alt ms-2 " aria-hidden="true"></i>
                                    </a>
                                </div>
                            @endif
                        @endhasanyrole


                        {{--                        <div class="dropdown d-inline-block"> --}}
                        {{--                            <button type="button" class="btn header-item" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"> --}}
                        {{--                                <i class="fa fa-search font-size-18"></i> --}}
                        {{--                            </button> --}}
                        {{--                        </div> --}}
                        {{--                        <div class="dropdown d-inline-block"> --}}
                        {{--                            <button type="button" class="btn header-item" data-bs-toggle="modal" data-bs-target=".bs-example1-modal-xl"> --}}
                        {{--                                <i class="fa fa-keyboard font-size-18"></i> --}}
                        {{--                            </button> --}}
                        {{--                        </div> --}}

                        @hasanyrole('Super-Admin')
                            @php($restaurants = App\Http\Controllers\HomeController::getCurrentUsersAllRestaurants())

                            @if (isset($restaurants) && count($restaurants) > 0)
                                <div class="dropdown  d-inline-block ms-1">
                                    <button type="button" class="btn header-item select_store_top"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <h1 class="font-size-16 px-2 pt-2 header-item d-inline-block h-auto"><span
                                                class="fas fa-store-alt font-size-16"></span></h1>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                        <div class="p-2">


                                            @foreach ($restaurants as $restaurant)
                                                @if (auth()->user()->restaurant_id != $restaurant->id)
                                                    {{ Form::open(['route' => ['restaurant.default.restaurant', ['restaurant' => $restaurant->id]], 'method' => 'put', 'autocomplete' => 'off', 'class' => 'd-none', 'id' => 'restaurant_default_restaurant' . $restaurant->id]) }}
                                                    <input type="hidden" name='back'
                                                        value="{{ request()->fullurl() }}">
                                                    {{ Form::close() }}
                                                @endif
                                                <a class="dropdown-icon-item  @if (auth()->user()->restaurant_id == $restaurant->id) bg-light-gray  disabled @endif"
                                                    @if (auth()->user()->restaurant_id != $restaurant->id) role="button"
                                               onclick="event.preventDefault(); document.getElementById('restaurant_default_restaurant{{ $restaurant->id }}').submit();" @endif
                                                    title="Set as Default">
                                                    <div class="row g-0">
                                                        <div class="col-3">
                                                            @if ($restaurant->logo_url != null)
                                                                <img data-src="{{ $restaurant->logo_url }}"
                                                                    alt=""
                                                                    class="rounded-circle header-profile-user lazyload">
                                                            @else
                                                                <h1
                                                                    class="rounded-circle header-profile-user font-size-18 px-2 pt-2 text-white d-inline-block font-bold bg-primary">
                                                                    {{ $restaurant->logo_name }}</h1>
                                                            @endif
                                                        </div>
                                                        <div class="col-9  text-start overflow-hidden">
                                                            <span>{{ $restaurant->name }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endhasanyrole
                        @hasanyrole('Super-Admin')
                            <div class="dropdown d-none d-sm-inline-block">
                                <button type="button" class="btn header-item" id="mode-setting-btn">
                                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                                </button>
                            </div>
                        @endhasanyrole
                        @hasanyrole('Super-Admin')
                            <div class="dropdown d-inline-block ms-1">
                                <button type="button" class="btn header-item" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <h1 class="font-size-16 px-2 pt-2 header-item d-inline-block h-auto">
                                        <i class="fas fa-language font-size-18"></i>
                                    </h1>
                                </button>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                    <div class="p-2">
                                        @if (!isset($languages_array))
                                            @php($languages_array = getAllLanguages(true))
                                        @endif
                                        @foreach ($languages_array as $key => $language)
                                            <a class="dropdown-icon-item  @if (App::currentLocale() == $key) bg-light-gray  disabled @endif"
                                                @if (App::currentLocale() != $key) role="button"
                                       onclick="event.preventDefault(); document.getElementById('user_set_default_language{{ $key }}').submit();" @endif
                                                title="Set as Default">
                                                <div class="row g-0">
                                                    <div class="col-12  text-start overflow-hidden">
                                                        <h6 class="px-2">{{ $language }}</h6>
                                                    </div>
                                                </div>
                                            </a>
                                            @if (App::currentLocale() != $key)
                                                {{ Form::open(['route' => ['restaurant.default.language', ['language' => $key]], 'method' => 'put', 'autocomplete' => 'off', 'class' => 'd-none', 'id' => 'user_set_default_language' . $key]) }}
                                                <input type="hidden" name='back' value="{{ request()->fullurl() }}">
                                                {{ Form::close() }}
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endhasanyrole
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item bg-soft-light "
                                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                @if (auth()->user()->profile_url != null)
                                    <img data-src="{{ auth()->user()->profile_url }}" alt=""
                                        class="rounded-circle header-profile-user image-object-cover lazyload">
                                @else
                                    <h1
                                        class="rounded-circle header-profile-user font-size-18 px-2 pt-2 text-white d-inline-block font-bold">
                                        {{ auth()->user()->logo_name }}</h1>
                                @endif

                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium">{{ auth()->user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">

                                <a class="dropdown-item" href="{{ route('restaurant.profile') }}"><i
                                        class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>
                                    {{ __('system.profile.menu') }}</a>

                                <div class="dropdown-divider"></div>

                                @role('vendor')
                                    @if (auth()->user()->free_forever == false)
                                        <a class="dropdown-item"
                                            href="{{ route('restaurant.vendor.payment.history') }}"><i
                                                class="mdi mdi-format-list-checks font-size-16 align-middle me-1"></i>
                                            {{ __('system.payment_setting.payment_history') }}</a>

                                        <div class="dropdown-divider"></div>
                                    @endif
                                @endrole

                                <a class="dropdown-item" role="button"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').click();"><i
                                        class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                                    {{ __('auth.sign_out') }}</a>
                                <form autocomplete="off" action="{{ route('logout') }}" method="POST"
                                    class="d-none data-confirm"
                                    data-confirm-message="{{ __('system.fields.logout') }}"
                                    data-confirm-title=" {{ __('auth.sign_out') }}">
                                    <button id="logout-form" type="submit"></button>
                                    @csrf
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
        </header>


        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @if (session()->has('Success'))
                        <div class="alert alert-success alert-border-left alert-dismissible fade show success_error_alerts "
                            role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle"></i>{{ session('Success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('Error'))
                        <div class="alert alert-danger alert-border-left alert-dismissible fade show success_error_alerts"
                            role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle"></i>{{ session('Error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (!auth()->user()->hasVerifiedEmail())
                        @include('layouts.verify')
                    @endif
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-0">©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ __('auth.copyright') }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                <a href="{{ route('/') }}">{{ config('app.name') }}</a>
                                | {{ __('auth.all_rights_reserved') }}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <div class="modal fade bs-example-modal-xl" id="search-model" data-bs-focus="false" tabindex="-1"
            aria-labelledby="myLargeModalLabel" aria-modal="true" role="dialog">

            <div class="modal-dialog modal-xl ">
                <div class="modal-content">
                    <div class="modal-header">
                        <form class="app-search d-block w-100 mt-3" id="global-search-form" autocomplete="off">
                            @csrf
                            <div class="position-relative">
                                <input type="text" class="form-control global-search-input"
                                    id="global-search-input" name='search' tabindex="2"
                                    placeholder="{{ __('system.crud.search') }}" autofocus>
                                <button class="btn btn-primary global-search-btn" type="button"><i
                                        class="bx bx-search-alt align-middle"></i></button>
                            </div>
                        </form>
                        <button type="button" class="btn-close position-absolute model-top-close-css"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body search_content">
                        <h6>{{ __('system.fields.enter_more_char') }}</h6>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        @include('layouts.right_bar')
    </div>

    <script>
        const themeRoute = '{{ route('theme.mode') }}';

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
    </script>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/cdns/lazyload.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pristinejs/pristine.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/notification.init.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ asset('assets/libs/imask/imask.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-mask.init.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @include('js')
    @stack('third_party_scripts')
    @stack('page_scripts')
</body>

</html>
