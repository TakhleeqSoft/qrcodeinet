@extends('layouts.app')
@section('title', __('system.plans.menu'))
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
                            <h4 class="card-title">{{ __('system.plans.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.menu') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            @if (isset($plans) && count($plans) > 0)
                                @foreach ($plans as $plan)
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card mb-xl-0">
                                            <div class="card-body">
                                                <div class="p-2">

                                                    @if ($current_plans == $plan->plan_id)
                                                        <div class="pricing-badge">
                                                            <span class="badge"> <i data-feather="check-circle"></i></span>
                                                        </div>
                                                    @endif

                                                    <h5 class="font-size-16">{{ $plan->title }}</h5>
                                                    <h1 class="mt-3">{{ displayCurrency($plan->amount) }} <span
                                                            class="text-muted font-size-16 fw-medium">/
                                                            {{ ucfirst($plan->type) }}</span></h1>
                                                    <div class="mt-4 pt-2 text-muted">

                                                        @if ($plan->restaurant_unlimited == 'yes')
                                                            <p class="mb-3 font-size-15"><i
                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_restaurants') }}
                                                            </p>
                                                        @else
                                                            <p class="mb-3 font-size-15"><i
                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->restaurant_limit }}</strong>
                                                                {{ trans('system.plans.restaurant_limit') }}</p>
                                                        @endif

                                                        @if ($plan->item_unlimited == 'yes')
                                                            <p class="mb-3 font-size-15"><i
                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_items') }}
                                                            </p>
                                                        @else
                                                            <p class="mb-3 font-size-15"><i
                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->item_limit }}</strong>
                                                                {{ trans('system.plans.item_limit') }}</p>
                                                        @endif

                                                        @if ($plan->staff_unlimited == 'yes')
                                                            <p class="mb-3 font-size-15"><i
                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_staff') }}
                                                            </p>
                                                        @else
                                                            <p class="mb-3 font-size-15"><i
                                                                    class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->staff_limit }}</strong>
                                                                {{ trans('system.plans.staff_limit') }}</p>
                                                        @endif

                                                        <p class="mb-3 font-size-15"><i
                                                                class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_support') }}
                                                        </p>
                                                    </div>

                                                    @if ($current_plans != $plan->plan_id)
                                                        <div class="mt-4 pt-2">
                                                            <a href="{{ url('vendor/plan/' . $plan->plan_id) }}"
                                                                class="btn btn-outline-primary w-100">{{ __('system.plans.choose_plan') }}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                @endforeach
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
