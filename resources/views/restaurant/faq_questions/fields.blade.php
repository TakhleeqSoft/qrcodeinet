@csrf
<div>
    <section>

        <div class="row">
            <div class="row">
                <div class="col-lg-5 mb-2">
                    <div class="form-group">
                        <label class="text-label">{{ trans('system.faq.question') }}*</label>
                        <input data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.faq.question'))])}}" value="{{ old('question', $faqQuestion->question??'')}}" type="text" name="question" class="form-control" placeholder="{{ trans('system.faq.question') }}" required>
                    </div>
                </div>
                <div class="col-lg-5 mb-2">
                    <div class="form-group">
                        <label class="text-label">{{ trans('system.faq.answer') }}*</label>
                        <textarea data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.faq.answer'))])}}" rows="4" type="text" name="answer" class="form-control" placeholder="{{ trans('system.faq.answer') }}" required>{{ old('answer',$faqQuestion->answer??"") }}</textarea>
                    </div>
                </div>
            </div>
            @foreach (getAllCurrentRestaruentLanguages() as $key => $lang)
                <div class="row mt-5">
                    <div class="col-lg-5 mb-2">
                        @php($lbl_question = __('system.faq.question') . ' ' . $lang)

                        <div class="form-group @error('lang_question.' . $key) has-danger @enderror">
                            <label class="form-label" for="name">{{ $lbl_question }} <span class="text-danger">*</span></label>
                            {!! Form::text("lang_question[$key]", null, [
                                'class' => 'form-control',
                                'id' => 'name' . $key,
                                'autocomplete' => 'off',
                                'placeholder' => $lbl_question,
                                'required' => 'true',
                                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_question)]),
                                'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_question)]),
                            ]) !!}
                            @error('lang_question.' . $key)
                                <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-5 mb-2">
                        @php($lbl_answer = __('system.faq.answer') . ' ' . $lang)

                        <div class="form-group @error('lang_answer.' . $key) has-danger @enderror">
                            <label class="form-label" for="name">{{ $lbl_answer }} <span class="text-danger">*</span></label>
                            {!! Form::textarea("lang_answer[$key]", null, [
                                'class' => 'form-control',
                                'id' => 'name' . $key,
                                'autocomplete' => 'off',
                                'placeholder' => $lbl_answer,
                                'required' => 'true',
                                'rows' => 4,
                                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_answer)]),
                                'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_answer)]),
                            ]) !!}
                            @error('lang_answer.' . $key)
                                <div class="pristine-error text-help">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            @endforeach
    </section>
</div>

@once
    @push('page_css')
        <style>
            .ml-3 {
                margin-left: 10px;
            }
        </style>
    @endpush

    @push('page_scripts')
        <script>
            $(document).ready(function() {
                $('.isUnlimited').click(function() {
                    console.log('hello');
                    let setter = false;
                    if ($(this).is(':checked')) {
                        setter = true;
                    }
                    $($(this).data('target')).attr('readonly', setter);
                });

                $('.isUnlimited:checked').each(function(key, element) {
                    $($(element).data('target')).attr('readonly', true);
                });
            });
        </script>
    @endpush
@endonce
