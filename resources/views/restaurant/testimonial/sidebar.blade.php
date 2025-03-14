<div class="rightbar-title d-flex align-items-center bg-dark p-3">
    <h5 class="m-0 me-2 text-white">{{ __('system.dashboard.testimonials') }}</h5>
    <a href="javascript:void(0);" onclick="closeSidebar()" class="right-bar-toggle ms-auto">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
</div>

<!-- Settings -->
<hr class="m-0" />
<div class="p-3">
    <h6 class="mb-1">{{__('system.testimonial.name')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $testimonial->name }}</p>

    <h6 class="mb-1">{{__('system.testimonial.description')}}</h6>
    <p class="mt-1 mb-3 sidebar-setting">{{ $testimonial->description }}</p>
</div>
