@extends('auth.layouts.app')
@section('title', __('auth.registration.main_title'))
@push('page_css')
    <link rel="stylesheet" href="{{ asset('assets/cdns/intlTelInput.css') }}" />
    <style>
        .form-floating.form-floating-custom .form-floating-icon {
            display: none;
        }

        .form-floating-custom>.form-control,
        .form-floating-custom>.form-select {
            padding-left: 12px !important;
        }

        .form-floating-custom>label {
            left: 0px !important;
        }
        .iti__flag {
            background-image: url("{{ asset('assets/cdns/flags.png') }}");
        }

        .iti--allow-dropdown{
            width: 100%;
        }
        .iti--allow-dropdown #pristine-phone-valid{
            height: 58px;
            color: #000000;
        }
    </style>

@endpush
@section('content')
    <div class="auth-content my-auto">
        <div class="text-center">
            <h5 class="mb-0">{{ __('auth.registration.main_title') }}</h5>
        </div>
        @if (session()->has('errors'))
            <ul>
                @foreach (session()->get('errors')->toarray() as $key => $one)
                    <li class="text-danger"><b>{{ __('system.fields.' . $key) }} : </b> {{ current($one) }}</li>
                @endforeach

            </ul>

        @endif
        <form autocomplete="off" class="mt-4 pt-2 pristine-valid" action="{{ route('register') }}" method="post" id="pristine-valid" novalidate>
            @csrf

            <div class="mb-3 form-group">
                <div class="form-floating form-floating-custom @error('first_name') has-danger @enderror">
                    @php($lbl_first_name = __('system.fields.first_name'))

                    <input type="text" class="form-control" id="input-first_name" placeholder="{{ $lbl_first_name }}" name="first_name" value="{{ old('first_name') }}" required maxlength="50" data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_first_name)]) }}" data-pristine-pattern-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_first_name)]) }}">
                    <label for="input-first_name">{{ $lbl_first_name }} <span class="text-danger">*</span></label>
                    <div class="form-floating-icon">
                        <i data-feather="users"></i>
                    </div>
                </div>
                @error('first_name')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-group">
                <div class="form-floating form-floating-custom @error('first_name') has-danger @enderror">
                    @php($lbl_last_name = __('system.fields.last_name'))

                    <input type="text" autocomplete="off" class="form-control" id="input-last_name" placeholder="{{ $lbl_last_name }}" name="last_name" value="{{ old('last_name') }}" required maxlength="50" data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_last_name)]) }}" data-pristine-pattern-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_last_name)]) }}">
                    <label for="input-last_name">{{ $lbl_last_name }} <span class="text-danger">*</span></label>
                    <div class="form-floating-icon">
                        <i data-feather="users"></i>
                    </div>
                </div>
                @error('last_name')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-group">
                <div class="form-floating w-100 form-floating-custom @error('phone_number') has-danger @enderror">
                    @php($lbl_phone_number = __('system.fields.phone_number'))
                    <input onkeypress="return NumberValidate(event);" type="tel" class="form-control" id="pristine-phone-valid" placeholder="{{ $lbl_phone_number }}" name="phone_number" value="{{ old('phone_number') }}" required data-pristine-phone-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_phone_number)]) }}" data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_phone_number)]) }}">
                </div>
                @error('phone_number')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-group">
                <div class="form-floating form-floating-custom @error('email') has-danger @enderror">
                    @php($lbl_email = __('system.fields.email'))

                    <input type="email" class="form-control" id="input-username" placeholder="{{ $lbl_email }}" name="email" value="{{ old('email') }}" required data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_email)]) }}" data-pristine-email-message="{{ __('validation.custom.invalid', ['attribute' => strtolower($lbl_email)]) }}">
                    <label for="input-username">{{ $lbl_email }} <span class="text-danger">*</span></label>
                    <div class="form-floating-icon">
                        <i data-feather="mail"></i>
                    </div>
                </div>
                @error('email')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-group">
                <div class="form-floating form-floating-custom auth-pass-inputgroup @error('password') has-danger @enderror pristine-password-valid">

                    @php($lbl_password = __('system.fields.password'))
                    <input type="password" class="form-control pe-5 " id="pristine-password-valid" name="password" placeholder="{{ $lbl_password }}" required maxlength="16" data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower($lbl_password)]) }}" data-pristine-password-message="{{ __('validation.password.invalid') }}">

                    <button type="button" class="btn btn-link  position-absolute h-100 end-0 top-0" id="password-addon">
                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                    </button>
                    <label for="pristine-password-valid">{{ $lbl_password }} <span class="text-danger">*</span></label>
                    <div class="form-floating-icon">
                        <i data-feather="lock"></i>
                    </div>
                </div>
                @error('password')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-check font-size-15  form-group">
                        <input class="form-control form-check-input p-2" type="checkbox" id="remember-check" name="terms" value="1" required data-pristine-required-message="{{ __('validation.accepted', ['attribute' => 'terms']) }}">
                        <label class="form-check-label font-size-13" for="remember-check">
                            &nbsp;&nbsp; {{ __('auth.registration.i_agree') }} <a target="_blank" href="{{ route('terms-and-condition') }}">{{ __('auth.registration.terms') }}</a>
                        </label>
                    </div>
                </div>

            </div>
            <div class="mb-3">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">{{ __('auth.register') }}</button>
            </div>
        </form>

        <div class="mt-5 text-center">
            <p class="text-muted mb-0">
                <a href="{{ route('login') }}" class="text-primary fw-semibold">{{ __('auth.registration.have_membership') }}</a>
            </p>
        </div>
    </div>
@endsection

@push('third_party_scripts')
    <script src="{{ asset('assets/cdns/intlTelInput.min.js') }}"></script>
    <script>
        var input = document.querySelector("#pristine-phone-valid");

        if (input) {
            iti = window.intlTelInput(input, {
                initialCountry: "auto",
                separateDialCode: true,
                formatOnDisplay: false,
                hiddenInput: "phone_number",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "us";
                        callback(countryCode);
                    });
                },

                utilsScript: "{{ asset('assets/js/utils.js') }}" // just for formatting/placeholders etc
            });
            $(input).on('blur', function() {
                var number = iti.getNumber();
                $(document).find("[name=phone_number]:last-child").val(number);
            })
        }
    </script>
@endpush
