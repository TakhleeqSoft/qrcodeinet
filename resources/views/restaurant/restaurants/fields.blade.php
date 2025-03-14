<style>
    [type=radio]:checked+.select-theme {
        border: 2px solid #34c38f !important;
    }
</style>
@if (session()->has('errors'))
    <ul>
        @foreach (session()->get('errors')->toarray() as $key => $one)
            <li class="text-danger"><b>{{ __('system.fields.' . $key) }} : </b> {{ current($one) }}</li>
        @endforeach
    </ul>
@endif
<div id="basic-pills-wizard" class="twitter-bs-wizard">

    <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
        <li class="nav-item">
            <a href="#seller-details" class="nav-link active" data-toggle="tab">
                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ __('system.fields.restaurant_details') }}">
                    <i class="bx bx-list-ul"></i>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a href="#company-document1" class="nav-link  " data-toggle="tab" style="pointer-events: none;">
                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ __('system.fields.restaurant_image') }}">
                    <i class='bx bx-images'></i>
                </div>
            </a>
        </li>

        <li class="nav-item">
            <a href="#setting" class="nav-link  " data-toggle="tab" style="pointer-events: none;">
                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ __('system.fields.restaurant_setting') }}">
                    <i class='bx bxs-cog'></i>
                </div>
            </a>
        </li>

        <li class="nav-item">
            <a href="#bank-detail" class="nav-link  " data-toggle="tab" style="pointer-events: none;">
                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ __('system.fields.restaurant_default_theme') }}">
                    <i class='bx bxs-layout'></i>
                </div>
            </a>
        </li>
    </ul>
    <!-- wizard-nav -->

    <div class="tab-content twitter-bs-wizard-tab-content">
        <div class="tab-pane active" id="seller-details" data-validate="someFunction">

            <div class="card">
                <div class="card-header">
                    <div class="text-left">
                        <h5>{{ __('system.fields.restaurant_details') }}</h5>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        @hasanyrole('Super-Admin')
                            <div class="col-md-4">
                                @php($lbl_user_id = __('system.vendors.title'))

                                <div class="mb-3 form-group @error('user_id') has-danger @enderror">
                                    <label class="form-label" for="user_id">{{ $lbl_user_id }}</label>

                                    {{ Form::select('user_id', ['' => __('system.vendors.select_vendor')] + App\Http\Controllers\Restaurant\RestaurantController::getVendors(), null, [
                                        'class' => 'form-control form-select',
                                        'required' => 'true',
                                        'id' => 'user_id',
                                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_user_id)]),
                                    ]) }}
                                    @error('user_id')
                                        <div class="pristine-error text-help">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        @else
                            <input type="hidden" name="user_id" id="user_id" value="{{ $vendors->id }}" />
                        @endhasanyrole

                        <div class="col-md-4">
                            @php($lbl_restaurant_name = __('system.fields.restaurant_name'))

                            <div class="mb-3 form-group @error('name') has-danger @enderror">
                                <label class="form-label" for="name">{{ $lbl_restaurant_name }} <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, [
                                    'class' => 'form-control',
                                    'id' => 'name',
                                    'placeholder' => $lbl_restaurant_name,
                                    'required' => 'true',
                                    'maxlength' => 255,
                                    'minlength' => 2,
                                    'onkeypress' => 'createSlug(this)',
                                    'onblur' => 'createSlug(this)',
                                    'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_restaurant_name)]),
                                    'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_restaurant_name)]),
                                ]) !!}
                                @error('name')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            @php($lbl_restaurant_type = __('system.fields.restaurant_type'))
                            <div class="mb-3 form-group @error('type') has-danger @enderror">
                                <label class="form-label" for="restaurant">{{ $lbl_restaurant_type }} <span class="text-danger">*</span></label>
                                <select class="form-control" id="restaurant_type" name="type" data-pristine-required-message="{{__('validation.custom.select_required', ['attribute' => strtolower($lbl_restaurant_type)])}}" required>
                                    <option value="">{{$lbl_restaurant_type}}</option>
                                    @foreach($restaurantTypes as $rtype)
                                        <option @if(old('type',$restaurant->type??'')==$rtype->id) selected @endif value="{{$rtype->id}}">{{$rtype->local_name}}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            @php($lbl_contact_email = __('system.fields.contact_email'))


                            <div class="mb-3 form-group @error('contact_email') has-danger @enderror">
                                <label class="form-label" for="contact_email">{{ $lbl_contact_email }}</label>

                                {!! Form::email('contact_email', null, [
                                    'class' => 'form-control',
                                    'id' => 'contact_email',
                                    'placeholder' => $lbl_contact_email,
                                    'data-pristine-email-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_contact_email)]),
                                ]) !!}

                                @error('contact_email')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            @php($lbl_phone_number = __('system.fields.phone_number'))

                            <div class="mb-3 form-group @error('phone_number') has-danger @enderror">
                                <label class="form-label" for="pristine-phone-valid">{{ $lbl_phone_number }} <span class="text-danger">*</span></label>

                                {!! Form::text('phone_number', null, [
                                    'class' => 'form-control',
                                    'id' => 'pristine-phone-valid',
                                    'placeholder' => $lbl_phone_number,
                                    'required' => true,
                                    'onkeypress' => 'return NumberValidate(event)',
                                    'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_phone_number)]),
                                ]) !!}

                                @error('phone_number')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 form-group  @error('restaurant_slug') has-danger @enderror">
                                @php($lbl_restaurant_slug = __('system.fields.restaurant_slug'))
                                <label for="input-restaurant_slug">{{ $lbl_restaurant_slug }} <span class="text-danger">*</span></label>

                                {!! Form::text('slug', null, [
                                    'class' => 'form-control',
                                    'id' => 'input-restaurant_slug',
                                    'placeholder' => $lbl_restaurant_slug,
                                    'required' => true,
                                    'onkeypress' => 'createSlug(this)',
                                    'onblur' => 'createSlug(this)',
                                    'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_restaurant_slug)]),
                                ]) !!}
                            </div>
                            @error('slug')
                                <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>

                        @hasanyrole('staff|vendor')
                            @if (isset($create))
                                <div class="col-md-4">
                                    @php($lbl_clone_data_into = __('system.fields.clone_data_into'))

                                    <div class="mb-3 form-group @error('clone_data_into') has-danger @enderror">
                                        <label class="form-label" for="pristine-phone-valid">{{ $lbl_clone_data_into }}</label>

                                        {{ Form::select('clone_data_into', ['' => __('system.restaurants.select_restaurant')] + App\Http\Controllers\Restaurant\RestaurantController::getRestaurantsDropdown(), null, [
                                            'class' => 'form-control form-select',
                                            'id' => 'clone_data_into',
                                        ]) }}
                                        @error('clone_data_into')
                                            <div class="pristine-error text-help">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            @endif
                        @endhasanyrole
                    </div>
                    <div>
                        <div class="text-left mb-4 mt-4">
                            <h5>{{ __('system.fields.restaurant_address') }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                @php($lbl_address = __('system.fields.address'))

                                <div class="mb-3 form-group @error('address') has-danger @enderror">
                                    <label class="form-label" for="input-address">{{ $lbl_address }} <span class="text-danger">*</span></label>
                                    {!! Form::text('address', null, [
                                        'class' => 'form-control',
                                        'id' => 'input-address',
                                        'placeholder' => $lbl_address,
                                        'required' => true,
                                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_address)]),
                                        'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_address)]),
                                    ]) !!}
                                </div>
                                @error('address')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                @php($lbl_city = __('system.fields.city'))
                                <div class="mb-3 form-group @error('city') has-danger @enderror">
                                    <label class="form-label" for="input-city">{{ $lbl_city }} <span class="text-danger">*</span></label>
                                    {!! Form::text('city', null, [
                                        'class' => 'form-control',
                                        'id' => 'input-city',
                                        'placeholder' => $lbl_city,
                                        'required' => true,
                                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_city)]),
                                    ]) !!}

                                </div>
                                @error('city')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                @php($lbl_state = __('system.fields.state'))
                                <div class="mb-3 form-group @error('state') has-danger @enderror">
                                    <label class="form-label" for="input-state">{{ $lbl_state }} <span class="text-danger">*</span></label>
                                    {!! Form::text('state', null, [
                                        'class' => 'form-control',
                                        'id' => 'input-state',
                                        'placeholder' => $lbl_state,
                                        'required' => true,
                                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_state)]),
                                    ]) !!}
                                </div>
                                @error('state')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                @php($lbl_country = __('system.fields.country'))

                                <div class="mb-3 form-group @error('country') has-danger @enderror">
                                    <label class="form-label" for="input-country">{{ $lbl_country }} <span class="text-danger">*</span></label>
                                    {!! Form::text('country', null, [
                                        'class' => 'form-control',
                                        'id' => 'input-country',
                                        'placeholder' => $lbl_country,
                                        'required' => true,
                                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_country)]),
                                    ]) !!}

                                </div>
                                @error('country')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                @php($lbl_zip = __('system.fields.zip'))

                                <div class="mb-3 form-group @error('zip') has-danger @enderror">
                                    <label class="form-label" for="input-zip">{{ $lbl_zip }} <span class="text-danger">*</span></label>
                                    {!! Form::text('zip', null, [
                                        'class' => 'form-control pristine-custom-pattern',
                                        'id' => 'input-zip',
                                        'placeholder' => $lbl_zip,
                                        'custom-pattern' => "^[0-9a-zA-z]{4,8}$",
                                        'required' => true,
                                        'maxlength' => 8,
                                        'data-pristine-pattern-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_zip)]),
                                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_zip)]),
                                    ]) !!}
                                </div>
                                @error('zip')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <ul class="pager wizard twitter-bs-wizard-pager-link">
                <li class="previous "><a href="{{ request()->query->get('back', null) ?? route('restaurant.restaurants.index') }}" class="btn btn-secondary">{{ __('system.crud.cancel') }}</a></li>

                <li class="next">
                    <button class="btn btn-primary" type="button">{{ __('system.crud.next') }} <i class="bx bx-chevron-right ms-1"></i></button>
                </li>
            </ul>
        </div>
        <!-- tab pane -->
        <div class="tab-pane" id="company-document1">
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="text-left">
                            <h5>{{ __('system.fields.restaurant_image') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-stretch">
                            @php($lbl_logo = __('system.fields.app_light_logo'))
                            <div class="col-md-4 form-group ">
                                <label>{{ $lbl_logo }}</label>
                                <div class="d-flex  align-items-center ">
                                    <input type="file" name="logo" id="logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_logo)]) }}" data-preview='.preview-image'>
                                    <label for="logo" class="mb-0">
                                        <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                            {{ $lbl_logo }}
                                        </div>
                                    </label>
                                    <div class='mx-3 '>
                                        @if (isset($restaurant) && $restaurant->logo_url != null)
                                            <img src="{{ $restaurant->logo_url }}" alt="" class="avatar-xl rounded-circle img-thumbnail preview-image">
                                        @else
                                            <div class="preview-image-default">
                                                <h1 class="rounded-circle font-size text-white d-inline-block text-bold bg-primary px-4 py-3 ">{{ $restaurant->logo_name ?? 'R' }}</h1>
                                            </div>
                                            <img class="avatar-xl rounded-circle img-thumbnail preview-image" style="display: none;" />
                                        @endif
                                    </div>
                                </div>
                                @error('logo')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group ">
                                @php($lbl_logo_ligth = __('system.fields.app_dark_logo'))
                                <label>{{ $lbl_logo_ligth }}</label>
                                <div class="d-flex  align-items-center ">

                                    <input type="file" name="dark_logo" id="dark_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_logo_ligth)]) }}" data-preview='.preview-image1'>
                                    <label for="dark_logo" class="mb-0">
                                        <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                            {{ $lbl_logo_ligth }}
                                        </div>
                                    </label>
                                    <div class='mx-3 '>
                                        @if (isset($restaurant) && $restaurant->dark_logo_url != null)
                                            <img src="{{ $restaurant->dark_logo_url }}" alt="" class="avatar-xl rounded-circle img-thumbnail preview-image1 ">
                                        @else
                                            <img class="avatar-xl rounded-circle img-thumbnail preview-image1" style="display: none;" />
                                        @endif
                                    </div>
                                </div>
                                @error('dark_logo')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group ">

                                @php($lbl_cover_image = __('system.fields.cover_image'))
                                <label>{{ $lbl_cover_image }}</label>
                                <div class="d-flex  align-items-center  ">

                                    <input type="file" name="cover_image" id="cover_image" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_cover_image)]) }}" data-preview='.preview-cover_image-image'>
                                    <label for="cover_image" class="mb-0">
                                        <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                                            {{ $lbl_cover_image }}
                                        </div>
                                    </label>
                                    <div class='mx-3 '>
                                        <img class="avatar-xxl  preview-cover_image-image w-100" @if (isset($restaurant) && $restaurant->cover_image_url != null) src="{{ $restaurant->cover_image_url }}"
                                             @else style="display: none;" @endif />
                                    </div>
                                </div>
                                @error('cover_image')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="text-left">
                            <h5>{{ __('system.fields.social_media') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-stretch">
                            <div class="col-md-4">
                                @php($lbl_facebook_url = __('system.fields.facebook'))
                                <div class="mb-3 form-group @error('facebook_url') has-danger @enderror">
                                    <label class="form-label" for="facebook_url">{{ $lbl_facebook_url }}</label>
                                    {!! Form::text('facebook_url', null, [
                                        'class' => 'form-control',
                                        'id' => 'facebook_url',
                                        'placeholder' => $lbl_facebook_url,
                                        'required' => false,
                                    ]) !!}
                                </div>
                                @error('facebook_url')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                @php($lbl_instagram_url = __('system.fields.instagram'))
                                <div class="mb-3 form-group @error('instagram_url') has-danger @enderror">
                                    <label class="form-label" for="instagram_url">{{ $lbl_instagram_url }}</label>
                                    {!! Form::text('instagram_url', null, [
                                        'class' => 'form-control',
                                        'id' => 'instagram_url',
                                        'placeholder' => $lbl_instagram_url,
                                        'required' => false,
                                    ]) !!}
                                </div>
                                @error('instagram_url')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                @php($lbl_twitter_url = __('system.fields.twitter'))
                                <div class="mb-3 form-group @error('twitter_url') has-danger @enderror">
                                    <label class="form-label" for="twitter_url">{{ $lbl_twitter_url }}</label>
                                    {!! Form::text('twitter_url', null, [
                                        'class' => 'form-control',
                                        'id' => 'twitter_url',
                                        'placeholder' => $lbl_twitter_url,
                                        'required' => false,
                                    ]) !!}
                                </div>
                                @error('twitter_url')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                @php($lbl_youtube_url = __('system.fields.youtube'))
                                <div class="mb-3 form-group @error('youtube_url') has-danger @enderror">
                                    <label class="form-label" for="youtube_url">{{ $lbl_youtube_url }}</label>
                                    {!! Form::text('youtube_url', null, [
                                        'class' => 'form-control',
                                        'id' => 'youtube_url',
                                        'placeholder' => $lbl_youtube_url,
                                        'required' => false,
                                    ]) !!}
                                </div>
                                @error('youtube_url')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                @php($lbl_linkedin_url = __('system.fields.linkedin'))
                                <div class="mb-3 form-group @error('linkedin_url') has-danger @enderror">
                                    <label class="form-label" for="linkedin_url">{{ $lbl_linkedin_url }}</label>
                                    {!! Form::text('linkedin_url', null, [
                                        'class' => 'form-control',
                                        'id' => 'linkedin_url',
                                        'placeholder' => $lbl_linkedin_url,
                                        'required' => false,
                                    ]) !!}
                                </div>
                                @error('linkedin_url')
                                    <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                @php($lbl_tiktok_url = __('system.fields.tiktok'))
                                <div class="mb-3 form-group @error('tiktok_url') has-danger @enderror">
                                    <label class="form-label" for="tiktok_url">{{ $lbl_tiktok_url }}</label>
                                    {!! Form::text('tiktok_url', null, [
                                        'class' => 'form-control',
                                        'id' => 'tiktok_url',
                                        'placeholder' => $lbl_tiktok_url,
                                        'required' => false,
                                    ]) !!}
                                </div>
                                @error('tiktok_url')
                                <div class="pristine-error text-help">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <ul class="pager wizard twitter-bs-wizard-pager-link">
                    <li class="previous "><a href="javascript: void(0);" class="btn btn-primary" onclick=""><i class="bx bx-chevron-left me-1"></i> {{ __('system.crud.previous') }}</a> <a href="{{ request()->query->get('back', null) ?? route('restaurant.restaurants.index') }}" class="btn btn-secondary">{{ __('system.crud.cancel') }}</a></li>
                    <li class="next  " {!! $deactive ?? '' !!}>
                        <button class="btn btn-primary" type="button">{{ __('system.crud.next') }} <i class="bx bx-chevron-right ms-1"></i></button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- tab pane -->


        <div class="tab-pane" id="setting">
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="text-left">
                            <h5>{{ __('system.fields.restaurant_setting') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    @php($lbl_is_available = __('system.fields.display_language_text'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="display_language">{{ $lbl_is_available }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_language_change" value="0">
                                            {!! Form::checkbox('allow_language_change', 1, $setting->allow_language_change ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_language_change',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @php($dark_light_text = __('system.fields.dark_light_text'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="dark_light_change">{{ $dark_light_text }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_dark_light_mode_change" value="0">
                                            {!! Form::checkbox('allow_dark_light_mode_change', 1, $setting->allow_dark_light_mode_change ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_dark_light_mode_change',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @php($direction_text = __('system.fields.direction_text'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="direction_change">{{ $direction_text }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_direction" value="0">
                                            {!! Form::checkbox('allow_direction', 1, $setting->allow_direction ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_direction',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row mt-3">
                                <div class="col-md-4">
                                    @php($is_allergies_field_visible = __('system.fields.is_allergies_field_visible'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="is_allergies_field_visible">{{ $is_allergies_field_visible }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_show_allergies" value="0">
                                            {!! Form::checkbox('allow_show_allergies', 1, $setting->allow_show_allergies ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_show_allergies',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php($is_calories_field_visible = __('system.fields.is_calories_field_visible'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="is_calories_field_visible">{{ $is_calories_field_visible }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_show_calories" value="0">
                                            {!! Form::checkbox('allow_show_calories', 1, $setting->allow_show_calories ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_show_calories',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php($is_preparation_time_field_visible = __('system.fields.is_preparation_time_field_visible'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="is_preparation_time_field_visible">{{ $is_preparation_time_field_visible }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_show_preparation_time" value="0">
                                            {!! Form::checkbox('allow_show_preparation_time', 1, $setting->allow_show_preparation_time ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_show_preparation_time',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    @php($is_show_display_full_details_model = __('system.fields.is_show_display_full_details_model'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="is_show_display_full_details_model">{{ $is_show_display_full_details_model }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_show_food_details_popup" value="0">
                                            {!! Form::checkbox('allow_show_food_details_popup', 1, $setting->allow_show_food_details_popup ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_show_food_details_popup',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @php($display_banner_text = __('system.fields.display_banner_text'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="is_show_display_full_details_model">{{ $display_banner_text }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_show_banner" value="0">
                                            {!! Form::checkbox('allow_show_banner', 1, $setting->allow_show_banner ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_show_banner',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @php($display_restaurant_name = __('system.fields.display_restaurant_name'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="is_show_display_full_details_model">{{ $display_restaurant_name }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="allow_show_restaurant_name_address" value="0">
                                            {!! Form::checkbox('allow_show_restaurant_name_address', 1, $setting->allow_show_restaurant_name_address ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'allow_show_restaurant_name_address',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @php($call_the_waiter = __('system.fields.call_the_waiter'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="dark_light_change">{{ $call_the_waiter }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="call_the_waiter" value="0">
                                            {!! Form::checkbox('call_the_waiter', 1, $setting->call_the_waiter ?? 1, [
                                                'class' => 'form-check-input',
                                                'id' => 'call_the_waiter',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php($display_language_page = __('custom.language_page'))
                                    <div class="mt-4 mt-md-0">
                                        <label class="form-label" for="dark_light_change">{{ $display_language_page }}</label>
                                        <div class="form-check form-switch form-switch-md mb-3">
                                            <input type="hidden" name="display_language_page" value="0">
                                            {!! Form::checkbox('display_language_page', 1, $setting->display_language_page ?? 0, [
                                                'class' => 'form-check-input',
                                                'id' => 'display_language_page',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="pager wizard twitter-bs-wizard-pager-link">
                    <li class="previous ">
                        <a href="javascript: void(0);" class="btn btn-primary" onclick=""><i class="bx bx-chevron-left me-1"></i> {{ __('system.crud.previous') }}</a>
                    </li>
                    <li class="next">
                        <button class="btn btn-primary" type="button">{{ __('system.crud.next') }} <i class="bx bx-chevron-right ms-1"></i></button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-pane" id="bank-detail">
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="text-left">
                            <h5>{{ __('system.fields.restaurant_default_theme') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            @foreach (getAllThemes() as $theme)
                                <div class="col-xl-3 col-sm-6">
                                    <div class="card  ">
                                        <input type="radio" name="theme" value="{{ strtolower($theme['name']) }}" id="t{{ $theme['id'] }}" class="d-none" @checked(strtolower($theme['name']) == strtolower($restaurant->theme ?? 'theme1'))>
                                        <div class="border rounded-3 select-theme">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-md-6">
                                                        <label type="button" class="btn btn-sm btn-primary mb-md-3 select_lable" for="t{{ $theme['id'] }}">{{ __('system.crud.select') }}</label>
                                                    </div>
                                                    @if(isset($restaurant->id) && $restaurant->id>0)
                                                        <div class="col-md-6 text-end">
                                                            <a type="button" target="_blank" class="btn btn-sm btn-secondary mb-md-2" href="{{ route('restaurant.menu', ['restaurant' => $restaurant->id ?? 1, 'restaurant_view' => strtolower($theme['name'])]) }}">{{ __('system.crud.preview') }}</a>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row ">
                                                    <hr/>
                                                    <div class="col-md-12">
                                                        <img class="card-img img-fluid lazyload" data-src="{{ asset($theme['image']) }}" alt="Card image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <ul class="pager wizard twitter-bs-wizard-pager-link">
                    <li class="previous "><a href="javascript: void(0);" class="btn btn-primary" onclick=""><i class="bx bx-chevron-left me-1"></i> {{ __('system.crud.previous') }}</a> <a href="{{ request()->query->get('back', null) ?? route('restaurant.restaurants.index') }}" class="btn btn-secondary">{{ __('system.crud.cancel') }}</a></li>
                    <li class="float-end">
                        <button class="btn btn-primary" type="submit">{{ __('system.crud.save') }}</button>
                    </li>

                </ul>
            </div>
        </div>
        <!-- tab pane -->
    </div>
    <!-- end tab content -->
</div>

@push('page_scripts')
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script>
        var validEle = document.getElementById("pristine-valid");
        var validEle = new Pristine(validEle);
        $(document).ready(function() {
            var triggerTabList = [].slice.call(document.querySelectorAll(".twitter-bs-wizard-nav .nav-link"));
            var onload = 1;
            var wizard = $("#basic-pills-wizard").bootstrapWizard({
                tabClass: "nav nav-pills nav-justified",
                onNext: function(tab, navigation, index) {
                    if (!validEle.validate()) {
                        if ($(document).find('.tab-pane.active .has-danger').length != 0) {
                            $(document).find('.tab-pane.active .has-danger:first').focus();
                            tab.next().find('.nav-link').css('pointer-events', ' none')
                            return false;
                        } else {
                            tab.next().find('.nav-link').removeAttr('style')
                        }
                    } else {
                        $(document).find('.nav-link').removeAttr('style')
                    }


                },

                onTabShow: function(tab, navigation, index) {

                    setTimeout(function() {
                        if (!onload) {
                            validEle.reset();
                            onload = 0;
                        }
                    }, 10)
                }

            });
            triggerTabList.forEach(function(a) {
                var r = new bootstrap.Tab(a);
                a.addEventListener("click", function(a) {
                    a.preventDefault(), r.show()
                });
            });
        });
        var select = '{{ __('system.crud.select') }}';
        var selected = '{{ __('system.crud.selected') }}';
        $(document).on('change', '[type=radio]', function() {
            $('[type=radio] + .select-theme  label').html(select).addClass('btn-primary').removeClass('btn-success');
            $('[type=radio]:checked + .select-theme label').toggleClass('btn-primary btn-success').html(selected);
        })

        $(document).find('[type=radio]:checked').change();

        $(document).on('keypress', '.form-control', function() {
            $(document).find('.nav-item .nav-link.active').parents('.nav-item').nextAll().find('.nav-link').css('pointer-events', 'none')
        })
        $(document).on('change', '.form-select,.my-preview', function() {
            $(document).find('.nav-item .nav-link.active').parents('.nav-item').nextAll().find('.nav-link').css('pointer-events', 'none')
        })
        @if (!isset($create))
            $(document).find('.nav-item .nav-link.active').parents('.nav-item').nextAll().find('.nav-link').css('pointer-events', 'unset')
        @endif
        $("input[allow]").on('keydown', function(e) {
            var ptn = $(this).attr('allow');
            var alwkey = $(this).attr('allowkey');
            if (alwkey) {
                alwkey = alwkey.split(',')
            } else {
                alwkey = []
            }
            var val = $(this).val();
            var str = e.keyCode;
            var excpet = [
                8,
                9,
                13,
                16,
                16,
                17,
                17,
                18,
                18,
                19,
                20,
                27,
                32,
                33,
                34,
                35,
                36,
                37,
                38,
                39,
                40,
                44,
                45,
                46,
            ];
            var re = new RegExp(ptn, 'i');
            if (jQuery.inArray(str, excpet) == -1 && jQuery.inArray(str.toString(), alwkey) == -1 && !re.test(String.fromCharCode(str))) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endpush
