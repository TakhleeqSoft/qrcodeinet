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
                                        <li class="breadcrumb-item active">
                                            {{ $vendor->first_name . ' ' . $vendor->last_name }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row">
                            <!-- Profile Details -->
                            <div class="col-md-4">
                                <div class="card vendor_details_div_height">
                                    <div class="card-header">
                                        {{ __('system.profile.profile_details') }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.name') }}</b>:
                                                    {{ $vendor->first_name . ' ' . $vendor->last_name }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.email') }}</b>:
                                                    {{ $vendor->email }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.phone_number') }}</b>:
                                                    {{ $vendor->phone_number }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.member_since') }}</b>:
                                                    {{ $vendor->created_at }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.address') }}</b>:
                                                    {{ $vendor->address }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.city') }}</b>:
                                                    {{ $vendor->city }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.state') }}</b>:
                                                    {{ $vendor->state }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.fields.zip') }}</b>:
                                                    {{ $vendor->zip }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Details -->
                            @if($vendor->free_forever==false)
                                <div class="col-md-4">
                                    <div class="card vendor_details_div_height">
                                        <div class="card-header">
                                            {{ __('system.plans.subscriptions') }}
                                        </div>
                                        <div class="card-body">

                                            @if (isset($current_plans->payment_method) && $current_plans->payment_method != 'Trial')
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.title') }}</b>: @if (isset($plans->title))
                                                            {{ $plans->title }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.amount') }}</b>: @if (isset($plans->amount))
                                                            {{ displayCurrency($plans->amount) }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="font12"><b>{{ __('system.plans.recurring_type') }}</b>:
                                                        @if (isset($plans->type))
                                                            {{ __('system.plans.' . $plans->type) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.plans.payment_method') }}</b>: @if (isset($current_plans->payment_method))
                                                        {{ $current_plans->payment_method }}
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.plans.start_date') }}</b>: @if (isset($current_plans->start_date))
                                                        {{ formatDate($current_plans->start_date) }}
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="col-md-12">
                                                <p class="font12"><b>{{ __('system.plans.expiry_date') }}</b>: @if (isset($current_plans->expiry_date))
                                                        {{ formatDate($current_plans->expiry_date) }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-12">

                                            </div>

                                        </div>
                                        <div class="card-footer bg-transparent border-top text-muted">
                                            <a href="{{ route('restaurant.vendors.subscriptionHistory', $vendor->id) }}"
                                               class="btn btn-outline-primary">{{ __('system.plans.subscription_history') }}</a>
                                            <a href="{{ route('restaurant.vendors.paymentTransactions', $vendor->id) }}"
                                               class="btn btn-outline-primary">{{ __('system.payment_setting.payment_history') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Profile Details -->
                            <div class="col-md-4">
                                <div class="card vendor_details_div_height">
                                    <div class="card-header">
                                        {{ __('system.password.menu') }}
                                    </div>
                                    <div class="card-body">
                                        <form method="post" autocomplete="off" novalidate="" id="pristine-valid"
                                            action="{{ route('restaurant.vendors.password.update', ['vendor' => $vendor->id]) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <label>{{ __('system.fields.new_password') }}</label>
                                                        <input autocomplete="off" value="{{old('new_password')}}" id="new_password" required
                                                            name="new_password"
                                                            placeholder="{{ __('system.fields.new_password') }}"
                                                            minlength="8" class="form-control" />
                                                    </div>
                                                    @error('new_password')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mb-5">
                                                    <div class="form-group">
                                                        <label>{{ __('system.fields.confirm_password') }}</label>
                                                        <input autocomplete="off"
                                                               value="{{old('confirm_password')}}"
                                                               data-pristine-equals-message="{{ __('system.password.confirm_password_error') }}"
                                                            data-pristine-equals="#new_password" id="confirm_password"
                                                            required name="confirm_password"
                                                            placeholder="{{ __('system.fields.confirm_password') }}"
                                                            minlength="8" class="form-control" />
                                                    </div>
                                                    @error('confirm_password')
                                                        <div class="pristine-error text-help">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
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
