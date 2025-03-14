@extends('frontend.landing_page.app')
@section('content')
    <div class="mb-5">
        <h1>{{ __('system.footer.contact_us') }}</h1>
        <h4>{{ __('system.footer.contact_description') }}</h4>
    </div>
    <form id="contactForm" action="{{ route('contactUs') }}" method="post">
        @csrf
        <!-- Name input -->
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('system.fields.name') }}</label>
            <input autocomplete="off" maxlength="50" class="form-control" id="name" name="name" type="text"
                data-rule-required="true" placeholder="{{ __('system.fields.name') }}"
                data-msg-required="{{ __('validation.required', ['attribute' => __('system.contact_us.name')]) }}"
                data-rule-minlength="3"
                data-msg-minlength="{{ __('validation.min.numeric', ['attribute' => __('system.fields.name'), 'min' => 3]) }}"
                 />
            @if ($errors->has('name'))
                <span class="text-danger custom-error">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <!-- Email address input -->
        <div class="mb-3">
            <label class="form-label" for="emailAddress">{{ __('system.fields.email') }}</label>
            <input autocomplete="off" maxlength="50" class="form-control" id="emailAddress" name="email" type="email"
                data-msg-required="{{ __('validation.required', ['attribute' => __('auth.email')]) }}"
                data-rule-required="true" data-rule-email="true"
                data-msg-email="{{ __('validation.email', ['attribute' => __('auth.email')]) }}"
                placeholder="{{ __('system.fields.email') }}" />
            @if ($errors->has('email'))
                <span class="text-danger custom-error">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <!-- Message input -->
        <div class="mb-3">
            <label class="form-label" for="message">{{ __('system.fields.message') }}</label>
            <textarea class="form-control" id="message" name="message" type="text"
                data-msg-required="{{ __('validation.required', ['attribute' => __('system.contact_us.message')]) }}" data-rule-required="true"
                data-rule-minlength="5"
                data-msg-minlength="{{ __('validation.min.numeric', ['attribute' => __('system.contact_us.message'), 'min' => 5]) }}"
                placeholder="{{ __('system.fields.message') }}" style="height: 10rem;" required></textarea>
            @if ($errors->has('message'))
                <span class="text-danger custom-error">{{ $errors->first('message') }}</span>
            @endif
        </div>

        <!-- Form submit button -->
        <div class="d-grid">
            <button class="btn btn-primary btn-lg" type="submit">{{ __('system.crud.submit') }}</button>
        </div>

    </form>
@endsection
@section('custom-js')
    <script>
        $('#contactForm').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            highlight: function(element) {
                $(element).addClass("error");
            },
            unhighlight: function(element) {
                $(element).removeClass("error");
            }
        });
    </script>
@endsection
