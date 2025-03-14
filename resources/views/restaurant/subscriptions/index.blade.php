@extends('layouts.app')
@section('title', __('system.plans.subscriptions'))
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
                            <h4 class="card-title">{{ __('system.plans.subscriptions') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.subscriptions') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">

                            <div class="col-md-12">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->action==null) active @endif" href="{{url('subscriptions')}}">
                                            <span class="d-block d-sm-none">{{ __('system.plans.pending') }}</span>
                                            <span class="d-none d-sm-block">{{ __('system.plans.pending') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->action=="approved") active @endif" href="{{url('subscriptions?action=approved')}}">
                                            <span class="d-block d-sm-none">{{ __('system.plans.approved') }}</span>
                                            <span class="d-none d-sm-block">{{ __('system.plans.approved') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->action=="rejected") active @endif"  href="{{url('subscriptions?action=rejected')}}">
                                            <span class="d-block d-sm-none">{{ __('system.plans.rejected') }}</span>
                                            <span class="d-none d-sm-block">{{ __('system.plans.rejected') }}</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active">
                                        @include('restaurant.subscriptions.table')
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
