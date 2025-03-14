<!DOCTYPE html>
@php($dir = Cookie::get('front_dir', $language->direction ?? 'rtl'))
<html lang="en" dir="{{$dir}}">
@php($metaDatas = getSiteSetting())
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title', 'Home') | {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">

 <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
    <meta name="keywords" content="{{ $metaDatas['seo_keyword']??"" }}">
    <meta name="description" content="{{ $metaDatas['seo_description']??"" }}">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/free-v4-shims.min.css') }}" media="all" rel="stylesheet">
    <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" />
    @if(isset($metaDatas['analytics_code']) && $metaDatas['analytics_code']!=null && $metaDatas['analytics_code']!="")
        {!! $metaDatas['analytics_code'] !!}
    @endif
</head>

<body class="animation">
<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container position-relative">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset(config('app.dark_sm_logo')) }}" alt="{{ config('app.name') }}" width="150">
            </a>
            <div class="offcanvas-collapse1 ml-auto">
                <ul class="navbar-nav flex-row">
                    @if (auth()->check())
                        <li class="nav-item nav-item--btn">
                            <a id="buyBtn" href="{{ url('/register') }}"
                               class="btn btn-primary btn-sm btn--has-shadow btn-default">
                                    <span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                  d="M4 4V6H20V4M4 7L3 12V14H4V20H13C12.95 19.66 12.92 19.31 12.92 18.95C12.92 17.73 13.3 16.53 14 15.53V14H15.54C16.54 13.33 17.71 12.96 18.91 12.96C19.62 12.96 20.33 13.09 21 13.34V12L20 7M6 14H12V18H6M18 15V18H15V20H18V23H20V20H23V18H20V15">
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
                        <li class="nav-item nav-item--btn">
                            <a class="btn btn-secondary btn-sm btn--has-shadow btn-default"
                               href="{{ url('/login') }}">
                                    <span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                  d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                            </path>
                                        </svg>
                                        <font style="vertical-align: inherit;" class="d-none d-lg-inline">
                                            {{ __('auth.sign_in') }}</font>
                                    </span>
                            </a>
                        </li>
                        <li class="nav-item nav-item--btn">
                            <a id="buyBtn" href="{{ url('/register') }}"
                               class="btn btn-primary btn-sm btn--has-shadow btn-default">
                                    <span>
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                  d="M4 4V6H20V4M4 7L3 12V14H4V20H13C12.95 19.66 12.92 19.31 12.92 18.95C12.92 17.73 13.3 16.53 14 15.53V14H15.54C16.54 13.33 17.71 12.96 18.91 12.96C19.62 12.96 20.33 13.09 21 13.34V12L20 7M6 14H12V18H6M18 15V18H15V20H18V23H20V20H23V18H20V15">
                                            </path>
                                        </svg>
                                        <font style="vertical-align: inherit;" class="d-none d-lg-inline">
                                            {{ __('auth.register_your_business') }}
                                        </font>
                                    </span>
                            </a>
                        </li>
                    @endif

                    @php($languages_array = getAllLanguages(true))

                    @if(isset($languages_array) && count($languages_array)>1)
                        <li class="nav-item nav-item--btn me-2">
                            <div class="dropdown show">
                                <a class="btn btn-secondary btn-sm btn--has-shadow btn-default dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg fill="#000000" height="24px" width="24px" version="1.1" id="anna_vital_language_icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         viewBox="0 0 256 256" enable-background="new 0 0 256 256" xml:space="preserve">
                                    <path fill="currentColor" d="M62.4,101c-1.5-2.1-2.1-3.4-1.8-3.9c0.2-0.5,1.6-0.7,3.9-0.5c2.3,0.2,4.2,0.5,5.8,0.9c1.5,0.4,2.8,1,3.8,1.7
                                        c1,0.7,1.8,1.5,2.3,2.6c0.6,1,1,2.3,1.4,3.7c0.7,2.8,0.5,4.7-0.5,5.7c-1.1,1-2.6,0.8-4.6-0.6c-2.1-1.4-3.9-2.8-5.5-4.2
                                        C65.5,105.1,63.9,103.2,62.4,101z M40.7,190.1c4.8-2.1,9-4.2,12.6-6.4c3.5-2.1,6.6-4.4,9.3-6.8c2.6-2.3,5-4.9,7-7.7
                                        c2-2.7,3.8-5.8,5.4-9.2c1.3,1.2,2.5,2.4,3.8,3.5c1.2,1.1,2.5,2.2,3.8,3.4c1.3,1.2,2.8,2.4,4.3,3.8c1.5,1.4,3.3,2.8,5.3,4.5
                                        c0.7,0.5,1.4,0.9,2.1,1c0.7,0.1,1.7,0,3.1-0.6c1.3-0.5,3-1.4,5.1-2.8c2.1-1.3,4.7-3.1,7.9-5.4c1.6-1.1,2.4-2,2.3-2.7
                                        c-0.1-0.7-1-1-2.7-0.9c-3.1,0.1-5.9,0.1-8.3-0.1c-2.5-0.2-5-0.6-7.4-1.4c-2.4-0.8-4.9-1.9-7.5-3.4c-2.6-1.5-5.6-3.6-9.1-6.2
                                        c1-3.9,1.8-8,2.4-12.4c0.3-2.5,0.6-4.3,0.8-5.6c0.2-1.2,0.5-2.4,0.9-3.3c0.3-0.8,0.4-1.4,0.5-1.9c0.1-0.5-0.1-1-0.4-1.6
                                        c-0.4-0.5-1-1.1-1.9-1.7c-0.9-0.6-2.2-1.4-3.9-2.3c2.4-0.9,5.1-1.7,7.9-2.6c2.7-0.9,5.7-1.8,8.8-2.7c3-0.9,4.5-1.9,4.6-3.1
                                        c0.1-1.2-0.9-2.3-3.2-3.5c-1.5-0.8-2.9-1.1-4.3-0.9c-1.4,0.2-3.2,0.9-5.4,2.2c-0.6,0.4-1.8,0.9-3.4,1.6c-1.7,0.7-3.6,1.5-6,2.5
                                        c-2.4,1-5,2-7.8,3.1c-2.9,1.1-5.8,2.2-8.7,3.2c-2.9,1.1-5.7,2-8.2,2.8c-2.6,0.8-4.6,1.4-6.1,1.6c-3.8,0.8-5.8,1.6-5.9,2.4
                                        c0,0.8,1.5,1.6,4.4,2.4c1.2,0.3,2.3,0.6,3.1,0.6c0.8,0.1,1.7,0.1,2.5,0c0.8-0.1,1.6-0.3,2.4-0.5c0.8-0.3,1.7-0.7,2.8-1.1
                                        c1.6-0.8,3.9-1.7,6.9-2.8c2.9-1,6.6-2.4,11.2-4c0.9,2.7,1.4,6,1.4,9.8c0,3.8-0.4,8.1-1.4,13c-1.3-1.1-2.7-2.3-4.2-3.6
                                        c-1.5-1.3-2.9-2.6-4.3-3.9c-1.6-1.5-3.2-2.5-4.7-3c-1.6-0.5-3.4-0.5-5.5,0c-3.3,0.9-5,1.9-4.9,3.1c0,1.2,1.3,1.8,3.8,1.9
                                        c0.9,0.1,1.8,0.3,2.7,0.6c0.9,0.3,1.9,0.9,3.2,1.8c1.3,0.9,2.9,2.2,4.7,3.8c1.8,1.6,4.2,3.7,7,6.3c-1.2,2.9-2.6,5.6-4.1,8
                                        c-1.5,2.5-3.4,5-5.5,7.3c-2.2,2.4-4.7,4.8-7.7,7.2c-3,2.5-6.6,5.1-10.8,7.8c-4.3,2.8-6.5,4.7-6.5,5.6C35,192.1,37,191.7,40.7,190.1z
                                         M250.5,81.8v165.3l-111.6-36.4L10.5,253.4V76.1l29.9-10V10.4l81.2,28.7L231.3,2.6v73.1L250.5,81.8z M124.2,50.6L22.3,84.6v152.2
                                        l101.9-33.9V50.6L124.2,50.6z M219.4,71.9V19L138.1,46L219.4,71.9z M227,201.9L196.5,92L176,85.6l-30.9,90.8l18.9,5.9l5.8-18.7
                                        l31.9,10l5.7,22.3L227,201.9z M174.8,147.7l22.2,6.9l-10.9-42.9L174.8,147.7z"/>
                                    </svg>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @if (!isset($languages_array))

                                    @endif

                                    @foreach ($languages_array as $key => $language)
                                        <a @if (App::currentLocale() == $key) disabled @endif @if (App::currentLocale() != $key) role="button" onclick="event.preventDefault(); document.getElementById('user_set_default_language{{ $key }}').submit();"@endif class="dropdown-item @if (App::currentLocale() == $key) btn-primary text-white @endif" >{{ $language }}</a>
                                        @if (App::currentLocale() != $key)
                                            {{ Form::open(['route' => ['restaurant.default.language', ['language' => $key]], 'method' => 'put', 'autocomplete' => 'off', 'class' => 'd-none', 'id' => 'user_set_default_language' . $key]) }}
                                            <input type="hidden" name='back' value="{{ request()->fullurl() }}">
                                            {{ Form::close() }}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="main">
    <section class="hero">
        <div class="container">
            <div class="call-to-action">
                <h1 class=" animation-float-fast ">
                    <font
                        style="vertical-align: inherit; white-space: break-spaces;"> {{ trans('system.banner.banner_title') }} </font>
                </h1>
            </div>
            <div class="space">
                <picture>
                    <img class="hero-phone animation-float-very-slow" src="{{ asset(config('app.banner_image_two')) }}">
                </picture>
            </div>
        </div>
        <div class="hero-slide">
            <picture>
                <img src="{{ asset(config('app.banner_image_one')) }}" alt="{{ config('app.name') }}">
            </picture>
        </div>
    </section>
    <section class="section featured gradient-light--lean-right" id="howitworks" tabindex="-1">
        <div class="container">
            <div class="row">
                <h2 class="title text-center">
                    <font style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_main_title') }} </font>
                </h2>
                <div class="main-features__list col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card  animation-float-fast ">
                                <picture>
                                    <img src="{{ asset(config('app.how_it_works_step_one')) }}" alt="{{ config('app.name') }}"
                                         loading="lazy">
                                </picture>
                                <div class="step-title text-center">
                                    <font
                                        style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_title_one') }} </font>
                                </div>
                                <div class="text text-center">
                                    <font
                                        style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_description_one') }}</font>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card  animation-float-slow ">
                                <picture>
                                    <img src="{{ asset(config('app.how_it_works_step_two')) }}" alt="{{ config('app.name') }}"
                                         loading="lazy">
                                </picture>
                                <div class="step-title text-center">
                                    <font
                                        style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_title_two') }}</font>
                                </div>
                                <div class="text text-center">
                                    <font
                                        style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_description_two') }}</font>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card  animation-float-very-slow ">
                                <picture>
                                    <img src="{{ asset(config('app.how_it_works_step_three')) }}" alt="{{ config('app.name') }}"
                                         loading="lazy">
                                </picture>
                                <div class="step-title text-center">
                                    <font
                                        style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_title_three') }}</font>
                                </div>
                                <div class="text text-center">
                                    <font
                                        style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.how_it_works.how_it_works_description_three') }}</font>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-block-feature gradient-light--lean-left" id="ventajas">
        <div class="container">
            <h2 class="title text-center">
                <font style="vertical-align: inherit;">{{ trans('system.advantages.advantages_main_title') }}</font>
            </h2>
            <div class="row">
                <div class="col-md-4 side-left-advantages">
                    <div class="row">
                        <div class="s2-feature_icon text-center relative-position">
                            <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                <path fill="#ffffff"
                                      d="M12 .5C11.03 .5 10.25 1.28 10.25 2.25C10.25 2.84 10.55 3.37 11 3.68V5.08C10.1 5.21 9.26 5.5 8.5 5.94L7.39 4.35C7.58 3.83 7.53 3.23 7.19 2.75C6.84 2.26 6.3 2 5.75 2C5.4 2 5.05 2.1 4.75 2.32C3.96 2.87 3.76 3.96 4.32 4.75C4.66 5.24 5.2 5.5 5.75 5.5L6.93 7.18C6.5 7.61 6.16 8.09 5.87 8.62C5.67 8.54 5.46 8.5 5.25 8.5C4.8 8.5 4.35 8.67 4 9C3.33 9.7 3.33 10.8 4 11.5C4.29 11.77 4.64 11.92 5 12L5 12C5 12.54 5.07 13.06 5.18 13.56L3.87 13.91C3.56 13.65 3.16 13.5 2.75 13.5C2.6 13.5 2.44 13.5 2.29 13.56C1.36 13.81 .809 14.77 1.06 15.71C1.27 16.5 2 17 2.75 17C2.9 17 3.05 17 3.21 16.94C3.78 16.78 4.21 16.36 4.39 15.84L5.9 15.43C6.35 16.22 6.95 16.92 7.65 17.5L6.55 19.5C6 19.58 5.5 19.89 5.21 20.42C4.75 21.27 5.07 22.33 5.92 22.79C6.18 22.93 6.47 23 6.75 23C7.37 23 7.97 22.67 8.29 22.08C8.57 21.56 8.56 20.96 8.31 20.47L9.38 18.5C10.19 18.82 11.07 19 12 19C12.06 19 12.12 19 12.18 19C12.05 19.26 12 19.56 12 19.88C12.08 20.8 12.84 21.5 13.75 21.5C13.79 21.5 13.84 21.5 13.88 21.5C14.85 21.42 15.57 20.58 15.5 19.62C15.46 19.12 15.21 18.68 14.85 18.39C15.32 18.18 15.77 17.91 16.19 17.6L18.53 19.94C18.43 20.5 18.59 21.07 19 21.5C19.35 21.83 19.8 22 20.25 22S21.15 21.83 21.5 21.5C22.17 20.8 22.17 19.7 21.5 19C21.15 18.67 20.7 18.5 20.25 18.5C20.15 18.5 20.05 18.5 19.94 18.53L17.6 16.19C18.09 15.54 18.47 14.8 18.71 14H19.82C20.13 14.45 20.66 14.75 21.25 14.75C22.22 14.75 23 13.97 23 13S22.22 11.25 21.25 11.25C20.66 11.25 20.13 11.55 19.82 12H19C19 10.43 18.5 9 17.6 7.81L18.94 6.47C19.05 6.5 19.15 6.5 19.25 6.5C19.7 6.5 20.15 6.33 20.5 6C21.17 5.31 21.17 4.2 20.5 3.5C20.15 3.17 19.7 3 19.25 3S18.35 3.17 18 3.5C17.59 3.93 17.43 4.5 17.53 5.06L16.19 6.4C15.27 5.71 14.19 5.25 13 5.08V3.68C13.45 3.37 13.75 2.84 13.75 2.25C13.75 1.28 12.97 .5 12 .5M12 17C9.24 17 7 14.76 7 12S9.24 7 12 7 17 9.24 17 12 14.76 17 12 17M10.5 9C9.67 9 9 9.67 9 10.5S9.67 12 10.5 12 12 11.33 12 10.5 11.33 9 10.5 9M14 13C13.45 13 13 13.45 13 14C13 14.55 13.45 15 14 15C14.55 15 15 14.55 15 14C15 13.45 14.55 13 14 13Z">
                                </path>
                            </svg>
                        </div>
                        <div class="title-advantage bold">
                            <font
                                style="vertical-align: inherit;">{{ trans('system.advantages.advantages_title_one') }}</font>
                        </div>
                        <div class="desc-advantage">
                            <font
                                style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.advantages.advantages_description_one') }}</font>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="s2-feature_icon text-center relative-position">
                            <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                <path fill="#ffffff"
                                      d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z">
                                </path>
                            </svg>
                        </div>
                        <div class="title-advantage bold">
                            <font
                                style="vertical-align: inherit;">{{ trans('system.advantages.advantages_title_two') }}</font>
                        </div>
                        <div class="desc-advantage">
                            <font
                                style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.advantages.advantages_description_two') }}</font>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="s2-feature_icon text-center relative-position">
                            <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                <path fill="#ffffff"
                                      d="M7,15H9C9,16.08 10.37,17 12,17C13.63,17 15,16.08 15,15C15,13.9 13.96,13.5 11.76,12.97C9.64,12.44 7,11.78 7,9C7,7.21 8.47,5.69 10.5,5.18V3H13.5V5.18C15.53,5.69 17,7.21 17,9H15C15,7.92 13.63,7 12,7C10.37,7 9,7.92 9,9C9,10.1 10.04,10.5 12.24,11.03C14.36,11.56 17,12.22 17,15C17,16.79 15.53,18.31 13.5,18.82V21H10.5V18.82C8.47,18.31 7,16.79 7,15Z">
                                </path>
                            </svg>
                        </div>
                        <div class="title-advantage bold">
                            <font
                                style="vertical-align: inherit;">{{ trans('system.advantages.advantages_title_three') }}</font>
                        </div>
                        <div class="desc-advantage">
                            <font
                                style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.advantages.advantages_description_three') }}</font>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <picture>
                        <img src="{{ asset(config('app.banner_image_two')) }}" class="iPhoneXS" alt="{{ config('app.name') }}"
                             loading="lazy">
                    </picture>
                </div>
                <div class="col-md-4 right-side-advantages">
                    <div class="row">
                        <div class="s2-feature_icon text-center relative-position">
                            <svg style="width:35px;height:35px" viewBox="0 0 24 24">
                                <path fill="#ffffff"
                                      d="M15,4A8,8 0 0,1 23,12A8,8 0 0,1 15,20A8,8 0 0,1 7,12A8,8 0 0,1 15,4M15,6A6,6 0 0,0 9,12A6,6 0 0,0 15,18A6,6 0 0,0 21,12A6,6 0 0,0 15,6M14,8H15.5V11.78L17.83,14.11L16.77,15.17L14,12.4V8M2,18A1,1 0 0,1 1,17A1,1 0 0,1 2,16H5.83C6.14,16.71 6.54,17.38 7,18H2M3,13A1,1 0 0,1 2,12A1,1 0 0,1 3,11H5.05L5,12L5.05,13H3M4,8A1,1 0 0,1 3,7A1,1 0 0,1 4,6H7C6.54,6.62 6.14,7.29 5.83,8H4Z">
                                </path>
                            </svg>
                        </div>
                        <div class="title-advantage bold">
                            <font
                                style="vertical-align: inherit;">{{ trans('system.advantages.advantages_title_four') }}</font>
                        </div>
                        <div class="desc-advantage">
                            <font
                                style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.advantages.advantages_description_four') }}</font>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="s2-feature_icon text-center relative-position">
                            <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                <path fill="#ffffff"
                                      d="M2.3,20.28L11.9,10.68L10.5,9.26L9.78,9.97C9.39,10.36 8.76,10.36 8.37,9.97L7.66,9.26C7.27,8.87 7.27,8.24 7.66,7.85L13.32,2.19C13.71,1.8 14.34,1.8 14.73,2.19L15.44,2.9C15.83,3.29 15.83,3.92 15.44,4.31L14.73,5L16.15,6.43C16.54,6.04 17.17,6.04 17.56,6.43C17.95,6.82 17.95,7.46 17.56,7.85L18.97,9.26L19.68,8.55C20.07,8.16 20.71,8.16 21.1,8.55L21.8,9.26C22.19,9.65 22.19,10.29 21.8,10.68L16.15,16.33C15.76,16.72 15.12,16.72 14.73,16.33L14.03,15.63C13.63,15.24 13.63,14.6 14.03,14.21L14.73,13.5L13.32,12.09L3.71,21.7C3.32,22.09 2.69,22.09 2.3,21.7C1.91,21.31 1.91,20.67 2.3,20.28M20,19A2,2 0 0,1 22,21V22H12V21A2,2 0 0,1 14,19H20Z">
                                </path>
                            </svg>
                        </div>
                        <div class="title-advantage bold">
                            <font
                                style="vertical-align: inherit;">{{ trans('system.advantages.advantages_title_five') }}</font>
                        </div>
                        <div class="desc-advantage">
                            <font
                                style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.advantages.advantages_description_five') }}</font>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="s2-feature_icon text-center relative-position">
                            <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                <path fill="#ffffff"
                                      d="M4,4H10V10H4V4M20,4V10H14V4H20M14,15H16V13H14V11H16V13H18V11H20V13H18V15H20V18H18V20H16V18H13V20H11V16H14V15M16,15V18H18V15H16M4,20V14H10V20H4M6,6V8H8V6H6M16,6V8H18V6H16M6,16V18H8V16H6M4,11H6V13H4V11M9,11H13V15H11V13H9V11M11,6H13V10H11V6M2,2V6H0V2A2,2 0 0,1 2,0H6V2H2M22,0A2,2 0 0,1 24,2V6H22V2H18V0H22M2,18V22H6V24H2A2,2 0 0,1 0,22V18H2M22,22V18H24V22A2,2 0 0,1 22,24H18V22H22Z">
                                </path>
                            </svg>
                        </div>
                        <div class="title-advantage bold">
                            <font
                                style="vertical-align: inherit;">{{ trans('system.advantages.advantages_title_six') }}</font>
                        </div>
                        <div class="desc-advantage">
                            <font
                                style="vertical-align: inherit; white-space: break-spaces;">{{ trans('system.advantages.advantages_description_six') }}</font>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($faqQuestions) && count($faqQuestions)>0)
        <section class="section faqs gradient-light--lean-left">
            <div class="container">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 text-center">
                            <h2 class="text-center title">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{trans('system.faq.title')}}</font>
                                </font>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($faqQuestions as $faqQuestion)
                                <div class="panel panel-default shadow">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a href="javascript:void(0)" class="collapsed" data-toggle="collapse"
                                               data-target="{{ '#collapse' . $faqQuestion->id }}" aria-expanded="false"
                                               aria-controls="collapseOne">
                                                <font style="vertical-align: inherit;"> {{ $faqQuestion->local_question }}
                                                </font>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ 'collapse' . $faqQuestion->id }}" class="collapse"
                                         aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="panel-body">
                                            <font style="vertical-align: inherit;"> {{ $faqQuestion->local_answer }} </font>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(isset($plans) && count($plans)>0)
        <section class="section gradient-light--lean-right" id="prices">
        <figure class="figure pattern-svg">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1170px"
                 height="348px">
                <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                      d="M-0.011,116.317 L8.682,113.988 L11.011,122.681 L2.318,125.011 L-0.011,116.317 Z"></path>
                <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                      d="M463.014,336.868 L474.131,331.013 L479.986,342.131 L468.868,347.984 L463.014,336.868 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(93, 203, 250)"
                      d="M610.564,-0.012 L623.995,8.556 L615.429,21.987 L601.997,13.419 L610.564,-0.012 Z"></path>
                <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                      d="M1123.000,78.000 C1127.418,78.000 1131.000,81.582 1131.000,86.000 C1131.000,90.418 1127.418,94.000 1123.000,94.000 C1118.582,94.000 1115.000,90.418 1115.000,86.000 C1115.000,81.582 1118.582,78.000 1123.000,78.000 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                      d="M1088.000,288.000 C1090.761,288.000 1093.000,290.239 1093.000,293.000 C1093.000,295.761 1090.761,298.000 1088.000,298.000 C1085.239,298.000 1083.000,295.761 1083.000,293.000 C1083.000,290.239 1085.239,288.000 1088.000,288.000 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(93, 203, 250)"
                      d="M910.000,172.000 C912.761,172.000 915.000,174.238 915.000,177.000 C915.000,179.761 912.761,182.000 910.000,182.000 C907.238,182.000 905.000,179.761 905.000,177.000 C905.000,174.238 907.238,172.000 910.000,172.000 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(93, 203, 250)"
                      d="M57.000,317.000 C59.209,317.000 61.000,318.791 61.000,321.000 C61.000,323.209 59.209,325.000 57.000,325.000 C54.791,325.000 53.000,323.209 53.000,321.000 C53.000,318.791 54.791,317.000 57.000,317.000 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(74, 92, 246)"
                      d="M178.500,83.000 C184.299,83.000 189.000,87.701 189.000,93.500 C189.000,99.299 184.299,104.000 178.500,104.000 C172.701,104.000 168.000,99.299 168.000,93.500 C168.000,87.701 172.701,83.000 178.500,83.000 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(35, 23, 123)"
                      d="M276.500,275.000 C278.985,275.000 281.000,277.014 281.000,279.500 C281.000,281.985 278.985,284.000 276.500,284.000 C274.015,284.000 272.000,281.985 272.000,279.500 C272.000,277.014 274.015,275.000 276.500,275.000 Z">
                </path>
                <path fill-rule="evenodd" fill="rgb(74, 92, 246)"
                      d="M861.131,312.447 L853.879,325.370 L846.314,312.267 L861.131,312.447 Z"></path>
            </svg>
        </figure>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center">
                    <h2 class="text-center title">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">{{trans('system.plans.plan_frontend_title')}}</font>
                        </font>
                    </h2>
                </div>
            </div>
            <div class="pricing__wrapper pt-5">
                <div class="pricing card-group flex-column flex-md-row">


                    <div class="card pricing__card wow fadeIn">
                        <div class="card-header pt-4 pb-3 text-center">
                                <span class="d-block h3">
                                    <font style="vertical-align: inherit;">
                                        <font
                                            style="vertical-align: inherit;">{{config('app.trial_days')}} {{trans('system.plans.days')}}</font>
                                    </font>
                                </span>
                            <div class="pricing__tag">
                                    <span class="price">
                                        <font style="vertical-align: inherit;">
                                            <font
                                                style="vertical-align: inherit;">{{trans('system.plans.trial')}}</font>
                                        </font>
                                    </span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="pricing__feature-list">
                                <li><font
                                        style="vertical-align: inherit;"><strong>{{config('app.trial_restaurant')}}</strong> {{trans('system.plans.restaurant_limit')}}
                                    </font></li>
                                <li><font
                                        style="vertical-align: inherit;"><strong>{{config('app.trial_food')}}</strong> {{trans('system.plans.item_limit')}}
                                    </font></li>
                                <li><font
                                        style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ url('/register') }}" class="btn btn-primary btn--has-shadow btn-default">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{ __('auth.register') }}</font>
                                </font>
                            </a>
                        </div>
                    </div>


                        @foreach($plans as $plankey=>$plan)

                            @if($plankey==0)
                                <div
                                    class="card pricing__card pricing-popular background--brand scale-110 transform-xs-none wow fadeIn"
                                    data-wow-duration="1.3s" data-wow-delay="0.4s">
                                    <div class="popular__badge text-center">
                                        <small class="text-uppercase">
                                            <strong>
                                                <font style="vertical-align: inherit;">
                                                    <font
                                                        style="vertical-align: inherit;">{{trans('system.plans.plan_frontend_recommended')}}</font>
                                                </font>
                                            </strong>
                                        </small>
                                    </div>
                                    @else
                                        <div class="card pricing__card wow fadeIn" data-wow-duration="1.3s"
                                             data-wow-delay="0.6s">
                                            @endif

                                            <div class="card-header pt-4 pb-3 text-center">
                                    <span class="d-block h3">
                                        <font style="vertical-align: inherit;">
                                            <font @if($plankey==0) class="text-white"
                                                  @endif style="vertical-align: inherit;">{{$plan->local_title}}</font>
                                        </font>
                                    </span>

                                                <div class="pricing__tag">
                                        <span class="price">
                                            <font style="vertical-align: inherit;">
                                                <font
                                                    style="vertical-align: inherit;">{{displayCurrency($plan->amount)}}</font>
                                            </font>
                                        </span>
                                                    <font style="vertical-align: inherit;">
                                                        <font
                                                            style="vertical-align: inherit;">{{trans('system.plans.' . $plan->type)}}</font>
                                                    </font>
                                                </div>

                                            </div>

                                            <div class="card-body pt-1">
                                                <ul class="pricing__feature-list">

                                                    @if($plan->restaurant_unlimited=='yes')
                                                        <li><font
                                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_restaurants')}}</font>
                                                        </li>
                                                    @else
                                                        <li><font
                                                                style="vertical-align: inherit;"><strong>{{$plan->restaurant_limit}}</strong> {{trans('system.plans.restaurant_limit')}}
                                                            </font></li>
                                                    @endif


                                                    @if($plan->item_unlimited=='yes')
                                                        <li><font
                                                                style="vertical-align: inherit;">{{trans('system.plans.unlimited_items')}}</font>
                                                        </li>
                                                    @else
                                                        <li><font
                                                                style="vertical-align: inherit;"><strong>{{$plan->item_limit}}</strong> {{trans('system.plans.item_limit')}}
                                                            </font></li>
                                                    @endif

                                                    @if($plan->staff_unlimited=='yes')
                                                    <li><font
                                                            style="vertical-align: inherit;">{{trans('system.plans.unlimited_staff')}}</font>
                                                    </li>
                                                @else
                                                    <li><font
                                                            style="vertical-align: inherit;"><strong>{{$plan->staff_limit}}</strong> {{trans('system.plans.staff_limit')}}
                                                        </font></li>
                                                @endif

                                                    <li><font
                                                            style="vertical-align: inherit;">{{trans('system.plans.unlimited_support')}}</font>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="card-footer text-center">
                                                <a href="{{url('/register')}}"
                                                   class="btn @if($plankey==0) btn-secondary @else btn-primary @endif btn--has-shadow btn-default">
                                                    <font
                                                        style="vertical-align: inherit;">{{ __('auth.register') }}</font>
                                                </a>
                                            </div>

                                        </div>
                                        @endforeach


                                </div>
                </div>
            </div>
    </section>
    @endif

    @if (count($testimonials) > 0)
        <section class="section section-testimonials gradient-light--lean-left">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-md-left">
                        <h2 class="title">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">{{trans('system.testimonial.title')}}</font>
                            </font>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="swiper-container pt-5 pb-6 swiper-container-initialized swiper-container-horizontal"
                             style="cursor: grab;">
                            <div class="swiper-wrapper"
                                 style="transition-duration: 0ms; transform: translate3d(-1900px, 0px, 0px);">
                                @foreach ($testimonials as $testimonial)
                                    <div class="swiper-slide testimony__card p-3" style="width: 380px;">
                                        <blockquote class="blockquote shadow">
                                            <p class="mb-4">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">
                                                        {{ $testimonial->description }}</font>
                                                </font>
                                            </p>
                                            <footer class="blockquote-footer d-flex align-items-center">
                                                <div class="testimony__avatar d-inline-block mr-3">
                                                    @if (isset($testimonial) && $testimonial->testimonial_image != null)
                                                        <img class="rounded-circle" width="55" height="55"
                                                             src="{{ $testimonial->testimonial_image }}"
                                                             alt="{{ config('app.name') }}" loading="lazy">
                                                    @else
                                                        <div class="preview-image-default">
                                                            <h1
                                                                class="rounded-circle font-size text-white d-inline-block text-bold bg-primary px-4 py-3 ">
                                                                {{ 'T' }}</h1>
                                                        </div>
                                                        <img
                                                            class="avatar-xl rounded-circle img-thumbnail preview-image"
                                                            style="display: none;"/>
                                                    @endif
                                                </div>
                                                <div class="testimony__info d-inline-block">
                                                        <span class="info-name d-block" style="margin-left:12px;">
                                                            <font style="vertical-align: inherit;">
                                                                <font style="vertical-align: inherit;">
                                                                    {{ $testimonial->name }}</font>
                                                            </font>
                                                        </span>
                                                </div>
                                            </footer>
                                        </blockquote>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
                                <span class="swiper-pagination-bullet" tabindex="0" role="button"
                                      aria-label="Go to slide 1"></span>
                                <span class="swiper-pagination-bullet" tabindex="0" role="button"
                                      aria-label="Go to slide 2"></span>
                                <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0"
                                      role="button" aria-label="Go to slide 3"></span>
                                <span class="swiper-pagination-bullet" tabindex="0" role="button"
                                      aria-label="Go to slide 4"></span>
                                <span class="swiper-pagination-bullet" tabindex="0" role="button"
                                      aria-label="Go to slide 5"></span>
                                <span class="swiper-pagination-bullet" tabindex="0" role="button"
                                      aria-label="Go to slide 6"></span>
                            </div>
                            <div class="swiper-button-prev rounded" tabindex="0" role="button"
                                 aria-label="Previous slide"></div>
                            <div class="swiper-button-next rounded" tabindex="0" role="button"
                                 aria-label="Next slide"></div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
@include('frontend.landing_page.footer')

<script src="{{ asset('assets/js/font-awesome.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/swiper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/typer.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/notification.init.js') }}"></script>
<script>
    @if (session()->has('Success'))
        alertify.success('{{ session('Success') }}');
    @endif

    @if (session()->has('Error'))
        alertify.error('{{ session('Error') }}');
    @endif
    $(window).on('scroll', function () {
        if ($(".btn").is(':visible')) {
            $(".btn").addClass("btn-default");
        }
    });
</script>
</body>

</html>
