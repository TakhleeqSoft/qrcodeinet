@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.payment'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.payment') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.payment') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form autocomplete="off" novalidate="" action="{{ route('restaurant.environment.payment.update') }}"
                    id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">


                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('environment/setting') }}">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.application') }}
                                                {{ __('system.environment.title') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/email') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.email') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ url('environment/setting/payment') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-credit-card"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.payment') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('restaurant.restaurant-type.index') }}">
                                            <span class="d-block d-sm-none"><i class="fas fa-utensils"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.restaurant_type.menu') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('restaurant.frontend.admin') }}">
                                            <span class="d-block d-sm-none"><i class="fa fa-globe"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.dashboard.frontend') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/seo') }}">
                                            <span class="d-block d-sm-none"><i class="fa fa-code"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.seo') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/analytics') }}">
                                            <span class="d-block d-sm-none"><i class="fa fa-code"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.analytics_code') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                @method('put')
                                @csrf
                                <input name="gateway_type" type="hidden" value="{{ request()->gateway ?? 'stripe' }}" />
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link  @if ((isset(request()->gateway) && request()->gateway == 'stripe') || request()->gateway == null) active @endif"
                                                            href="{{ url('environment/setting/payment?gateway=stripe') }}"
                                                            role="tab">
                                                            <span class="d-block d-sm-none"><i
                                                                    class="fas fa-home"></i></span>
                                                            <span
                                                                class="d-none d-sm-block">{{ __('system.payment_setting.stripe') }}</span>
                                                        </a>
                                                    </li>
{{--                                                    <li class="nav-item">--}}
{{--                                                        <a class="nav-link @if (isset(request()->gateway) && request()->gateway == 'paypal') active @endif"--}}
{{--                                                            href="{{ url('environment/setting/payment?gateway=paypal') }}"--}}
{{--                                                            role="tab">--}}
{{--                                                            <span class="d-block d-sm-none"><i--}}
{{--                                                                    class="far fa-user"></i></span>--}}
{{--                                                            <span--}}
{{--                                                                class="d-none d-sm-block">{{ __('system.payment_setting.paypal') }}</span>--}}
{{--                                                        </a>--}}
{{--                                                    </li>--}}
                                                    <li class="nav-item">
                                                        <a class="nav-link @if (isset(request()->gateway) && request()->gateway == 'offline') active @endif"
                                                            href="{{ url('environment/setting/payment?gateway=offline') }}"
                                                            role="tab">
                                                            <span class="d-block d-sm-none"><i
                                                                    class="fas fa-cog"></i></span>
                                                            <span
                                                                class="d-none d-sm-block">{{ __('system.payment_setting.offline') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <?php
                                                $stripe_payment_status = isset($stripe->stripe_status) ? $stripe->stripe_status : 'disable';
                                                $paypal_payment_status = isset($paypal->paypal_status) ? $paypal->paypal_status : 'disable';
                                                $offline_payment_status = isset($offline->offline_status) ? $offline->offline_status : 'disable';

                                                $stripe_payment_mode = isset($stripe->stripe_mode) ? $stripe->stripe_mode : 'test';
                                                $paypal_payment_mode = isset($paypal->paypal_mode) ? $paypal->paypal_mode : 'sandbox';
                                                ?>

                                                <!-- Tab panes -->
                                                <div class="tab-content p-3 text-muted">

                                                    @if (isset(request()->gateway) && request()->gateway == 'paypal')
                                                        <div class="tab-pane active" id="paypal_section" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleInputPassword1">{{ trans('system.payment_setting.client_id_key') }}</label>
                                                                        <input
                                                                            value="{{ isset($paypal->paypal_client_id) ? $paypal->paypal_client_id : '' }}"
                                                                            type="text" name="paypal_client_id"
                                                                            class="form-control" required
                                                                            placeholder="{{ trans('system.payment_setting.client_id_key') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mt-3">
                                                                        <label>{{ trans('system.payment_setting.client_secret_key') }}</label>
                                                                        <input
                                                                            value="{{ isset($paypal->paypal_secret_key) ? $paypal->paypal_secret_key : '' }}"
                                                                            type="text" name="paypal_secret_key"
                                                                            required class="form-control"
                                                                            placeholder="{{ trans('system.payment_setting.client_secret_key') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group mt-3">
                                                                        <label class="form-label"
                                                                            for="paypal_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                                                                        <select id="paypal_mode" name="paypal_mode"
                                                                            required class="form-control">
                                                                            <option
                                                                                {{ $paypal_payment_mode == 'sandbox' ? 'selected' : '' }}
                                                                                value="sandbox">
                                                                                {{ trans('system.payment_setting.sandbox') }}
                                                                            </option>
                                                                            <option
                                                                                {{ $paypal_payment_mode == 'live' ? 'selected' : '' }}
                                                                                value="live">
                                                                                {{ trans('system.payment_setting.production') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group mt-3">
                                                                        <label
                                                                            for="paypal_status">{{ trans('system.payment_setting.status') }}</label>
                                                                        <select id="paypal_status" name="paypal_status"
                                                                            required class="form-control">
                                                                            <option
                                                                                {{ $paypal_payment_status == 'enable' ? 'selected' : '' }}
                                                                                value="enable">
                                                                                {{ trans('system.payment_setting.enable') }}
                                                                            </option>
                                                                            <option
                                                                                {{ $paypal_payment_status == 'disable' ? 'selected' : '' }}
                                                                                value="disable">
                                                                                {{ trans('system.payment_setting.disable') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @elseif(isset(request()->gateway) && request()->gateway == 'offline')
                                                        <div class="tab-pane active" id="manual" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="instruction">{{ trans('system.payment_setting.instruction') }}*</label>
                                                                        <textarea required name="instructions" id="instruction" cols="30" class="form-control" rows="3">{!! isset($offline->instructions) ? $offline->instructions : '' !!}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="offline_status">{{ trans('system.payment_setting.status') }}</label>
                                                                        <select id="offline_status" name="offline_status"
                                                                            required class="form-control">
                                                                            <option {{ $offline_payment_status == 'enable' ? 'selected' : '' }} value="enable"> {{ trans('system.payment_setting.enable') }} </option>
                                                                            <option {{ $offline_payment_status == 'disable' ? 'selected' : '' }} value="disable"> {{ trans('system.payment_setting.disable') }} </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="tab-pane active" id="stripe_section" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="form-label">{{ __('system.payment_setting.publish_key') }}</label>
                                                                        <input
                                                                            value="{{ isset($stripe->stripe_publish_key) ? $stripe->stripe_publish_key : '' }}"
                                                                            type="text" name="stripe_publish_key"
                                                                            required class="form-control"
                                                                            placeholder="{{ trans('system.payment_setting.publish_key') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="form-label">{{ trans('system.payment_setting.secret_key') }}</label>
                                                                        <input
                                                                            value="{{ isset($stripe->stripe_secret_key) ? $stripe->stripe_secret_key : '' }}"
                                                                            type="text" name="stripe_secret_key"
                                                                            required class="form-control"
                                                                            placeholder="{{ trans('system.payment_setting.secret_key') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mt-3">
                                                                        <label class="form-label"
                                                                            for="stripe_mode">{{ trans('system.payment_setting.gateway_mode') }}</label>
                                                                        <select id="stripe_mode" name="stripe_mode"
                                                                            required class="form-control">
                                                                            <option
                                                                                {{ $stripe_payment_mode == 'test' ? 'selected' : '' }}
                                                                                value="test">
                                                                                {{ trans('system.payment_setting.test') }}
                                                                            </option>
                                                                            <option
                                                                                {{ $stripe_payment_mode == 'live' ? 'selected' : '' }}
                                                                                value="live">
                                                                                {{ trans('system.payment_setting.production') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group mt-3">
                                                                        <label class="form-label"
                                                                            for="stripe_status">{{ trans('system.payment_setting.status') }}</label>
                                                                        <select id="stripe_status" name="stripe_status"
                                                                            required class="form-control">
                                                                            <option
                                                                                {{ $stripe_payment_status == 'enable' ? 'selected' : '' }}
                                                                                value="enable">
                                                                                {{ trans('system.payment_setting.enable') }}
                                                                            </option>
                                                                            <option
                                                                                {{ $stripe_payment_status == 'disable' ? 'selected' : '' }}
                                                                                value="disable">
                                                                                {{ trans('system.payment_setting.disable') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer bg-transparent border-top text-muted">
                        <div class="row">
                            <div class="col-12 mt-1">
                                <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end card -->
            </div>
        </div>
    </div>
@endsection
