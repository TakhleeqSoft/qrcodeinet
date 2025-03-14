<div class="alert alert-warning" role="alert">
    <p class="pb-0 mb-0"><b>{{ __('auth.verify_email.title') }}</b> : {{ __('auth.verify_email.notice') }} <a href="#"
                                                                                         onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
            {{ __('auth.verify_email.another_req') }}
        </a>
    </p>
</div>

<form autocomplete="off" id="resend-form" action="{{ route('verification.resend') }}" method="POST"
      class="d-none">
    @csrf
</form>

@if (session('resent'))
    <div class="alert alert-success" role="alert">{{ __('auth.verify_email.success') }}</div>
@endif
