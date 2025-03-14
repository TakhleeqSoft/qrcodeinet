<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 ">
                @php($lbl_app_name = __('system.fields.app_name'))
                <div class="mb-3 form-group @error('app_name') has-danger @enderror">
                    <label class="form-label" for="app_name">{{ $lbl_app_name }} <span class="text-danger">*</span></label>
                    {!! Form::text('app_name', config('app.name'), [
                        'class' => 'form-control',
                        'id' => 'app_name',
                        'placeholder' => $lbl_app_name,
                        'required' => 'true',
                        'maxlength' => 50,
                        'minlength' => 1,
                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_app_name)]),
                        'data-pristine-pattern-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_name)]),
                        'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_app_name)]),
                    ]) !!}
                    @error('app_name')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                @php($lbl_app_currency = __('system.fields.select_app_currency'))
                <div class="mb-3 form-group @error('app_currency') has-danger @enderror">
                    <label class="form-label" for="input-app_currency">{{ $lbl_app_currency }} <span class="text-danger">*</span></label>
                    {!! Form::select('app_currency', getAllCurrencies(), config('app.currency'), [
                        'class' => 'form-select choice-picker',
                        'id' => 'input-app_currency',
                        'data-remove_attr' => 'data-type',
                        'required' => 'true',
                    ]) !!}

                    @error('app_currency')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                @php($lbl_currency_position = __('system.fields.currency_position'))

                <div class="mb-3 form-group @error('currency_position') has-danger @enderror">
                    <label class="form-label" for="input-currency_position">{{ $lbl_currency_position }} <span class="text-danger">*</span></label>
                    {!! Form::select('currency_position', ['left' =>"left", 'right' =>"right"], config('app.currency_position'), [
                        'class' => 'form-control form-select',
                        'id' => 'input-currency_position',
                        'required' => 'true',
                    ]) !!}

                    @error('currency_position')
                        <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                @php($hide_restaurant_after_days = __('system.fields.hide_restaurant_after_days'))
                <div class="mb-3 form-group @error('hide_restaurant_after_days') has-danger @enderror">
                    <label class="form-label" for="facebook_url">{{ $hide_restaurant_after_days }}</label>
                    {!! Form::number('hide_restaurant_after_days', config('app.hide_restaurant_after_days'), [
                        'class' => 'form-control',
                        'id' => 'hide_restaurant_after_days',
                        'placeholder' => $hide_restaurant_after_days,
                        'required' => true,
                        'min' => 1,
                    ]) !!}
                </div>
                @error('hide_restaurant_after_days')
                <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 ">
                @php($lbl_support_email = __('system.fields.support_email'))
                <div class="mb-3 form-group @error('support_email') has-danger @enderror">
                    <label class="form-label" for="app_name">{{ $lbl_support_email }} <span class="text-danger">*</span></label>
                    {!! Form::email('support_email', config('app.support_email'), [
                        'class' => 'form-control',
                        'id' => 'support_email',
                        'placeholder' => $lbl_support_email,
                        'required' => 'true',
                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_support_email)])
                    ]) !!}
                    @error('support_email')
                        <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 ">
                @php($lbl_support_phone = __('system.fields.support_phone'))
                <div class="mb-3 form-group @error('support_phone') has-danger @enderror">
                    <label class="form-label" for="support_phone">{{ $lbl_support_phone }} <span class="text-danger">*</span></label>
                    {!! Form::text('support_phone', config('app.support_phone'), [
                        'class' => 'form-control',
                        'id' => 'support_phone',
                        'placeholder' => $lbl_support_phone,
                        'required' => 'true',
                        'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_support_phone)])
                    ]) !!}
                    @error('support_email')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('system.fields.app_date_time_settings') }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                @php($lbl_app_timezone = __('system.fields.app_timezone'))

                <div class="mb-3 form-group @error('app_timezone') has-danger @enderror">
                    <label class="form-label" for="input-app_timezone">{{ $lbl_app_timezone }} <span class="text-danger">*</span></label>
                    {!! Form::select('app_timezone', App\Http\Controllers\Restaurant\EnvSettingController::GetTimeZones(), config('app.timezone'), [
                        'class' => 'form-select choice-picker',
                        'id' => 'input-app_timezone',
                        'data-remove_attr' => 'data-type',
                        'required' => 'true',
                    ]) !!}

                    @error('app_timezone')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                @php($lbl_app_date_time_format = __('system.fields.app_date_time_format'))

                <div class="mb-3 form-group @error('app_date_time_format') has-danger @enderror">
                    <label class="form-label" for="input-app_date_time_format">{{ $lbl_app_date_time_format }} <span class="text-danger">*</span></label>
                    {!! Form::select('app_date_time_format', App\Http\Controllers\Restaurant\EnvSettingController::GetDateFormat(), config('app.date_time_format'), [
                        'class' => 'form-control form-select',
                        'id' => 'input-app_date_time_format',
                        'required' => 'true',
                    ]) !!}

                    @error('app_date_time_format')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                @php($lbl_app_defult_language = __('system.fields.select_app_defult_language'))
                <div class="mb-3 form-group @error('app_defult_language') has-danger @enderror">
                    <label class="form-label" for="input-app_defult_language">{{ $lbl_app_defult_language }} <span class="text-danger">*</span></label>
                    {!! Form::select('app_defult_language', $languages_array, config('app.app_locale'), [
                        'class' => 'form-control form-select',
                        'id' => 'input-app_defult_language',
                        'required' => 'true',
                    ]) !!}

                    @error('app_defult_language')
                    <div class="pristine-error text-help">{{ $message }}</div>
                    @enderror
                </div>
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
            <div class="col-md-3">
                @php($lbl_facebook_url = __('system.fields.facebook'))
                <div class="mb-3 form-group @error('facebook_url') has-danger @enderror">
                    <label class="form-label" for="facebook_url">{{ $lbl_facebook_url }}</label>
                    {!! Form::text('facebook_url', config('app.facebook_url'), [
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

            <div class="col-md-3">
                @php($lbl_instagram_url = __('system.fields.instagram'))
                <div class="mb-3 form-group @error('instagram_url') has-danger @enderror">
                    <label class="form-label" for="instagram_url">{{ $lbl_instagram_url }}</label>
                    {!! Form::text('instagram_url', config('app.instagram_url'), [
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

            <div class="col-md-3">
                @php($lbl_twitter_url = __('system.fields.twitter'))
                <div class="mb-3 form-group @error('twitter_url') has-danger @enderror">
                    <label class="form-label" for="twitter_url">{{ $lbl_twitter_url }}</label>
                    {!! Form::text('twitter_url', config('app.twitter_url'), [
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

            <div class="col-md-3">
                @php($lbl_youtube_url = __('system.fields.youtube'))
                <div class="mb-3 form-group @error('youtube_url') has-danger @enderror">
                    <label class="form-label" for="youtube_url">{{ $lbl_youtube_url }}</label>
                    {!! Form::text('youtube_url', config('app.youtube_url'), [
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

            <div class="col-md-3">
                @php($lbl_linkedin_url = __('system.fields.linkedin'))
                <div class="mb-3 form-group @error('linkedin_url') has-danger @enderror">
                    <label class="form-label" for="linkedin_url">{{ $lbl_linkedin_url }}</label>
                    {!! Form::text('linkedin_url', config('app.linkedin_url'), [
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
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ __('system.fields.media') }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 form-group">
                @php($lbl_app_dark_logo = __('system.fields.logo'))
                <label class="form-label d-block" for="app_name">{{ $lbl_app_dark_logo }} <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center ">
                    <div class='mx-3 '>
                        <img src="{{ asset(config('app.dark_sm_logo')) }}" alt="" class=" preview-image avater-120-contain">
                    </div>

                </div>
                <input type="file" name="app_dark_logo" id="app_dark_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_dark_logo)]) }}" data-preview='.preview-image'>
                <label for="app_dark_logo" class="mb-0">
                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                        <span class="d-none d-lg-inline">{{ $lbl_app_dark_logo }}</span>
                    </div>
                </label>
                @error('app_dark_logo')
                <div class="pristine-error text-help px-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                @php($lbl_app_light_logo = __('system.fields.app_dark_logo'))
                <label class="form-label d-block" for="app_name">{{ $lbl_app_light_logo }}</label>
                <div class="d-flex align-items-center ">
                    <div class='mx-3 '>
                        <img src="{{ asset(config('app.ligth_sm_logo')) }}" class=" preview-image_2 avater-120-contain">
                    </div>
                </div>
                <input type="file" name="app_light_logo" id="app_light_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_light_logo)]) }}" data-preview='.preview-image_2'>
                <label for="app_light_logo" class="mb-0">
                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                        <span class="d-none d-lg-inline"> {{ __('system.crud.select') }} {{ $lbl_app_light_logo }} </span>
                    </div>
                </label>
                @error('app_light_logo')
                <div class="pristine-error text-help px-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                @php($lbl_app_favicon_logo = __('system.fields.app_favicon_logo'))
                <label class="form-label d-block" for="app_name">{{ $lbl_app_favicon_logo }} <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center ">
                    <div class='mx-3 '>
                        <img src="{{ asset(config('app.favicon_icon')) }}" alt="" class="avatar-xl  preview-image_21 avater-120-contain">
                    </div>
                </div>
                <input type="file" name="app_favicon_logo" id="app_favicon_logo" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_app_favicon_logo)]) }}" data-preview='.preview-image_21'>
                <label for="app_favicon_logo" class="mb-0">
                    <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                        <span class="d-none d-lg-inline"> {{ $lbl_app_favicon_logo }} </span>
                    </div>
                </label>
                @error('app_favicon_logo')
                <div class="pristine-error text-help px-3">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>








