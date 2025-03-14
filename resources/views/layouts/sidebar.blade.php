<input type="hidden" id="vendor_staff_current_restro" value="@if(auth()->user()->restaurant_id!=null){{auth()->user()->restaurant_id}}@else{{0}}@endif" />


<ul class="metismenu list-unstyled" id="side-menu">
    @hasanyrole('staff|vendor')
    @if (auth()->user()->restaurant != null)
        <li class="mb-3">
            <a href="javascript: void(0);" @if(isset($restaurants) && count($restaurants)>1) class="has-arrow" @endif>
                <span><i class="fas fa-hotel font-size-16"></i> {{ auth()->user()->restaurant->name }}</span>
            </a>
            @if(isset($restaurants) && count($restaurants)>0)
                <ul class="sub-menu" aria-expanded="false">
                    @foreach ($restaurants as $restaurant)
                        @if (auth()->user()->restaurant_id != $restaurant->id)
                            <li><a class="m-2 pl-2" style="border: 1px solid #dddddf;border-radius:5px;color: #fff" onclick="event.preventDefault(); document.getElementById('restaurant_default_restaurant{{ $restaurant->id }}').submit();" href="javascript:void(0)" data-key="t-g-maps"><i class="fas fa-hotel font-size-16"></i> {{ $restaurant->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
    @endhasanyrole

    <li>
        <a href="{{ route('home') }}" class="{{ Request::is('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span data-key="t-dashboard">{{ __('system.dashboard.menu') }}</span>
        </a>
    </li>
    @can('list owners')
        <li>
            <a href="{{ route('restaurant.vendors.index') }}" class="{{ Request::is('restaurant/vendors*') ? 'active' : '' }}">
                <i class="fas fa-users font-size-18"></i>
                <span data-key="t-{{ __('system.vendors.menu') }}">{{ __('system.vendors.menu') }}</span>
            </a>
        </li>
    @endcan

    @can('')
        <li>
            <a href="{{ route('restaurant.restaurants.index') }}" class="{{ Request::is('restaurant/restaurants*') ? 'active' : '' }}">
                <i class="fas fa-utensils font-size-18"></i>
                <span data-key="t-{{ __('system.restaurants.menu') }}">{{ __('system.restaurants.menu') }}</span>
            </a>
        </li>
    @endcan

    @hasanyrole('staff|vendor')

        @can('')
            <li>
                <a href="{{ route('restaurant.staff.index') }}" class="{{ Request::is('restaurant/staff*') ? 'active' : '' }}">
                    <i class="fas fa-users font-size-18"></i>
                    <span data-key="t-{{ __('system.staffs.title') }}">{{ __('system.staffs.title') }}</span>
                </a>
            </li>
        @endcan

        @can('show category')
            <li>
                <a href="{{ route('restaurant.food_categories.index') }}">
                    <i class="fas fa-list-alt font-size-18"></i>
                    <span data-key="t-{{ __('system.food_categories.menu') }}">{{ __('system.food_categories.menu') }}</span>
                </a>
            </li>
        @endcan

        @can('show food')
            <li>
                <a href="{{ route('restaurant.foods.index') }}">
                    <i class="fas fa-hamburger font-size-18"></i>
                    <span data-key="t-{{ __('system.foods.menu') }}">{{ __('system.foods.menu') }}</span>
                </a>
            </li>
        @endcan
        <li>
            <a href="{{ route('restaurant.vendor.feedback') }}">
                <i class="fas fa-comment-alt font-size-18"></i>
                <span data-key="t-{{ __('custom.feedback') }}">{{ __('custom.feedback') }}</span>
            </a>
        </li>
        @can('')
            @if (auth()->user()->restaurant != null)
                <li>
                    <a href="{{ route('restaurant.create.QR') }}">
                        <i class="fas fa-qrcode font-size-18"></i>
                        <span data-key="t-{{ __('system.qr_code.menu') }}">{{ __('system.qr_code.menu') }}</span>
                    </a>
                </li>
            @endif
        @endcan

        @can('')
            @if (auth()->user()->restaurant != null)
                <li>
                    <a href="{{ route('restaurant.themes.index') }}">
                        <i class="fas fa-paint-roller font-size-18"></i>
                        <span data-key="t-{{ __('system.themes.menu') }}">{{ __('system.themes.menu') }}</span>
                    </a>
                </li>
            @endif
        @endcan

        @can('')
            <li>
                <a href="{{ route('restaurant.tables.index') }}">
                    <i class="fas fa-table font-size-18"></i>
                    <span data-key="t-{{ __('system.dashboard.table') }}">{{ __('system.dashboard.table') }}</span>
                </a>
            </li>
        @endcan

        @can('')
        <li>
            <a href="{{ route('restaurant.call-waiter.index') }}">
                <i class="fas fas fa-hand-paper font-size-18"></i>
                <span data-key="t-{{ __('system.dashboard.call_waiter') }}">{{ __('system.dashboard.call_waiter') }}</span>
            </a>
        </li>
        @endcan

    @endhasanyrole

    @role('vendor')
        @if (auth()->user()->free_forever == false)
            <li class="@if(in_array(request()->path(),array('vendor/plan'))) mm-active @endif">
                <a  href="{{ route('restaurant.vendor.subscription') }}">
                    <i class="fas fa-gift font-size-18"></i>
                    <span data-key="t-{{ __('system.plans.menu') }}">{{ __('system.plans.subscription') }}</span>
                </a>
            </li>
        @endif

        @can('')
            <li>
                <a href="{{ route('restaurant.feedbacks.index') }}">
                    <i class="fas fa-comments font-size-18"></i>
                    <span data-key="t-{{ __('system.feedbacks.menu') }}">{{ __('system.feedbacks.menu') }}</span>
                </a>
            </li>
        @endcan
        <li>
            <a href="{{ route('restaurant.vendor.setting') }}">
                <i class="fas fa-cog font-size-18"></i>
                <span data-key="t-{{ __('system.vendor.setting') }}">{{ __('system.environment.menu') }}</span>
            </a>
        </li>
        @can('')
        <li>
            <a href="{{ route('restaurant.vendor.support') }}">
                <i class="fas fa-hands-helping font-size-18"></i>
                <span data-key="t-{{ __('system.fields.support') }}">{{ __('system.fields.support') }}</span>
            </a>
        </li>
 @endcan
    @endrole


    @hasanyrole('Super-Admin')
        <li>
            <a href="{{ route('restaurant.plans.index') }}">
                <i class="fas fa-gift font-size-18"></i>
                <span data-key="t-{{ __('system.plans.menu') }}">{{ __('system.plans.menu') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('restaurant.subscriptions') }}">
                <i class="fas fa-credit-card font-size-18"></i>
                <span data-key="t-{{ __('system.plans.subscriptions') }}">{{ __('system.plans.subscriptions') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('restaurant.report') }}">
                <i class="fas fa-layer-group font-size-18"></i>
                <span data-key="t-{{ __('system.dashboard.report') }}">{{ __('system.dashboard.report') }}</span>
            </a>
        </li>



        <li>
            <a href="{{ route('restaurant.testimonials.index') }}">
                <i class="fas fa-quote-left font-size-18"></i>
                <span data-key="t-{{ __('system.testimonial.menu') }}">{{ __('system.testimonial.menu') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('restaurant.faqs.index') }}">
                <i class="fas fa-question font-size-18"></i>
                <span data-key="t-{{ __('system.faq.menu') }}">{{ __('system.faq.menu') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('restaurant.cms-page.index') }}">
                <i class="fas fa-pager font-size-18"></i>
                <span data-key="t-{{ __('system.cms.menu') }}">{{ __('system.cms.menu') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('restaurant.contact-request.index') }}">
                <i class="fas fa-envelope font-size-18"></i>
                <span data-key="t-{{ __('system.contact_us.menu') }}">{{ __('system.contact_us.menu') }}</span>
            </a>
        </li>


        <li>
            <a href="{{ route('restaurant.languages.index') }}">
                <i class="fas  fa-language font-size-18"></i>
                <span data-key="t-{{ __('system.languages.menu') }}">{{ __('system.languages.menu') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('restaurant.environment.setting') }}">
                <i class="fas fa-cog font-size-18"></i>
                <span data-key="t-{{ __('system.environment.menu') }}">{{ __('system.environment.menu') }}</span>
            </a>
        </li>
    @endhasanyrole

    <li>
        <a onclick="event.preventDefault(); document.getElementById('logout-form').click();" href="javacript:void(0)">
            <i class="fas fa-power-off font-size-18"></i>
            <form autocomplete="off" action="{{ route('logout') }}" method="POST" class="d-none data-confirm" data-confirm-message="{{ __('system.fields.logout') }}" data-confirm-title=" {{ __('auth.sign_out') }}">
                <button id="logout-form" type="submit"></button>
                @csrf
            </form>
            <span data-key="t-{{ __('auth.sign_out') }}">{{ __('auth.sign_out') }}</span>
        </a>
    </li>
</ul>
