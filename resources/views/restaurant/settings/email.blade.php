@php($languages_array = getAllLanguages(true))
@extends('layouts.app', ['languages_array' => $languages_array])
@section('title', __('system.environment.email'))
@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.environment.email') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.environment.email') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form autocomplete="off" novalidate="" action="{{ route('restaurant.environment.setting.email.update') }}" id="pristine-valid" method="post" enctype="multipart/form-data">
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
                                        <a class="nav-link active" href="{{ url('environment/setting/email') }}">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">{{ __('system.environment.email') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('environment/setting/payment') }}">
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
                                <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 ">
                                                    @php($lbl_app_smtp_from_address = __('system.fields.app_smtp_from_address'))
                                                    <div class="mb-3 form-group @error('app_smtp_from_address') has-danger @enderror">
                                                        <label class="form-label" for="app_smtp_from_address">{{ $lbl_app_smtp_from_address }} <span class="text-danger">*</span></label>
                                                        {!! Form::email('app_smtp_from_address', config('mail.from.address'), [
                                                            'class' => 'form-control  ',
                                                            'id' => 'app_smtp_from_address',
                                                            'placeholder' => $lbl_app_smtp_from_address,
                                                            'required' => 'true',
                                                            'maxlength' => 50,
                                                            'minlength' => 2,
                                                            'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_app_smtp_from_address)]),
                                                            'data-pristine-email-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_from_address)]),
                                                            'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_from_address)]),
                                                        ]) !!}
                                                        @error('app_smtp_from_address')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    @php($lbl_app_smtp_host = __('system.fields.app_smtp_host'))

                                                    <div class="mb-3 form-group @error('app_smtp_host') has-danger @enderror">
                                                        <label class="form-label" for="input-app_smtp_host">{{ $lbl_app_smtp_host }} <span class="text-danger">*</span></label>
                                                        {!! Form::text('app_smtp_host', config('mail.mailers.smtp.host'), [
                                                            'class' => 'form-control',
                                                            'id' => 'input-app_smtp_host',
                                                            'required' => 'true'
                                                        ]) !!}

                                                        @error('app_smtp_host')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    @php($lbl_app_smtp_port = __('system.fields.app_smtp_port'))

                                                    <div class="mb-3 form-group @error('app_smtp_port') has-danger @enderror">
                                                        <label class="form-label" for="input-app_smtp_port">{{ $lbl_app_smtp_port }} <span class="text-danger">*</span></label>
                                                        {!! Form::select('app_smtp_port', ['25' => 25, '465' => 465, '587' => 587, '2525' => 2525], config('mail.mailers.smtp.port'), [
                                                            'class' => 'form-control form-select',
                                                            'id' => 'input-app_smtp_port',
                                                            'required' => 'true',
                                                        ]) !!}

                                                        @error('app_smtp_port')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    @php($lbl_app_smtp_encryption = __('system.fields.app_smtp_encryption'))

                                                    <div class="mb-3 form-group @error('app_smtp_encryption') has-danger @enderror">
                                                        <label class="form-label" for="input-app_smtp_encryption">{{ $lbl_app_smtp_encryption }} <span class="text-danger">*</span></label>
                                                        {!! Form::select('app_smtp_encryption', ['ssl' => 'ssl', 'tls' => 'tls', 'STARTTLS' => 'STARTTLS'], config('mail.mailers.smtp.encryption'), [
                                                            'class' => 'form-control form-select',
                                                            'id' => 'input-app_smtp_encryption',
                                                            'required' => 'true',
                                                        ]) !!}

                                                        @error('app_smtp_encryption')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    @php($lbl_app_smtp_username = __('system.fields.app_smtp_username'))
                                                    <div class="mb-3 form-group @error('app_smtp_username') has-danger @enderror">
                                                        <label class="form-label" for="app_smtp_username">{{ $lbl_app_smtp_username }} <span class="text-danger">*</span></label>
                                                        {!! Form::text('app_smtp_username', config('mail.mailers.smtp.username'), [
                                                            'class' => 'form-control pristine-custom-pattern',
                                                            'id' => 'app_smtp_username',
                                                            'placeholder' => $lbl_app_smtp_username,
                                                            'required' => 'true',
                                                            'custom-pattern' => '^((?!\${.*}).)*$',
                                                            'maxlength' => 50,
                                                            'minlength' => 2,
                                                            'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_app_smtp_username)]),
                                                            'data-pristine-pattern-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_username)]),
                                                            'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_username)]),
                                                        ]) !!}
                                                        @error('app_smtp_username')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    @php($lbl_app_smtp_password = __('system.fields.app_smtp_password'))
                                                    <div class="mb-3 form-group @error('app_smtp_password') has-danger @enderror">
                                                        <label class="form-label" for="app_smtp_password">{{ $lbl_app_smtp_password }} <span class="text-danger">*</span></label>
                                                        <input class="form-control pristine-custom-pattern" id="app_smtp_password" placeholder="Password" required="true" minlength="2" custom-pattern='^((?!\${.*}).)*$' data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_app_smtp_password)]) }}" data-pristine-pattern-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_password)]) }}" data-pristine-minlength-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_smtp_password)]) }}" name="app_smtp_password" type="password" value="{{ config('mail.mailers.smtp.password') }}">
                                                        @error('app_smtp_username')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                        @enderror
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
