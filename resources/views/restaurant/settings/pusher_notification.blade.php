@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.pusher_setting'))
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
                            <h4 class="card-title">{{ __('system.environment.pusher_setting') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.pusher_setting') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form autocomplete="off" novalidate="" action="{{ route('restaurant.vendor.pusher.update') }}"
                      id="pristine-valid" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ url('vendor/setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.display') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ url('vendor/pusher-setting') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
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
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        {{ __('system.environment.pusher_setting') }}
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 mb-2">
                                                                <div class="form-group">
                                                                    <label class="text-label">{{ trans('system.environment.pusher_appid') }}</label>
                                                                    <input value="{{ old('pusher_appid',$pusher_data->pusher_appid??'')}}" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.environment.pusher_appid'))])}}" required type="text" name="pusher_appid" class="form-control" placeholder="{{ trans('system.environment.pusher_appid') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mb-2">
                                                                <div class="form-group">
                                                                    <label class="text-label">{{ trans('system.environment.pusher_key') }}</label>
                                                                    <input value="{{ old('pusher_key',$pusher_data->pusher_key??'')}}"  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.environment.pusher_key'))])}}" required type="text" name="pusher_key" class="form-control" placeholder="{{ trans('system.environment.pusher_key') }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 mb-2">
                                                                <div class="form-group">
                                                                    <label class="text-label">{{ trans('system.environment.pusher_secret') }}</label>
                                                                    <input value="{{ old('pusher_secret',$pusher_data->pusher_secret??'')}}"  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.environment.pusher_secret'))])}}" required type="text" name="pusher_secret" class="form-control" placeholder="{{ trans('system.environment.pusher_secret') }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 mb-2">
                                                                <div class="form-group">
                                                                    <label class="text-label">{{ trans('system.environment.pusher_cluster') }}</label>
                                                                    <input value="{{ old('pusher_cluster',$pusher_data->pusher_cluster??'')}}" data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.environment.pusher_cluster'))])}}" required type="text" name="pusher_cluster" class="form-control" placeholder="{{ trans('system.environment.pusher_cluster') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                       {{ __('system.environment.setup_pusher') }}
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 mb-2">
                                                                <ul>
                                                                    <li>
                                                                        <p class="mb-1">Login to <a href="https://dashboard.pusher.com" target="_blank">https://dashboard.pusher.com</a></p>
                                                                        <small>"If you do not currently possess an account, you will need to establish a new one."</small>
                                                                    </li>
                                                                    <li>
                                                                        <p class="mt-2">Following your login, please navigate to <a href="https://dashboard.pusher.com/channels" target="_blank">https://dashboard.pusher.com/channels</a>.</p>
                                                                    </li>
                                                                    <li>
                                                                        <p>Afterward, select the <b>Create app</b> button to generate app keys. <br/>Once you've provided the necessary information, the system will redirect you to the app settings page.</p>
                                                                    </li>

                                                                    <li>
                                                                        <p>Afterward, select the <b>App keys</b> tab to unveil details about app settings.</p>
                                                                    </li>
                                                                </ul>
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
