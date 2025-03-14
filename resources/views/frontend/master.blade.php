<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(config('app.favicon_icon')) }}">
    <!-- Font Family -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link href="{{ asset('assets/cdns/css2.css') }}" rel="stylesheet" />
    <!-- Style CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('assets/css/custom-main.css') }}">
    {{-- <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet"
        type="text/css" /> --}}
    @stack('page_css')
</head>

@php
    $theme = Cookie::get('front_theme', '');
    $dir = Cookie::get('front_dir', $language->direction ?? 'rtl');
    $selectedLanguage = $language->store_location_name;
@endphp
<body dir="{{ $dir }}" class="{{ $dir }} overflow-x-hidden">
    <div class="antialiased font-montserrat text-secondary text-base  bg-cover bg-no-repeat bg-center rounded-t-xl {{ $theme }}"
        style="background:url('{{ asset('assets/theme/images/gradient-bg.png') }}') fixed">
        <div class="dark:bg-secondary  bg-cover bg-no-repeat bg-center dark-bg" style="">

            @php($append = request()->query->has('restaurant_view') ? ['restaurant_view' => request()->query->get('restaurant_view')] : [])
            <header class="border-b-2 border-neutral/10 dark:border-white/10 py-3.5 fixed inset-x-0 top-0 transition duration-300 z-10">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-10 col-sm-12 col-md-10 offset-md-1 offset-md-right-1">
                            <div class="flex items-center ml-2.5 flex-col md:flex-row gap-3 lg:gap-6 justify-between header-top">
                                <?php
                                $currentRoute = request()
                                    ->route()
                                    ->uri();
                                $url = $currentRoute == '/' ? route($currentRoute) : route('frontend.restaurant', ['restaurant' => $restaurant->slug] + $append);
                                ?>
                                <button id="sidebarToggle" class="lg:hidden text-primary dark:text-white">
                                    <svg width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="26" height="4" fill="#B77129"></rect>
                                        <rect y="10" width="26" height="4" fill="#B77129"></rect>
                                        <rect y="20" width="26" height="4" fill="#B77129"></rect>
                                    </svg>
                                </button>
                                <button class="search-button">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="text-secondary dark:text-white">
                                        <g clip-path="url(#clip0_75_257)">
                                            <path
                                                d="M15.8667 15.8668C16.2127 15.5208 16.7737 15.5207 17.1197 15.8667L18.3729 17.1194C18.7192 17.4655 18.7192 18.0269 18.373 18.3731C18.0268 18.7193 17.4654 18.7193 17.1193 18.373L15.8666 17.1198C15.5206 16.7738 15.5207 16.2128 15.8667 15.8668Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.9748 1C13.3769 1 16.9496 4.57271 16.9496 8.9748C16.9496 13.3769 13.3769 16.9496 8.9748 16.9496C4.57271 16.9496 1 13.3769 1 8.9748C1 4.57271 4.57271 1 8.9748 1ZM8.9748 15.1774C12.4013 15.1774 15.1774 12.4013 15.1774 8.9748C15.1774 5.54741 12.4013 2.77218 8.9748 2.77218C5.54741 2.77218 2.77218 5.54741 2.77218 8.9748C2.77218 12.4013 5.54741 15.1774 8.9748 15.1774Z"
                                                fill="currentColor"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_75_257">
                                                <rect width="20" height="20" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>


                                <a href="{{ $url }}" class="shrink-0 header-logo-image">
                                    <img src="{{ asset($restaurant->logo_url ?? config('app.dark_sm_logo')) }}" alt="logo"
                                        class="max-h-16 lg:max-h-12  object-contain dark:hidden mr-3" />
                                    <img src="{{ asset($restaurant->dark_logo_url ?? config('app.ligth_sm_logo')) }}"
                                        alt="logo" class="max-h-16 lg:max-h-12 object-contain hidden dark:block  mr-3" />
                                </a>
                                <ul class="flex w-full flex-col-reverse md:flex-row rtl:items-end ltr:md:items-center rtl:md:items-center gap-3 lg:gap-6 search_text_ul">
                                    <li class="w-full">
                                        <div class="relative w-full header-w-full">
                                            <button class="absolute left-3 top-1/2 -translate-y-1/2">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" class="text-secondary dark:text-white">
                                                    <g clip-path="url(#clip0_75_257)">
                                                        <path
                                                            d="M15.8667 15.8668C16.2127 15.5208 16.7737 15.5207 17.1197 15.8667L18.3729 17.1194C18.7192 17.4655 18.7192 18.0269 18.373 18.3731C18.0268 18.7193 17.4654 18.7193 17.1193 18.373L15.8666 17.1198C15.5206 16.7738 15.5207 16.2128 15.8667 15.8668Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M8.9748 1C13.3769 1 16.9496 4.57271 16.9496 8.9748C16.9496 13.3769 13.3769 16.9496 8.9748 16.9496C4.57271 16.9496 1 13.3769 1 8.9748C1 4.57271 4.57271 1 8.9748 1ZM8.9748 15.1774C12.4013 15.1774 15.1774 12.4013 15.1774 8.9748C15.1774 5.54741 12.4013 2.77218 8.9748 2.77218C5.54741 2.77218 2.77218 5.54741 2.77218 8.9748C2.77218 12.4013 5.54741 15.1774 8.9748 15.1774Z"
                                                            fill="currentColor"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_75_257">
                                                            <rect width="20" height="20" fill="white"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                            <input type="text" autocomplete="off" placeholder="{{ __('auth.search_item') }}"
                                                id="search_text"
                                                class="w-full outline-none border-2 border-neutral/30 dark:border-secondary/50 rounded-lg py-3 pl-10 pr-4 placeholder:text-sm placeholder:text-secondary dark:placeholder:text-white dark:text-white font-semibold dark:bg-white/10 search-text">
                                        </div>
                                    </li>
                                    @if (isset($vendor_setting->allow_dark_light_mode_change) && $vendor_setting->allow_dark_light_mode_change == true)
                                        <li>
                                            <button type="button" class="flex">
                                                <label for="day-night" class="inline-flex relative items-center cursor-pointer">
                                                    <input type="checkbox" value="" id="day-night" class="sr-only peer"
                                                        {{ $theme != 'dark' ? 'checked' : '' }}>
                                                    <div
                                                        class="relative border border-primary w-12 md:w-14 h-6 bg-secondary rounded-full peer peer-checked:after:translate-x-[115%] md:peer-checked:after:translate-x-[161%] after:border-white after:content-[''] after:absolute after:top-1/2 after:-translate-y-1/2 after:left-[2px] after:bg-white after:rounded-full after:h-[19px] after:w-[19px] after:transition-all peer-checked:bg-primary">
                                                        <img src="{{ asset('assets/theme/images/sun-svg.svg') }}"
                                                            alt=""
                                                            class="absolute left-0.5 top-1/2 -translate-y-1/2 w-4">
                                                        <img src="{{ asset('assets/theme/images/moon.svg') }}" alt=""
                                                            class="absolute right-0.5 top-[60%] -translate-y-1/2 w-5">
                                                    </div>
                                                </label>
                                            </button>
                                        </li>
                                    @endif

                                    @if (isset($vendor_setting->allow_direction) && $vendor_setting->allow_direction == true)
                                        <li class="w-8 h-7 md:w-auto">
                                            <button type="button" id="direction">
                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" style="width: 26px;height: 26px"
                                                    class="text-primary dark:text-white w-full h-full">
                                                    <g clip-path="url(#clip0_83_167)">
                                                        <path d="M21.2709 22.5327H11.7382" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M18.8036 25L21.2709 22.5327L18.8036 20.0654"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M3.99988 19.5047H13.5326" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M6.46717 21.972L3.99988 19.5047L6.46717 17.0374"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M17.5697 1H9.55103C8.40589 1 7.30766 1.45491 6.49792 2.26464C5.68818 3.07438 5.23328 4.17262 5.23328 5.31776C5.23328 6.4629 5.68818 7.56114 6.49792 8.37087C7.30766 9.18061 8.40589 9.63552 9.55103 9.63552H10.1679"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M15.1025 14.5701V1" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M10.1682 14.5701V1" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_83_167">
                                                            <rect width="26" height="26" fill="currentColor" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                        </li>
                                    @endif

                                    @if (isset($vendor_setting->allow_language_change) && $vendor_setting->allow_language_change == true)
                                        <li class="w-8 h-7 relative" id="language">
                                            <button type="button" class="language-button">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" style="width: 26px;height: 26px" class="text-primary dark:text-white w-full h-full">
                                                    <path d="M458.667,85.333H256c-1.145,0-2.282,0.18-3.371,0.533l-2.56,0.853c-5.59,1.86-8.614,7.899-6.754,13.488c0.011,0.034,0.023,0.067,0.034,0.101l107.221,313.323l-70.613,80.683c-3.876,4.436-3.423,11.175,1.013,15.051c1.946,1.701,4.444,2.637,7.029,2.634h170.667C488.122,512,512,488.122,512,458.667v-320C512,109.211,488.122,85.333,458.667,85.333z" style="fill: rgb(236, 239, 241);"></path>
                                                    <path d="M372.373,411.584c-1.731-3.806-5.526-6.25-9.707-6.251H256c-5.891,0-10.667,4.776-10.667,10.667c0,1.282,0.231,2.554,0.683,3.755l32,85.333c1.321,3.513,4.392,6.073,8.085,6.741c0.627,0.108,1.262,0.165,1.899,0.171c3.075-0.003,5.998-1.333,8.021-3.648l74.667-85.333C373.445,419.868,374.104,415.396,372.373,411.584z" style="fill: rgb(183, 113, 41);"></path>
                                                    <g>
                                                        <path d="M458.667,234.667H309.333c-5.891,0-10.667-4.776-10.667-10.667c0-5.891,4.776-10.667,10.667-10.667h149.333c5.891,0,10.667,4.776,10.667,10.667C469.333,229.891,464.558,234.667,458.667,234.667z" style="fill: rgb(69, 90, 100);"></path>
                                                        <path d="M373.333,234.667c-5.891,0-10.667-4.776-10.667-10.667v-21.333c0-5.891,4.776-10.667,10.667-10.667S384,196.776,384,202.667V224C384,229.891,379.224,234.667,373.333,234.667z" style="fill: rgb(69, 90, 100);"></path>
                                                        <path d="M341.333,362.667c-5.891-0.005-10.663-4.785-10.657-10.676c0.003-3.443,1.668-6.673,4.471-8.673C381.867,310.123,416,242.453,416,224c0-5.891,4.776-10.667,10.667-10.667c5.891,0,10.667,4.776,10.667,10.667c0,28.117-41.109,102.101-89.813,136.683C345.714,361.971,343.552,362.665,341.333,362.667z" style="fill: rgb(69, 90, 100);"></path>
                                                        <path d="M426.667,384c-2.669,0.003-5.241-0.994-7.211-2.795c-7.723-7.083-75.904-70.059-88-99.861c-2.221-5.461,0.406-11.688,5.867-13.909s11.688,0.406,13.909,5.867c8.725,21.504,62.635,73.813,82.667,92.139c4.359,3.962,4.681,10.708,0.719,15.068C432.583,382.747,429.692,384.016,426.667,384z" style="fill: rgb(69, 90, 100);"></path>
                                                    </g>
                                                    <path d="M372.757,412.544L234.091,7.211C232.614,2.898,228.559,0,224,0H53.333C23.878,0,0,23.878,0,53.333v320c0,29.455,23.878,53.333,53.333,53.333h309.333c5.891,0,10.666-4.776,10.666-10.667C373.333,414.824,373.138,413.656,372.757,412.544z" style="fill: rgb(183, 113, 41);"></path>
                                                    <g>
                                                        <path d="M202.667,298.667c-4.51,0.001-8.533-2.835-10.048-7.083l-43.285-121.216l-43.285,121.216c-2.203,5.464-8.418,8.107-13.882,5.904c-5.155-2.078-7.85-7.767-6.193-13.072l53.333-149.333c2.609-5.543,9.218-7.922,14.761-5.314c2.335,1.099,4.214,2.978,5.314,5.314l53.333,149.333c1.986,5.531-0.876,11.627-6.4,13.632C205.143,298.463,203.909,298.672,202.667,298.667z" style="fill: rgb(250, 250, 250);"></path>
                                                        <path d="M170.667,234.667H128c-5.891,0-10.667-4.776-10.667-10.667c0-5.891,4.776-10.667,10.667-10.667h42.667c5.891,0,10.667,4.776,10.667,10.667C181.333,229.891,176.558,234.667,170.667,234.667z" style="fill: rgb(250, 250, 250);"></path>
                                                    </g>
                                                </svg>

                                            </button>
                                            <ul class="absolute left-0 top-[150%] bg-white dark:bg-secondary/70 text-black dark:text-white py-1 z-20 language_list" style="display:none">
                                                @php($languages_array = getAllLanguages(true))
                                                @foreach ($languages_array as $key => $language)
                                                    @if (App::currentLocale() != $key)
                                                        <li class="py-2 px-6 cursor-pointer transition text-sm language-menu {{ $selectedLanguage == $key ? 'active-category' : '' }}"
                                                            onclick="event.preventDefault(); document.getElementById('user_set_default_language{{ $key }}').submit();">
                                                            <a href="">{{ $language }}</a>
                                                        </li>

                                                        {{ Form::open(['route' => ['restaurant.default.language', ['language' => $key]], 'method' => 'put', 'autocomplete' => 'off', 'style' => 'display:none', 'id' => 'user_set_default_language' . $key]) }}
                                                        <input type="hidden" name='back' value="{{ request()->fullurl() }}">
                                                        {{ Form::close() }}
                                                    @else
                                                        <li class="py-2 px-6 bg-[#B77129] text-white cursor-pointer transition text-sm  language-menu {{ $selectedLanguage == $key ? 'active-category' : '' }}"
                                                            onclick="event.preventDefault(); document.getElementById('user_set_default_language{{ $key }}').submit();">
                                                            <a href="">{{ $language }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif

                                    @if (isset($vendor_setting->call_the_waiter) && $vendor_setting->call_the_waiter)
                                        <li class="w-8 h-7">
                                            <button type="button" id="notification" onclick="notificationToggleHandler()">

                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="currentColor"
                                                     xmlns="http://www.w3.org/2000/svg" style="width: 26px;height: 26px"
                                                     class="text-primary dark:text-white w-full h-full">

                                                    <path fill-rule="evenodd"
                                                        d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                        </li>
                                    @endif


                                </ul>
                            </div>
                            <div class="flex items-center ml-2.5 flex-col md:flex-row gap-3 lg:gap-6 justify-between header-search-top" style="display: none;">
                                <div class="relative w-full">
                                    <button class="absolute left-3 top-1/2 -translate-y-1/2 close-search">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-secondary dark:text-white" style="color: white;">
                                            <path d="M8 4l8 6-8 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                    <input type="text" autocomplete="off" placeholder="{{ __('auth.search_item') }}"
                                        id="search_text"
                                        class="w-full outline-none border-2 border-neutral/30 dark:border-secondary/50 rounded-lg py-3 pl-10 pr-4 placeholder:text-sm placeholder:text-secondary dark:placeholder:text-white dark:text-white font-semibold dark:bg-white/10 search-text"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transition-transform duration-300 transform -translate-x-full overflow-y-auto">
                <div class="p-4">
                    <div class="container mx-auto border-brown-bottom">
                        <div class="flex justify-between items-center">
                            <!-- Logo Section -->
                            <div class="text-center flex-1 pl-8">
                                <a href="{{ $url }}" class="shrink-0">
                                    <img src="{{ asset($restaurant->logo_url ?? config('app.dark_sm_logo')) }}" alt="logo" class="max-h-16 lg:max-h-12 object-contain dark:hidden mr-3" />
                                    <img src="{{ asset($restaurant->dark_logo_url ?? config('app.ligth_sm_logo')) }}" alt="logo" class="max-h-16 lg:max-h-12 object-contain hidden dark:block  mr-3" />
                                </a>
                            </div>
                            <div class="flex-none">
                                <button id="closeButton" class="text-white bg-brown-500 hover:bg-brown-700 p-2 rounded focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6">
                        <!-- Menu with dropdown functionality -->
                        <li class="py-2">
                            <button id="menuButton" class="flex justify-between items-center w-full p-3 text-left hover:bg-gray-700 rounded text-black">
                                <!-- Icon on the left -->
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="3" width="7" height="7" fill="currentColor" />
                                        <rect x="14" y="3" width="7" height="7" fill="currentColor" />
                                        <rect x="3" y="14" width="7" height="7" fill="currentColor" />
                                        <rect x="14" y="14" width="7" height="7" fill="currentColor" />
                                    </svg>
                                    <span class="menu-title">{{ trans('system.fields.menu') }}</span>
                                </div>
                                <!-- Arrow icon on the right -->
                                <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <!-- Dropdown content -->
                            <ul id="menuDropdown" class="mt-2 space-y-2 pl-8">
                                @if(!empty($food_categories))
                                    @foreach ($food_categories ?? [] as $category)
                                        <li class="sidebar-options {{ (isset($selectedCategoryId) && ($selectedCategoryId == $category->id))  ? 'selected-active-category' : 'text-black' }}">
                                            <div style="display: flex; align-items: center;">
                                                @if (isset($category->icon) && !is_null($category->icon) && !empty($category->icon) && ($category->icon_available == 1))
                                                    <img src="{{ asset('storage/'.$category->icon) }}" class="category-sidebar-image">
                                                @elseif($category->icon_available == 1)
                                                    <img src="{{ isset($category->category_image) ? asset('storage/'.$category->category_image) : asset('assets/images/default_category.png') }}" class="category-sidebar-image">
                                                @endif
                                                <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id] + $append) }}" class="block hover:bg-gray-700 p-3 rounded menu-items no-wrap {{ ($category->icon_available == 0) ? 'main-sidebar-spacing' : 'default-spacing' }}">
                                                    {{ $category->local_lang_name }}
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                @elseif($categoires)
                                    @foreach($categoires as $key => $category)
                                    <li class="sidebar-options {{ isset($selectedCategoryId) && ($selectedCategoryId == $category->id) ? 'selected-active-category' : 'text-black' }}">
                                        <div style="display: flex; align-items: center;">
                                            @if (isset($category->icon) && !is_null($category->icon) && !empty($category->icon) && ($category->icon_available == 1))
                                                <img src="{{ asset('storage/'.$category->icon) }}" class="category-sidebar-image">
                                            @elseif($category->icon_available == 1)
                                                <img src="{{ asset('storage/'.$category->category_image) }}" class="category-sidebar-image">
                                            @endif
                                            <a href="{{ route('restaurant.menu.item', ['restaurant' => $restaurant->slug, 'food_category' => $category->id] + $append) }}" class="block hover:bg-gray-700 p-3 rounded menu-items no-wrap {{ ($category->icon_available == 0) ? 'main-sidebar-spacing' : 'default-spacing' }}">
                                                {{ $category->local_lang_name }}
                                            </a>
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden"></div>


            @if (
                (isset($vendor_setting->allow_show_banner) && $vendor_setting->allow_show_banner == true) ||
                    (isset($vendor_setting->allow_show_restaurant_name_address) &&
                        $vendor_setting->allow_show_restaurant_name_address == true))
                @if (isset($vendor_setting->allow_show_banner) && $vendor_setting->allow_show_banner == true)
                    <section class="relative h-[250px] md:h-[400px]">
                        <!-- Circles background -->
                        <img class="w-full h-full object-cover" loading="lazy"
                            src="{{ $restaurant->cover_image_url }}"
                            onerror="this.src='{{ asset('assets/images/cover.png') }}'" style="width: 100%">
                        <!-- SVG separator -->
                    </section>
                @endif

                @if (isset($vendor_setting->allow_show_restaurant_name_address) &&
                        $vendor_setting->allow_show_restaurant_name_address == true)
                    @if (isset($vendor_setting->allow_show_banner) && $vendor_setting->allow_show_banner == 0)
                        <section class="relative h-[100px] md:h-[100px]"></section>
                    @endif

                    <section class="pt-5 dark:text-white">
                        <div class="container">
                            <div class="pb-5 border-b border-neutral/30 dark:border-white/30">
                                <p class="text-lg md:text-2xl font-semibold capitalize mb-4">
                                    {{ $restaurant->name . ' - ' . $restaurant->restaurant_type->local_name }}
                                </p>
                                <ul class="flex flex-col md:flex-row gap-3">
                                    @if ($restaurant->full_address)
                                        <li class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-primary flex-shrink-0"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="11" r="3"></circle>
                                                <path
                                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                                </path>
                                            </svg>
                                            <a href="#">{{ $restaurant->full_address }}</a>
                                        </li>
                                    @endif
                                    @if ($restaurant->phone_number)
                                        <li class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="text-primary flex-shrink-0"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <rect x="6" y="3" width="12" height="18"
                                                    rx="2"></rect>
                                                <line x1="11" y1="4" x2="13" y2="4">
                                                </line>
                                                <line x1="12" y1="17" x2="12" y2="17.01">
                                                </line>
                                            </svg>
                                            <a
                                                href="tel:{{ $restaurant->phone_number }}">{{ $restaurant->phone_number }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </section>
                @endif
            @else
                <section class="relative h-[215px] md:h-[120px]"></section>
            @endif


            <div style="min-height:calc(100vh - 144px)">
                @yield('content')
                @once
                    <div class="modal-details"></div>
                    @include('frontend.call_the_waiter')

                @endonce
            </div>



            <footer>
                <div class="container">
                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t-2 border-dashed border-secondary/10 dark:border-white/10 py-5">
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-between text-neutral font-semibold text-sm lg:text-base dark:text-white">
                            <div>©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ __('auth.copyright') }}
                                <a href="{{ route('/') }}">{{ config('app.name') }}</a> |
                                {{ __('auth.all_rights_reserved') }}

                            </div>
                        </div>
                        <div class="flex items-center gap-3 -order-1 sm:order-2">

                            @if (isset($restaurant->facebook_url) && $restaurant->facebook_url != null)
                                <a href="{{ $restaurant->facebook_url }}" target="_blank"
                                    class="flex items-center justify-center w-9 h-9 rounded-full text-white bg-neutral/50 hover:bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="24px"
                                        height="24px">
                                        <path fill="currentColor"
                                            d="M32,11h5c0.552,0,1-0.448,1-1V3.263c0-0.524-0.403-0.96-0.925-0.997C35.484,2.153,32.376,2,30.141,2C24,2,20,5.68,20,12.368 V19h-7c-0.552,0-1,0.448-1,1v7c0,0.552,0.448,1,1,1h7v19c0,0.552,0.448,1,1,1h7c0.552,0,1-0.448,1-1V28h7.222 c0.51,0,0.938-0.383,0.994-0.89l0.778-7C38.06,19.518,37.596,19,37,19h-8v-5C29,12.343,30.343,11,32,11z" />
                                    </svg>
                                </a>
                            @endif

                            @if (isset($restaurant->twitter_url) && $restaurant->twitter_url != null)
                                <a href="{{ $restaurant->twitter_url }}" target="_blank"
                                    class="flex items-center justify-center w-9 h-9 rounded-full text-white bg-neutral/50 hover:bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="22px"
                                        height="22px">
                                        <path fill="currentColor"
                                            d="M 50.0625 10.4375 C 48.214844 11.257813 46.234375 11.808594 44.152344 12.058594 C 46.277344 10.785156 47.910156 8.769531 48.675781 6.371094 C 46.691406 7.546875 44.484375 8.402344 42.144531 8.863281 C 40.269531 6.863281 37.597656 5.617188 34.640625 5.617188 C 28.960938 5.617188 24.355469 10.21875 24.355469 15.898438 C 24.355469 16.703125 24.449219 17.488281 24.625 18.242188 C 16.078125 17.8125 8.503906 13.71875 3.429688 7.496094 C 2.542969 9.019531 2.039063 10.785156 2.039063 12.667969 C 2.039063 16.234375 3.851563 19.382813 6.613281 21.230469 C 4.925781 21.175781 3.339844 20.710938 1.953125 19.941406 C 1.953125 19.984375 1.953125 20.027344 1.953125 20.070313 C 1.953125 25.054688 5.5 29.207031 10.199219 30.15625 C 9.339844 30.390625 8.429688 30.515625 7.492188 30.515625 C 6.828125 30.515625 6.183594 30.453125 5.554688 30.328125 C 6.867188 34.410156 10.664063 37.390625 15.160156 37.472656 C 11.644531 40.230469 7.210938 41.871094 2.390625 41.871094 C 1.558594 41.871094 0.742188 41.824219 -0.0585938 41.726563 C 4.488281 44.648438 9.894531 46.347656 15.703125 46.347656 C 34.617188 46.347656 44.960938 30.679688 44.960938 17.09375 C 44.960938 16.648438 44.949219 16.199219 44.933594 15.761719 C 46.941406 14.3125 48.683594 12.5 50.0625 10.4375 Z" />
                                    </svg>
                                </a>
                            @endif

                            @if (isset($restaurant->youtube_url) && $restaurant->youtube_url != null)
                                <a href="{{ $restaurant->youtube_url }}" target="_blank"
                                    class="flex items-center justify-center w-9 h-9 rounded-full text-white bg-neutral/50 hover:bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="24px"
                                        height="24px">
                                        <path fill="currentColor"
                                            d="M 44.898438 14.5 C 44.5 12.300781 42.601563 10.699219 40.398438 10.199219 C 37.101563 9.5 31 9 24.398438 9 C 17.800781 9 11.601563 9.5 8.300781 10.199219 C 6.101563 10.699219 4.199219 12.199219 3.800781 14.5 C 3.398438 17 3 20.5 3 25 C 3 29.5 3.398438 33 3.898438 35.5 C 4.300781 37.699219 6.199219 39.300781 8.398438 39.800781 C 11.898438 40.5 17.898438 41 24.5 41 C 31.101563 41 37.101563 40.5 40.601563 39.800781 C 42.800781 39.300781 44.699219 37.800781 45.101563 35.5 C 45.5 33 46 29.398438 46.101563 25 C 45.898438 20.5 45.398438 17 44.898438 14.5 Z M 19 32 L 19 18 L 31.199219 25 Z" />
                                    </svg>
                                </a>
                            @endif


                            @if (isset($restaurant->linkedin_url) && $restaurant->linkedin_url != null)
                                <a href="{{ $restaurant->linkedin_url }}" target="_blank"
                                    class="flex items-center justify-center w-9 h-9 rounded-full text-white bg-neutral/50 hover:bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="22px"
                                        height="22px">
                                        <path fill="currentColor"
                                            d="M 8 3.0097656 C 4.53 3.0097656 2.0097656 5.0892187 2.0097656 7.9492188 C 2.0097656 10.819219 4.59 12.990234 8 12.990234 C 11.47 12.990234 13.990234 10.870625 13.990234 7.890625 C 13.830234 5.020625 11.36 3.0097656 8 3.0097656 z M 3 15 C 2.45 15 2 15.45 2 16 L 2 45 C 2 45.55 2.45 46 3 46 L 13 46 C 13.55 46 14 45.55 14 45 L 14 16 C 14 15.45 13.55 15 13 15 L 3 15 z M 18 15 C 17.45 15 17 15.45 17 16 L 17 45 C 17 45.55 17.45 46 18 46 L 27 46 C 27.552 46 28 45.552 28 45 L 28 30 L 28 29.75 L 28 29.5 C 28 27.13 29.820625 25.199531 32.140625 25.019531 C 32.260625 24.999531 32.38 25 32.5 25 C 32.62 25 32.739375 24.999531 32.859375 25.019531 C 35.179375 25.199531 37 27.13 37 29.5 L 37 45 C 37 45.552 37.448 46 38 46 L 47 46 C 47.55 46 48 45.55 48 45 L 48 28 C 48 21.53 44.529063 15 36.789062 15 C 33.269062 15 30.61 16.360234 29 17.490234 L 29 16 C 29 15.45 28.55 15 28 15 L 18 15 z" />
                                    </svg>
                                </a>
                            @endif

                            @if (isset($restaurant->instagram_url))
                                <a href="{{ $restaurant->instagram_url }}" target="_blank"
                                    class="flex items-center justify-center w-9 h-9 rounded-full text-white bg-neutral/50 hover:bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="22px"
                                        height="22px">
                                        <path fill="currentColor"
                                            d="M 16 3 C 8.83 3 3 8.83 3 16 L 3 34 C 3 41.17 8.83 47 16 47 L 34 47 C 41.17 47 47 41.17 47 34 L 47 16 C 47 8.83 41.17 3 34 3 L 16 3 z M 37 11 C 38.1 11 39 11.9 39 13 C 39 14.1 38.1 15 37 15 C 35.9 15 35 14.1 35 13 C 35 11.9 35.9 11 37 11 z M 25 14 C 31.07 14 36 18.93 36 25 C 36 31.07 31.07 36 25 36 C 18.93 36 14 31.07 14 25 C 14 18.93 18.93 14 25 14 z M 25 16 C 20.04 16 16 20.04 16 25 C 16 29.96 20.04 34 25 34 C 29.96 34 34 29.96 34 25 C 34 20.04 29.96 16 25 16 z" />
                                    </svg>
                                </a>
                            @endif

                            @if (isset($restaurant->tiktok_url))
                                <a href="{{ $restaurant->tiktok_url }}" target="_blank"
                                   class="flex items-center justify-center w-9 h-9 rounded-full text-white bg-neutral/50 hover:bg-primary">
                                    <svg fill="#000000" width="22px"
                                         height="22px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xml:space="preserve">
                                        <path fill="currentColor" d="M19.589 6.686a4.793 4.793 0 0 1-3.77-4.245V2h-3.445v13.672a2.896 2.896 0 0 1-5.201 1.743l-.002-.001.002.001a2.895 2.895 0 0 1 3.183-4.51v-3.5a6.329 6.329 0 0 0-5.394 10.692 6.33 6.33 0 0 0 10.857-4.424V8.687a8.182 8.182 0 0 0 4.773 1.526V6.79a4.831 4.831 0 0 1-1.003-.104z"/></svg>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/cdns/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    @include('frontend.chatbot')

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/notification.init.js') }}"></script>
    <script>
        @if (session()->has('Success'))
            alertify.success('{{ session('Success') }}');
        @endif

        @if (session()->has('Error'))
            alertify.error('{{ session('Error') }}');
        @endif

        var themeRoute = "{{ route('theme.mode') }}";
        $(".mobile_search").click(function() {
            $(".mobile_input").toggleClass("open_search");
        });
        $(document).on("change", '#day-night', function() {
            var is_ligth_mode = $(this).prop('checked');
            var theme = "-";
            if (is_ligth_mode) {
                $(document).find('.dark').removeClass('dark');
            } else {
                $(document).find('body>div').addClass('dark');
                theme = 'dark'
            }
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", themeRoute);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("f_theme=" + theme);
        })
        $(document).on("click", '#direction', function() {
            var body = $(document).find('body')
            if (body.attr('dir') == 'rtl') {
                body.attr('dir', 'ltr')
            } else {
                body.attr('dir', 'rtl')
            }
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", themeRoute);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("f_dir=" + body.attr('dir'));
        })
        $(document).on("click", '#language>button', function(e) {

            var droDown = $(document).find('#language .language_list')
            if (droDown.css('display') == 'none') {
                droDown.css('display', 'block');
            } else {
                droDown.css('display', 'none');
            }

            return false;
        })
        $(document).on("click", '#language', function(e) {

            return false;
        })
        $(document).on("click", function(e) {
            var droDown = $(document).find('#language .language_list')

            if (droDown.css('display') != 'none') {
                droDown.css('display', 'none');
            }
        })
        $(document).on('click', '.view_more', function() {
            id = $(this).data('id');
            modal_popup(id)
        })

        $(document).on('click', '.dismiss_modal', function() {
            document.getElementById('staticModal').classList.toggle('hidden')
        })
        $(window).scroll(function() {
            if ($(window).scrollTop() >= 1) {
                $("header").addClass("header-scroll");
            } else {
                $("header").removeClass("header-scroll");
            }
        });

        @if (isset($vendor_setting->allow_show_food_details_popup) && $vendor_setting->allow_show_food_details_popup == true)
            function modal_popup(id) {
                var url = '{{ route('restaurant.food', '#0#') }}';
                url = url.replace('#0#', id);
                // alert(url);
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    // dataType: "json",
                    success: function(data) {
                        $(document).find('.modal-details').html(data);
                        var swiper = new Swiper(".mySwiper", {
                            loop: false,
                            spaceBetween: 10,
                            slidesPerView: 4,
                            direction: "vertical",
                            freeMode: true,
                            watchSlidesProgress: true,
                        });
                        var swiper2 = new Swiper(".mySwiper2", {
                            loop: false,
                            spaceBetween: 0,
                            thumbs: {
                                swiper: swiper,
                            },
                        });
                        $("#myModal").toggleClass("show");
                        if ($('body').attr('dir') == 'rtl') {
                            $(document).find('.modal-details .close-model').removeClass('right-2')
                            $(document).find('.modal-details .close-model').addClass('left-2')
                        }
                        $('body').css('overflow', 'hidden')
                    },
                    error: function() {
                        alert('{{ __('system.messages.food_not_found') }}')
                        // window.location.reload();
                    }
                })

            }

            //

            $(document).on('click', '.popup-slider', function() {
                var id = ($(this).data('id'))
                modal_popup(id)
            });

            $(document).on('click', '.close-model', function() {
                $("#myModal").toggleClass("show");
                $('body').removeAttr('style')
            })
        @endif

        function notificationToggleHandler() {
            var body = $('body');
            var thisSelector = $('#call_the_waiter_modal');
            if (thisSelector.hasClass('hidden')) {
                thisSelector.removeClass('hidden');
                body.addClass('overflow-hidden');
            } else {
                thisSelector.addClass('hidden');
                body.removeClass('overflow-hidden');
            }

        }
    </script>
    <script>
        const menuButton = document.getElementById('menuButton');
        const menuDropdown = document.getElementById('menuDropdown');
        const arrowIcon = document.getElementById('arrowIcon');

        menuButton.addEventListener('click', () => {
            menuDropdown.classList.toggle('hidden'); // Toggle the visibility of the dropdown

            // Toggle the arrow icon rotation (down/up)
            arrowIcon.classList.toggle('rotate-180');
        });

        // $(document).ready(function(){
        //     $(document).on('click', '#sidebarToggle', function(){
        //         $('#sidebar').css('transform', 'translateX(0)'); // Move sidebar into view
        //     });

        //     $(document).on('click', '#closeButton', function(){
        //         $('#sidebar').css('transform', 'translateX(-100%)'); // Move sidebar out of view
        //     });

        //     $('#closeButton').click().trigger('click');
        // });
        $(document).ready(function() {
            const bodyDir = $('body').attr('dir'); // Get the direction of the body (ltr or rtl)

       // فتح القائمة الجانبية
$('#sidebarToggle').on('click', function() {
    if (bodyDir === 'ltr') {
        $('#sidebar').css('transform', 'translateX(0)'); // لعرض القائمة من اليسار في LTR
    } else if (bodyDir === 'rtl') {
        $('#sidebar').css('transform', 'translateX(0)'); // لعرض القائمة من اليمين في RTL
    }
    $('#sidebarOverlay').removeClass('hidden'); // إظهار التراكب
});

// إغلاق القائمة الجانبية عند الضغط على زر الإغلاق أو التراكب
$('#closeButton, #sidebarOverlay').on('click', function() {
    if (bodyDir === 'ltr') {
        $('#sidebar').css('transform', 'translateX(-100%)'); // إخفاء القائمة في LTR
    } else if (bodyDir === 'rtl') {
        $('#sidebar').css('transform', 'translateX(100%)'); // إخفاء القائمة في RTL
    }
    $('#sidebarOverlay').addClass('hidden'); // إخفاء التراكب
});

// إغلاق القائمة الجانبية عند الضغط في أي مكان خارج القائمة
$(document).on('click', function(event) {
    if (!$(event.target).closest('#sidebar, #sidebarToggle').length) { // التحقق من أن النقر خارج القائمة أو زر الفتح
        if (bodyDir === 'ltr') {
            $('#sidebar').css('transform', 'translateX(-100%)'); // إخفاء القائمة في LTR
        } else if (bodyDir === 'rtl') {
            $('#sidebar').css('transform', 'translateX(100%)'); // إخفاء القائمة في RTL
        }
        $('#sidebarOverlay').addClass('hidden'); // إخفاء التراكب
    }
});




            $(document).on('click','.search-button', function(){
                $('.header-top').hide('slow');
                $('.header-search-top').show('slow');
            });
            $(document).on('click','.close-search', function(){
                $('.header-top').show('slow');
                $('.header-search-top').hide('slow');
            });


        });



    </script>
    @stack('page_js')

</body>

</html>
