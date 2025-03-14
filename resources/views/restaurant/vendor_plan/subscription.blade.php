@extends('layouts.app')
@section('title', __('system.plans.subscription'))
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
                            <h4 class="card-title">{{ __('system.plans.subscription') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item active">{{ __('system.plans.subscription') }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            @if((isset($current_plans->plan_id) && $current_plans->plan_id==0)||(isset($subscription)))
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('system.plans.summary') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-bordered">
                                                    <tbody>
                                                    @if(isset($current_plans->plan_id) && $current_plans->plan_id==0)
                                                        <tr>
                                                            <td><b>{{ trans('system.plans.pay_plan_title') }}</b>:</td>
                                                            <td>{{ trans('system.plans.trial') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>{{ trans('system.plans.expiry_date') }}</b>:</td>
                                                            <td>{{ formatDate($vendor->trial_expire_at) }}</td>
                                                        </tr>
                                                    @else
                                                        @if(isset($subscription))
                                                            <tr>
                                                                <td><b>{{ trans('system.plans.pay_plan_title') }}</b>:</td>
                                                                <td>{{ $subscription->title }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>{{ trans('system.plans.type') }}</b>:</td>
                                                                <td>{{ trans('system.plans.' . $subscription->type) }}</td>
                                                            </tr>

                                                            @if (isset($current_plans->start_date))
                                                                <tr>
                                                                    <td><b>{{ trans('system.plans.start_date') }}</b>: </td>
                                                                    <td>{{ formatDate($current_plans->start_date) }}</td>
                                                                </tr>
                                                            @endif

                                                            @if (isset($current_plans->expiry_date))
                                                                <tr>
                                                                    <td><b>{{ trans('system.plans.expiry_date') }}</b>: </td>
                                                                    <td>{{ formatDate($current_plans->expiry_date) }}</td>
                                                                </tr>
                                                            @endif

                                                            <tr>
                                                                <th><b>{{ trans('system.plans.total_cost') }}</b>:</th>
                                                                <th>{{ displayCurrency($subscription->amount) }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th><b>{{ trans('system.plans.payment_method') }}</b>:</th>
                                                                <th>{{ trans('system.payment_setting.' . $current_plans->payment_method) }}</th>
                                                            </tr>
                                                            @if (isset($current_plans->status) && $current_plans->status == 'canceled')
                                                                <tr>
                                                                    <td><b>{{ trans('system.payment_setting.status') }}</b>: </td>
                                                                    <td><span class="badge bg-danger">{{ trans('system.plans.canceled') }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    <tr>
                                                        <td><b>{{ trans('system.plans.restaurant_limit') }}</b>:</td>
                                                        <td>
                                                            @if ($current_plans->restaurant_unlimited == 'yes')
                                                                {{ trans('system.plans.unlimited_restaurants') }}
                                                            @else
                                                                {{ $current_plans->restaurant_limit }}
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>{{ trans('system.plans.item_limit') }}</b>:</td>
                                                        <td>
                                                            @if ($current_plans->item_unlimited == 'yes')
                                                                {{ trans('system.plans.unlimited_items') }}
                                                            @else
                                                                {{ $current_plans->item_limit }}
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>{{ trans('system.plans.staff_limit') }}</b>:</td>
                                                        <td>
                                                            @if ($current_plans->staff_unlimited == 'yes')
                                                                {{ trans('system.plans.unlimited_staff') }}
                                                            @else
                                                                {{ $current_plans->staff_limit }}
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end table-responsive -->
                                        </div>
                                        @if (isset($current_plans->subscription_id) && $current_plans->subscription_id != null)
                                            <div class="card-footer bg-transparent border-top text-muted">
                                                <div class="d-flex flex-wrap gap-2">
                                                    {{-- <a class="btn btn-primary" href="{{route('restaurant.vendor.subscription.manage', ['subscription' => $current_plans->id])}}"> {{ trans('system.plans.manage_subscription') }}</a>--}}
                                                    {{ Form::open(['route' => ['restaurant.vendor.subscription.cancel', ['subscription' => $current_plans->id]], 'autocomplete' => 'off', 'class' => 'data-confirm', 'data-confirm-message' => __('system.plans.cancel_subscription_title'), 'data-confirm-title' => __('system.plans.cancel_subscription'), 'id' => 'cancel-form_' . $current_plans->id, 'method' => 'post']) }}
                                                    <button type="submit" class="btn btn-danger">
                                                        {{ trans('system.plans.cancel_subscription') }}
                                                    </button>
                                                    {{ Form::close() }}

                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('system.plans.change_plan') }}</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        @if (isset($plans) && count($plans) > 0)
                                            <div class="accordion" id="accordionExample">
                                                @foreach ($plans as $key => $plan)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne{{ $plan->plan_id }}">
                                                            <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $plan->plan_id }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $plan->plan_id }}">
                                                                <div class="row w-100">
                                                                    <div class="col-md-6">
                                                                        @if (isset($current_plans->plan_id) && $current_plans->plan_id == $plan->plan_id)
                                                                            <i class="fa fa-check-circle"></i>
                                                                        @endif
                                                                        {{ $plan->title }}
                                                                    </div>
                                                                    <div class="col-md-6" style="text-align: right">
                                                                        {{ displayCurrency($plan->amount) }} /
                                                                        {{ ucfirst($plan->type) }}</span>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne{{ $plan->plan_id }}"
                                                            class="accordion-collapse collapse @if (isset($current_plans->plan_id) && $current_plans->plan_id == $plan->plan_id) show @endif"
                                                            aria-labelledby="headingOne{{ $plan->plan_id }}"
                                                            data-bs-parent="#accordionExample{{ $plan->plan_id }}">
                                                            <div class="accordion-body">
                                                                <div class="text-muted">

                                                                    @if ($plan->restaurant_unlimited == 'yes')
                                                                        <p class="mb-3 font-size-15"><i
                                                                                class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ trans('system.plans.unlimited_restaurants') }}
                                                                        </p>
                                                                    @else
                                                                        <p class="mb-3 font-size-15"><i
                                                                                class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i><strong>{{ $plan->restaurant_limit }}</strong>
                                                                            {{ trans('system.plans.restaurant_limit') }}
                                                                        </p>
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

                                                                @if (isset($current_plans->plan_id) && $current_plans->plan_id != $plan->plan_id)
                                                                    <div class="mt-4 pt-2">
                                                                        <a href="{{ url('vendor/plan/' . $plan->plan_id) }}"
                                                                            class="btn btn-outline-primary w-100">{{ __('system.plans.choose_plan') }}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div><!-- end accordion -->
                                        @else
                                            {{ __('system.crud.data_not_found', ['table' => __('system.plans.menu')]) }}
                                        @endif
                                    </div><!-- end card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
