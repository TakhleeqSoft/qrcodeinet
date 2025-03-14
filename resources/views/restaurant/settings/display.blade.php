@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.menu'))
@push('page_css')
    <style>
        .currency-min-height{
            min-height: 316px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.display') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.display') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ route('restaurant.vendor.setting.update') }}"
                    id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ url('vendor/setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.display') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('vendor/pusher-setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.pusher_setting') }}</span>
                                        </a>
                                    </li>
                                    @if($setting->display_language_page == 1)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('vendor/setting/brand-setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">{{ __('custom.language_page') }}</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                @method('put')
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card">
                                                    @php($default_food_image = __('system.fields.default_food_image'))
                                                    <div class="card-header">{{ $default_food_image }}</div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            @php($default_food = !empty($vendorSetting->default_food_image) ? getFileUrl($vendorSetting->default_food_image) : asset('assets/images/default_food.png'))
                                                            <div class="d-flex align-items-center ">
                                                                <img src="{{ $default_food }}" alt=""
                                                                    class="avatar-xl  preview-image_21 avater-120-contain">
                                                            </div>
                                                            @error('default_food_image')
                                                                <div class="pristine-error text-help px-3">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top text-muted">
                                                        <input type="file" name="default_food_image"
                                                            id="default_food_image" class="d-none my-preview"
                                                            accept="image/*"
                                                            data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($default_food_image)]) }}"
                                                            data-preview='.preview-image_21'>
                                                        <label for="default_food_image" class="mb-0">
                                                            <div for="profile-image"
                                                                class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                                <span class="d-none d-lg-inline">
                                                                    {{ $default_food_image }}</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                @php($default_category_image = __('system.fields.default_category_image'))
                                                <div class="card">
                                                    <div class="card-header">{{ $default_category_image }}</div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center ">
                                                                @php($default_category = !empty($vendorSetting->default_category_image) ? getFileUrl($vendorSetting->default_category_image) : asset('assets/images/default_category.png'))
                                                                <img src="{{ $default_category }}" alt=""
                                                                    class="avatar-xl  preview-image_22 avater-120-contain">
                                                            </div>
                                                            @error('default_category_image')
                                                                <div class="pristine-error text-help px-3">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top text-muted">
                                                        <input type="file" name="default_category_image"
                                                            id="default_category_image" class="d-none my-preview"
                                                            accept="image/*"
                                                            data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($default_category_image)]) }}"
                                                            data-preview='.preview-image_22'>
                                                        <label for="default_category_image" class="mb-0">
                                                            <div for="profile-image"
                                                                class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                                                <span class="d-none d-lg-inline">
                                                                    {{ $default_category_image }}</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 ">
                                                <div class="card currency-min-height">
                                                    @php($default_food_image = __('system.fields.app_currency_settings'))
                                                    <div class="card-header">{{ $default_food_image }}</div>
                                                    <div class="card-body row">
                                                        <div class="col-md-6">
                                                            @php($lbl_app_currency = __('system.fields.select_app_currency'))
                                                            <div
                                                                class="mb-3 form-group @error('app_currency') has-danger @enderror">
                                                                <label class="form-label"
                                                                    for="input-default_currency">{{ $lbl_app_currency }} <span
                                                                        class="text-danger">*</span></label>
                                                                {!! Form::select('default_currency', getAllCurrencies(), config('vendor_setting')->default_currency, [
                                                                    'class' => 'form-select choice-picker',
                                                                    'id' => 'input-default_currency',
                                                                    'data-remove_attr' => 'data-type',
                                                                    'required' => 'true',
                                                                ]) !!}

                                                                @error('default_currency')
                                                                    <div class="pristine-error text-help">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @php($lbl_currency_position = __('system.fields.currency_position'))
                                                            <div
                                                                class="mb-3 form-group @error('currency_position') has-danger @enderror">
                                                                <label class="form-label"
                                                                    for="input-default_currency_position">{{ $lbl_currency_position }}
                                                                    <span class="text-danger">*</span></label>
                                                                {!! Form::select('default_currency_position', ['left' => 'left', 'right' => 'right'], config('vendor_setting')->default_currency_position, [
                                                                    'class' => 'form-control form-select',
                                                                    'id' => 'input-default_currency_position',
                                                                    'required' => 'true',
                                                                ]) !!}

                                                                @error('default_currency_position')
                                                                    <div class="pristine-error text-help">{{ $message }}
                                                                    </div>
                                                                @enderror
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
