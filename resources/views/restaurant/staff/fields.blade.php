@push('page_css')
    <style>
        .form-floating-custom>.form-control,
        .form-floating-custom>.form-select {
            padding: .47rem .75rem !important;
        }
    </style>
    <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
<div class="row">

    <div class="col-md-12  form-group">
        <div class="d-flex align-items-center">
            <div class='mx-3 '>
                @if (isset($user) && $user->profile_url != null)
                    <img data-src="{{ $user->profile_url }}" al" class="avatar-xl rounded-circle img-thumbnail preview-image lazyload">
                @else
                    <div class="preview-image-default">
                        <h1 class="rounded-circle font-size text-white d-inline-block text-bold bg-primary px-4 py-3 ">{{ $user->logo_name ?? 'U' }}</h1>
                    </div>
                    <img class="avatar-xl rounded-circle img-thumbnail preview-image" style="display: none;" />
                @endif

            </div>
            @php($lbl_profile_image = __('system.fields.profile_image'))
            <input type="file" name="profile_image" id="profile_image" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_profile_image)]) }}" data-preview='.preview-image'>
            <label for="profile_image" class="mb-0">
                <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                    {{ $lbl_profile_image }}
                </div>
            </label>
        </div>
        @error('profile_image')
            <div class="pristine-error text-help">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-4 ">
        @php($lbl_first_name = __('system.fields.first_name'))
        <div class="mb-3 form-group @error('first_name') has-danger @enderror">
            <label class="form-label" for="first_name">{{ $lbl_first_name }} <span class="text-danger">*</span></label>
            {!! Form::text('first_name', null, [
                'class' => 'form-control start_no_space',
                'id' => 'first_name',
                'placeholder' => $lbl_first_name,
                'required' => 'true',
                'maxlength' => 50,
                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_first_name)]),
                'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_first_name)]),
            ]) !!}
            @error('first_name')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        @php($lbl_last_name = __('system.fields.last_name'))
        <div class="mb-3 form-group @error('last_name') has-danger @enderror">
            <label class="form-label" for="last_name">{{ $lbl_last_name }} <span class="text-danger">*</span></label>

            {!! Form::text('last_name', null, [
                'class' => 'form-control start_no_space',
                'id' => 'last_name',
                'placeholder' => $lbl_last_name,
                'required' => 'true',
                'maxlength' => 50,
                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_last_name)]),
                'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_last_name)]),
            ]) !!}
            @error('last_name')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        @php($lbl_email = __('system.fields.email'))
        <div class="mb-3 form-group @error('email') has-danger @enderror">
            <label class="form-label" for="email">{{ $lbl_email }} <span class="text-danger">*</span></label>


            {!! Form::text('email', null, [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => $lbl_email,
                'required' => 'true',
                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower(__('system.fields.email'))]),
                'data-pristine-email-message' => __('validation.custom.invalid', ['attribute' => strtolower(__('system.fields.password'))]),
            ]) !!}
            @error('email')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @if (!isset($user))
        <div class="col-md-4">
            @php($lbl_password = __('system.fields.password'))

            <div class="mb-3 form-group @error('password') has-danger @enderror">

                <label class="form-label" for="pristine-password-valid">{{ $lbl_password }} <span class="text-danger">*</span></label>
                <div class="form-floating-custom auth-pass-inputgroup ">
                    <input type="password" name="password" id="pristine-password-valid" class="form-control"placeholder="{{ $lbl_password }}" required maxlength="16" data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_password)]) }}" data-pristine-password-message="{{ __('validation.password.invalid') }}">
                    <button type="button" class="btn btn-link  position-absolute h-100 end-0 top-0 py-1 px-3" id="password-addon">
                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                    </button>
                </div>
                @error('password')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>

        </div>
    @endif
    <div class="col-md-4">
        @php($lbl_phone_number = __('system.fields.phone_number'))
        <div class="mb-3 form-group @error('phone_number') has-danger @enderror">
            <label class="form-label" for="pristine-phone-valid">{{ $lbl_phone_number }} <span class="text-danger">*</span></label>
            {!! Form::tel('phone_number', null, [
                'class' => 'form-control',
                'id' => 'pristine-phone-valid',
                'placeholder' => $lbl_phone_number,
                'required' => 'true',
                'onkeypress' => 'return NumberValidate(event)',
                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_phone_number)]),
            ]) !!}
            @error('phone_number')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="choices-multiple-default" class="form-label font-size-13 text-muted">{{ __('system.restaurants.menu') }}</label>
            <select required class="form-control choice-picker-multiple" data-trigger name="restaurants[]" id="restaurants" placeholder="This is a placeholder" multiple>
                @if (isset($restaurants) && count($restaurants) > 0)
                    @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" @if (in_array($restaurant->id, old('restaurants') ?? $staffRestaurant)) selected @endif>{{ $restaurant->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{ __('system.fields.permission') }}
            </div>
            <div class="card-body">
                @include('restaurant.staff.permission')
            </div>
        </div>
    </div>
</div>
