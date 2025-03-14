@csrf
<div>
    <section>
        <div class="row mb-3">
            <div class="col-lg-3 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.restaurant_type.type') }}*</label>
                    <input value="{{ old('type') ? old('type') : (isset($restaurantType) ? $restaurantType->type : '') }}" type="text" name="type" class="form-control" required>
                </div>
            </div>
            @foreach (getAllCurrentRestaruentLanguages() as $key => $lang)
                <div class="col-lg-3 mb-2">
                    @php($lbl_restaurant_type = __('system.restaurant_type.type') . ' ' . $lang)

                    <div class="form-group @error('lang_restaurant_type.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">{{ $lbl_restaurant_type }} <span class="text-danger">*</span></label>
                        {!! Form::text("lang_restaurant_type[$key]", null, [
                            'class' => 'form-control',
                            'id' => 'name' . $key,
                            'autocomplete' => 'off',
                            'placeholder' => $lbl_restaurant_type,
                            'required' => 'true',
                            'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_restaurant_type)]),
                            'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_restaurant_type)]),
                        ]) !!}
                        @error('lang_restaurant_type.' . $key)
                            <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach
        </div>
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
