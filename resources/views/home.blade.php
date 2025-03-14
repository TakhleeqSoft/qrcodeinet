@extends('layouts.app')
@section('title', __('system.dashboard.menu'))
@section('content')

<div class="row">
        <div class="col-12">

            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('system.dashboard.menu') }}</h4>


            </div>
        </div>
    </div>
    <div class="row">

        @hasanyrole('vendor')
            {{-- vendor missing details on boarding --}}
            @php
                $show_vendor_boarding = false;
                if ($restaurants_count == 0 || $categories_count == 0 || $foods_count == 0 || empty(auth()->user()->email_verified_at) || empty(auth()->user()->address) || empty(auth()->user()->city) || empty(auth()->user()->zip) || empty(auth()->user()->country)) {
                    $show_vendor_boarding = true;
                }
            @endphp
            @if ($show_vendor_boarding)
                <div class="col-md-12">
                    <div class="card card-h-100 "style="background: #E4FFE4;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-4">{{ __('system.fields.setting_reconfigure') }}</h5>
                                    <div>
                                        @if ($restaurants_count == 0)
                                            <a class="d-block" href="{{ route('restaurant.restaurants.create') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.fields.atleast_one', ['name' => __('system.fields.restaurant')]) }}
                                                </h6>
                                            </a>
                                        @endif

                                        @if ($categories_count == 0)
                                            <a class="d-block" href="{{ route('restaurant.food_categories.create') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.fields.atleast_one', ['name' => __('system.food_categories.title')]) }}
                                                </h6>
                                            </a>
                                        @endif

                                        @if ($foods_count == 0)
                                            <a class="d-block" href="{{ route('restaurant.foods.create') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.fields.atleast_one', ['name' => __('system.foods.title')]) }}
                                                </h6>
                                            </a>
                                        @endif

                                        @if (empty(auth()->user()->email_verified_at))
                                            <a class="d-block" href="javascript:void(0)">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.fields.email_unverified') }}
                                                </h6>
                                            </a>
                                        @endif

                                        @if (empty(auth()->user()->address) ||
                                                empty(auth()->user()->city) ||
                                                empty(auth()->user()->zip) ||
                                                empty(auth()->user()->country))
                                            <a class="d-block" href="{{ route('restaurant.profile.edit') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.dashboard.missing_address') }}
                                                </h6>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endhasanyrole

        @hasanyrole('Super-Admin')
            {{-- vendor missing details on boarding --}}
            @php

                $show_admin_boarding = false;
                $show_smtp = false;
                $show_system = false;
                if (empty(config('mail.from.address')) || empty(config('mail.mailers.smtp.host')) || empty(config('mail.mailers.smtp.port')) || empty(config('mail.mailers.smtp.encryption')) || empty(config('mail.mailers.smtp.username')) || empty(config('mail.mailers.smtp.password'))) {
                    $show_admin_boarding = true;
                    $show_smtp = true;
                }

                if (empty(config('app.timezone')) || empty(config('app.date_time_format')) || empty(config('app.date_format')) || empty(config('app.currency')) || empty(config('app.currency_symbol')) || (empty(config('app.favicon_icon')) || config('app.favicon_icon') == '/assets/images/defualt_logo/ligth_sm_logo.png') || (empty(config('app.ligth_sm_logo')) || config('app.ligth_sm_logo') == '/assets/images/defualt_logo/ligth_sm_logo.png')) {
                    $show_admin_boarding = true;
                    $show_system = true;
                }

                if ($payment_setting_count == 0) {
                    $show_admin_boarding = true;
                }

            @endphp
            @if ($show_admin_boarding)
                <div class="col-md-12">
                    <div class="card card-h-100 "style="background: #E4FFE4;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-4">{{ __('system.fields.setting_reconfigure') }}</h5>
                                    <div>
                                        @if ($show_smtp)
                                            <a class="d-block" href="{{ route('restaurant.environment.setting.email') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.dashboard.missing_smpt') }}
                                                </h6>
                                            </a>
                                        @endif

                                        @if ($payment_setting_count == 0)
                                            <a class="d-block" href="{{ route('restaurant.environment.payment') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.dashboard.missing_payment_details') }}
                                                </h6>
                                            </a>
                                        @endif

                                        @if ($show_system)
                                            <a class="d-block" href="{{ route('restaurant.environment.setting') }}">
                                                <h6 class="fw-normal text-danger">
                                                    {{ __('system.dashboard.missing_system_details') }}
                                                </h6>
                                            </a>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endhasanyrole

        @can('')
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <a href="{{ route('restaurant.restaurants.index') }}">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <span
                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_restaurants') }}</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="{{ $restaurants_count ?? 0 }}">0</span>
                                    </h4>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endcan


        @hasanyrole('staff|vendor')
            @can('show category')
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <a href="{{ route('restaurant.food_categories.index') }}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_categories') }}</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="{{ $categories_count ?? 0 }}">0</span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            @can('show food')
                <div class="col-xl-3 col-md-6">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <a href="{{ route('restaurant.foods.index') }}">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_foods') }}</span>
                                        <h4 class="mb-3">
                                            <span class="counter-value" data-target="{{ $foods_count ?? 0 }}">0</span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan
        @endhasanyrole



        @hasanyrole('Super-Admin')
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <a href="{{ route('restaurant.vendors.index') }}">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <span
                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_vendors') }}</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="{{ $vendors_count ?? 0 }}">0</span>
                                    </h4>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <a href="{{ route('restaurant.subscriptions') }}">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <span
                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.pending_subscriptions') }}</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value" data-target="{{ $pending_subscriptions ?? 0 }}">0</span>
                                    </h4>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endhasanyrole

        @can('')
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        @hasanyrole('Super-Admin')
                        <a href="javascript:void(0)">
                            @else
                                <a href="{{ route('restaurant.staff.index') }}">
                                    @endhasanyrole

                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                    <span
                                        class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('system.dashboard.total_users') }}</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="{{ $users_count ?? 0 }}">0</span>
                                            </h4>
                                        </div>
                                    </div>
                                </a>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="row">
        @php($class = 'col-xl-6')
        @php($width = '250px')
        @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
            @php($class = 'col-xl-6')
            @php($width = '300px')
        @endif

        @can('show food')
            @if (isset($foods) && count($foods) > 0)
                <div class="{{ $class }}">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{ __('system.dashboard.recent_foods') }}</h4>
                        </div>
                        <div class="card-body px-0 pb-0 pt-2">
                            <div class="table-responsive px-3 h-455" data-simplebar="init">

                                <table class="table align-middle table-nowrap">
                                    <tbody>
                                        @forelse ($foods as $food)
                                            <tr>
                                                <td class="w-50px">
                                                    <div class="avatar-md me-4">

                                                        @if ($food->food_image_url != null)
                                                            <img data-src="{{ $food->food_image_url }}" alt=""
                                                                class="avatar-md rounded-circle me-2 image-object-cover lazyload">
                                                        @else
                                                        <?php $default_food_image = !isset($vendor_settings->default_food_image) ?  asset('assets/images/default_food.png') : getFileUrl($vendor_settings->default_food_image); ?>
                                                            <img data-src="{{ $default_food_image }}" alt="" class="avatar-md rounded-circle me-2 image-object-cover lazyload">
                                                        @endif
                                                    </div>
                                                </td>

                                                <td style="max-width:{{ $width }}">
                                                    <div>
                                                        <h5 class="font-size-15 text-truncate"><a
                                                                class="text-dark">{{ $food->local_lang_name }}</a></h5>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="text-end">

                                                        <span class="text-muted">{{ $food->created_at }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
                                                    {{ __('system.messages.not_found', ['model' => __('system.foods.title')]) }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            @endif
        @endcan

        @can('show category')
            @if (isset($categories) && count($categories) > 0)
                <div class="{{ $class }}">
                    <div class="card">

                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{ __('system.dashboard.recent_categories') }}</h4>

                        </div><!-- end card header -->

                        <div class="card-body px-0 pb-0 pt-2">
                            <div class="table-responsive px-3 h-455" data-simplebar="init">

                                <table class="table align-middle table-nowrap">
                                    <tbody>
                                        @forelse ($categories as $foodCategory)
                                            <tr>
                                                <td class="w-50px">
                                                    <div class="avatar-md me-4">

                                                        @if ($foodCategory->category_image_url != null)
                                                            <img data-src="{{ $foodCategory->category_image_url }}"
                                                                alt=""
                                                                class="avatar-md rounded-circle me-2 image-object-cover lazyload">
                                                        @else
                                                        <?php
                                                            $default_category_image = !isset($vendor_settings->default_category_image) ?  asset('assets/images/default_category.png') : getFileUrl($vendor_settings->default_category_image);
                                                        ?>

                                                            <img data-src="{{ $default_category_image }}" alt="" class="avatar-md rounded-circle me-2 image-object-cover lazyload">
                                                        @endif
                                                    </div>
                                                </td>

                                                <td style="max-width:{{ $width }}" class="">
                                                    <div class="text-dark">
                                                        <h5 class="font-size-15 text-truncate">
                                                            <a>{{ $foodCategory->local_lang_name }}</a>
                                                        </h5>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="text-end">

                                                        <span class="text-muted">{{ $foodCategory->created_at }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
                                                    {{ __('system.messages.not_found', ['model' => __('system.food_categories.title')]) }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <!-- end card body -->


                    </div>
                    <!-- end card -->
                </div>
            @endif
        @endcan

        @if (isset($restaurants) && count($restaurants) > 0)
            @if (auth()->user()->user_type == App\Models\User::USER_TYPE_ADMIN)
                <div class="col-xl-6">
                    <div class="card">

                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{ __('system.dashboard.recent_restaurants') }}</h4>

                        </div><!-- end card header -->

                        <div class="card-body px-0 pb-0 pt-2">
                            <div class="card-body px-0 pt-2">
                                <div class="table-responsive px-3 h-425px" data-simplebar>
                                    <table class="table align-middle table-nowrap">
                                        <tbody>
                                            @forelse ($restaurants  as $restaurant)
                                                <tr>
                                                    <td class="w-50px">
                                                        <div class="avatar-md me-4">

                                                            @if ($restaurant->logo_url != null)
                                                                <img data-src="{{ $restaurant->logo_url }}"
                                                                    alt=""
                                                                    class="avatar-md rounded-circle me-2 lazyload">
                                                            @else
                                                                <div class="avatar-md d-inline-block align-middle me-2">
                                                                    <div
                                                                        class="avatar-title bg-soft-primary text-primary font-size-18 m-0 rounded-circle font-weight-bold">
                                                                        {{ $restaurant->logo_name }}
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div>
                                                            <h5 class="font-size-15"><a
                                                                    class="text-dark">{{ $restaurant->name }}</a></h5>
                                                            <span
                                                                class="text-muted">{{ $restaurant->phone_number }}</span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-end">

                                                            <span class="text-muted">{{ $restaurant->created_at }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        {{ __('system.messages.not_found', ['model' => __('system.restaurants.title')]) }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- end card body -->


                    </div>
                    <!-- end card -->
                </div>
            @endif
        @endif

        @if (auth()->user()->user_type == 1)
            <div class="{{ $class }}">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('system.dashboard.pending_subscriptions') }}</h4>
                    </div><!-- end card header -->
                    <div class="card-body px-0 pb-0 pt-2">
                        <div class="table-responsive px-3 h-455" data-simplebar="init">

                            <table class="table align-middle table-nowrap">
                                <thead>
                                    <tr>
                                        <td>{{ trans('system.fields.name') }}</td>
                                        <td>{{ trans('system.plans.name') }}</td>
                                        <td>{{ trans('system.fields.amount') }}</td>
                                        <td>{{ trans('system.crud.action') }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($subscriptions as $subscription)
                                        <tr>
                                            <td style="max-width: 20px;">
                                                    <h5 class="font-size-15 text-truncate"><a
                                                            class="text-dark">{{ $subscription->user->name }}</a></h5>
                                                    <span
                                                        class="text-muted d-block text-truncate">{{ $subscription->user->email }}</span>
                                            </td>
                                            <td style="max-width: 20px;">
                                                <div class="">
                                                    <span class="text-muted">{{ $subscription->plan->title }}</span>
                                                </div>
                                            </td>
                                            <td style="max-width: 20px;">
                                                <div class="">
                                                    <span class="text-muted">{{ config('app.currency_symbol') }}{{ $subscription->amount }}</span>
                                                </div>
                                            </td>
                                            <td style="max-width: 20px;">
                                                <div class="d-flex">

                                                    {{ Form::open(['route' => ['restaurant.subscriptions.approve', ['subscription' => $subscription->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.plans.are_you_sure', ['name' => __('system.plans.approve')]), 'data-confirm-title' => __('system.plans.approve'), 'id' => 'approve_form_' . $subscription->id, 'method' => 'put']) }}
                                                    <button type="submit" class="btn btn-sm btn-success">{{trans('system.plans.approve')}}</button>
                                                    {{ Form::close() }}

                                                    {{ Form::open(['route' => ['restaurant.subscriptions.reject', ['subscription' => $subscription->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.plans.are_you_sure', ['name' => __('system.plans.reject')]), 'data-confirm-title' => __('system.plans.reject'), 'id' => 'reject_form_' . $subscription->id, 'method' => 'put']) }}
                                                    <button type="submit" class="btn btn-sm btn-danger"> {{trans('system.plans.reject')}}</button>
                                                    {{ Form::close() }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                {{ __('system.messages.not_found', ['model' => __('system.plans.subscriptions')]) }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        @endif
    </div>
@endsection
