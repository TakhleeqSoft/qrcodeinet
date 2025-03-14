@extends('layouts.app')
@section('title', __('system.fields.view'))
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <h4 class="card-title">{{ __('system.vendors.menu') }}</h4>
                            <div class="page-title-box pb-0 d-sm-flex">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home') }}">{{ __('system.dashboard.menu') }}</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('restaurant.vendors.index') }}">{{ __('system.vendors.menu') }}</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('restaurant.vendors.show', ['vendor' => $vendor->id]) }}">{{ $vendor->first_name . ' ' . $vendor->last_name }}</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            <a
                                                href="{{ route('restaurant.vendors.subscriptionHistory', $vendor->id) }}">{{ __('system.plans.subscription_history') }}</a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-6 text-end">
                            <a href="{{ route('restaurant.vendors.show', $vendor->id) }}"
                                class="btn btn-primary waves-effect waves-light">{{ __('system.crud.back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div id="data-preview" class='overflow-hidden'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table
                                        class="table align-middle datatable dt-responsive table-check nowrap dataTable no-footer mt-0 table-bordered"
                                        id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('system.fields.name') }}</th>
                                                <th>{{ trans('system.plans.plan_name') }}</th>
                                                <th>{{ trans('system.plans.payment_method') }}</th>
                                                <th>{{ trans('system.plans.start_date') }}</th>
                                                <th>{{ trans('system.plans.expiry_date') }}</th>
                                                <th>{{ trans('system.plans.status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($subscriptions) && count($subscriptions) > 0)
                                                @foreach ($subscriptions as $subscription)
                                                    <tr class="app-cursor-pointer" data-url="{{ url('get-rightbar-content') }}"
                                                        data-id="{{ $subscription->id }}"
                                                        data-action="subscription-history"
                                                        onclick="show_rightbar_section(this)">
                                                        <td>
                                                            @if (isset($subscription->user))
                                                                {{ $subscription->user->first_name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($subscription->plan))
                                                                {{ $subscription->plan->title }}
                                                            @else
                                                                {{ __('system.plans.trial') }}
                                                            @endif
                                                        </td>

                                                        <td>{{ trans('system.payment_setting.' . $subscription->payment_method) }}
                                                        </td>

                                                        <td>{{ formatDate($subscription->start_date) }}</td>
                                                        @if ($subscription->expiry_date == '')
                                                            <td>{{ trans('system.plans.lifetime') }}</td>
                                                        @else
                                                            <td>{{ formatDate($subscription->expiry_date) }}</td>
                                                        @endif
                                                        <td>
                                                            @if ($subscription->status == 'approved')
                                                                <span
                                                                    class="badge bg-success font-size-12">{{ trans('system.plans.approved') }}</span>
                                                            @elseif($subscription->status == 'rejected')
                                                                <span
                                                                    class="badge bg-danger font-size-12">{{ trans('system.plans.rejected') }}</span>
                                                            @elseif($subscription->status == 'canceled')
                                                                <span
                                                                    class="badge bg-danger font-size-12">{{ trans('system.plans.canceled') }}</span>
                                                            @elseif($subscription->status == 'pending')
                                                                <span
                                                                    class="badge bg-secondary font-size-12">{{ trans('system.plans.pending') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        {{ __('system.crud.data_not_found', ['table' => __('system.plans.subscriptions')]) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
