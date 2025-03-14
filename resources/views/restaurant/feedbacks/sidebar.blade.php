<div class="rightbar-title d-flex align-items-center bg-dark p-3">
    <h5 class="m-0 me-2 text-white">{{ __('system.dashboard.feedbacks') }}</h5>
    <a href="javascript:void(0);" onclick="closeSidebar()" class="right-bar-toggle ms-auto">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
</div>

<!-- Settings -->
<hr class="m-0" />
<div class="p-3">
    <h6 class="mb-1">{{__('system.feedbacks.name')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $feedback->name }}</p>

    <h6 class="mb-1">{{__('system.feedbacks.email')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $feedback->email }}</p>

    <h6 class="mb-1">{{__('system.feedbacks.restaurant')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $feedback->restaurant->name }}</p>

    <h6 class="mb-1">{{__('system.feedbacks.message')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $feedback->message }}</p>
</div>
