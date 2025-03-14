<div class="row">


    <div class=" col-md-4">
        @php($lbl_category_name = __('system.fields.language_name'))

        <div class="mb-3 form-group @error('name') has-danger @enderror ">
            <label class="form-label" for="name">{{ $lbl_category_name }} <span class="text-danger">*</span></label>
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => $lbl_category_name,
                'required' => 'true',
                'maxlength' => 50,
                'minlength' => 2,
                'autocomplete' => 'off',
                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_category_name)]),
                'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_category_name)]),
            ]) !!}
            @error('name')
                <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class=" col-md-4">
        @php($lbl_direction = __('system.fields.direction'))

        <div class="mb-3 form-group @error('name') has-danger @enderror ">
            <label class="form-label" for="name">{{ $lbl_direction }} <span class="text-danger">*</span></label>
            {!! Form::select('direction',['ltr'=>'LTR','rtl'=>"RTL"], 'ltr', [
                'class' => 'form-control form-select',
                'id' => 'direction',
                'required' => 'true',
                'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_direction)]),
            ]) !!}
            @error('name')
            <div class="pristine-error text-help">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
