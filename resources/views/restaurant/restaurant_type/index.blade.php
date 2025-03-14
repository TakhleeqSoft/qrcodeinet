@extends('layouts.app')
@section('title', __('system.restaurant_type.title'))
@push('page_css')
    <style>
        .data-description {
            text-overflow: clip;
            max-height: 50px;
            min-height: 50px;
            overflow: hidden;
        }
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.restaurant_type.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.restaurant_type.menu') }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6 col-xl-6 text-end add-new-btn-parent">
                            <a href="{{ route('restaurant.restaurant-type.create') }}" class="btn btn-primary btn-rounded waves-effect waves-light"><i class="bx bx-plus me-1"></i>{{ __('system.crud.add_new') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ url('environment/setting') }}">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">{{ __('system.environment.application') }}
                                            {{ __('system.environment.title') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ url('environment/setting/email') }}">
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
                                    <a class="nav-link active" href="{{ route('restaurant.restaurant-type.index') }}">
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
                        </div>
                    </div>
                    <div class="mb-4 mt-4">
                        <div id="restaurants_list" class="dataTables_wrapper dt-bootstrap4 no-footer table_filter">
                            <div id="data-preview" class='overflow-hidden'>
                                @include('restaurant.restaurant_type.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
