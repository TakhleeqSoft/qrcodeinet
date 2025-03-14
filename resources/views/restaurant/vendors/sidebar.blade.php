<div class="rightbar-title d-flex align-items-center bg-dark p-3">
    <h5 class="m-0 me-2 text-white">{{ __('system.plans.subscription_history') }}</h5>
    <a href="javascript:void(0);" onclick="closeSidebar()" class="right-bar-toggle ms-auto">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
</div>

<!-- Settings -->
<hr class="m-0" />
<div class="p-3">

    @if (!empty($subscription->subscription_id))
        <h6 class="mb-1">{{ __('system.plans.subscription') . ' ' . __('system.crud.id') }}</h6>
        <p class="mt-1 mb-3 sidebar-setting">{{ $subscription->subscription_id }}</p>
    @endif

    @if (!empty($subscription->transaction_id))
        <h6 class="mb-1">{{ __('system.payment_setting.transaction_id') }}</h6>
        <p class="mt-1 mb-3 sidebar-setting">{{ $subscription->transaction_id }}</p>
    @endif

    <h6 class="mb-1">{{ __('system.plans.pay_plan_title') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">
        @if(isset($subscription->plan))
            {{ $subscription->plan->title }}
        @else
            {{ __('system.plans.trial') }}
        @endif
    </p>

    <h6 class="mb-1">{{ __('system.plans.type') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">
        @if(isset($subscription->plan))
            {{ $subscription->plan->type }}
        @else
            {{ __('system.plans.trial') }}
        @endif
    </p>

    <h6 class="mb-1">{{ __('system.plans.start_date') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ formatDate($subscription->start_date) }}</p>

    <h6 class="mb-1">{{ __('system.plans.expiry_date') }}</h6>
    @if (!empty($subscription->expiry_date))
        <p class="mt-1 mb-3 sidebar-setting">{{ formatDate($subscription->expiry_date) }}</p>
    @else
        <p class="mt-1 mb-3 sidebar-setting">{{ __('system.plans.lifetime') }}</p>
    @endif

    <h6 class="mb-1">{{ __('system.plans.total_cost') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ displayCurrency($subscription->amount) }}</p>

    <h6 class="mb-1">{{ trans('system.plans.payment_method') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ trans('system.payment_setting.' . $subscription->payment_method) }}</p>

    <h6 class="mb-1">{{ trans('system.payment_setting.status') }}</h6>
    @if (isset($subscription->status) && $subscription->status == 'canceled')
        <p class="mt-1 mb-3 sidebar-setting">{{ trans('system.plans.canceled') }}</p>
    @elseif (isset($subscription->status) && $subscription->status == 'approved')
        <p class="mt-1 mb-3 sidebar-setting">{{ trans('system.plans.approved') }}</p>
    @elseif (isset($subscription->status) && $subscription->status == 'rejected')
        <p class="mt-1 mb-3 sidebar-setting">{{ trans('system.plans.rejected') }}</p>
    @elseif (isset($subscription->status) && $subscription->status == 'canceled')
        <p class="mt-1 mb-3 sidebar-setting">{{ trans('system.plans.canceled') }}</p>
    @endif

    <h6 class="mb-1">{{ trans('system.plans.restaurant_limit') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">
        @if ($subscription->restaurant_unlimited == 'yes')
            {{ trans('system.plans.unlimited_restaurants') }}
        @else
            {{ $subscription->restaurant_limit }}
        @endif
    </p>

    <h6 class="mb-1">{{ trans('system.plans.item_limit') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">
        @if ($subscription->item_unlimited == 'yes')
            {{ trans('system.plans.unlimited_items') }}
        @else
            {{ $subscription->item_limit }}
        @endif
    </p>

    <h6 class="mb-1">{{ trans('system.plans.staff_limit') }}</h6>
    <p class="mt-1 mb-3 sidebar-setting">
        @if ($subscription->staff_unlimited == 'yes')
            {{ trans('system.plans.unlimited_staff') }}
        @else
            {{ $subscription->staff_limit }}
        @endif
    </p>


</div>
