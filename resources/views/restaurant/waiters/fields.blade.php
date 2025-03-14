@csrf
<div>
    <section>
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.tables.name') }}*</label>
                    <input value="{{ old('name') ? old('name') : (isset($table) ? $table->name : '') }}" type="text" name="name" class="form-control" placeholder="{{ trans('system.tables.name') }}" required>
                </div>
            </div>
            @foreach (getAllCurrentRestaruentLanguages() as $key => $lang)
                <div class="col-lg-4 mb-2">
                    @php($lbl_table_name = __('system.tables.name') . ' ' . $lang)

                    <div class="form-group @error('lang_table_name.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">{{ $lbl_table_name }} <span class="text-danger">*</span></label>
                        {!! Form::text("lang_table_name[$key]", null, [
                            'class' => 'form-control',
                            'id' => 'name' . $key,
                            'autocomplete' => 'off',
                            'placeholder' => $lbl_table_name,
                            'required' => 'true',
                            'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_table_name)]),
                            'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_table_name)]),
                        ]) !!}
                        @error('lang_table_name.' . $key)
                            <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.tables.no_of_capacity') }}*</label>
                    <input value="{{ old('no_of_capacity') ? old('no_of_capacity') : (isset($table) ? $table->no_of_capacity : '') }}" min="0" step="1" type="number" name="no_of_capacity" class="form-control" placeholder="Ex: 1" required>
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.tables.position') }}*</label>
                    <input value="{{ old('position') ? old('position') : (isset($table) ? $table->position : '') }}" type="text" name="position" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.status') }}*</label>
                    <select name="status" class="form-control">
                        <option {{ isset($table) && $table->status == 'active' ? 'selected' : '' }} value="active">{{ trans('system.crud.active') }}</option>
                        <option {{ isset($table) && $table->status == 'inactive' ? 'selected' : '' }} value="inactive">{{ trans('system.crud.inactive') }}</option>
                    </select>
                </div>
            </div>
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
