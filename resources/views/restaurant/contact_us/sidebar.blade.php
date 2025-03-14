<div class="rightbar-title d-flex align-items-center bg-dark p-3">
    <h5 class="m-0 me-2 text-white">{{ __('system.dashboard.contact_us') }}</h5>
    <a href="javascript:void(0);" onclick="closeSidebar()" class="right-bar-toggle ms-auto">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
</div>

<!-- Settings -->
<hr class="m-0" />
<div class="p-3">
    <h6 class="mb-1">{{__('system.feedbacks.name')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $contact_data->name }}</p>

    <h6 class="mb-1">{{__('system.feedbacks.email')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $contact_data->email }}</p>

    <h6 class="mb-1">{{__('system.contact_us.message')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $contact_data->message }}</p>
</div>
