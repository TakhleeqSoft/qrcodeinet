@csrf
<div>
    <section>
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.name') }}*</label>
                    <input value="{{ old('title') ? old('title') : (isset($plan) ? $plan->title : '') }}" type="text" name="title" class="form-control" placeholder="{{ trans('system.plans.name') }}" required>
                </div>
            </div>
            @foreach (getAllCurrentRestaruentLanguages() as $key => $lang)
                <div class="col-lg-4 mb-2">
                    @php($lbl_plan_title = __('system.plans.name') . ' ' . $lang)
                    <div class="form-group @error('lang_plan_title.' . $key) has-danger @enderror">
                        <label class="form-label" for="name">{{ $lbl_plan_title }} <span class="text-danger">*</span></label>
                        {!! Form::text("lang_plan_title[$key]", null, [
                            'class' => 'form-control',
                            'id' => 'name' . $key,
                            'autocomplete' => 'off',
                            'placeholder' => $lbl_plan_title,
                            'required' => 'true',
                            'data-pristine-required-message' => __('validation.required', ['attribute' => strtolower($lbl_plan_title)]),
                            'data-pristine-minlength-message' => __('validation.custom.invalid', ['attribute' => strtolower($lbl_plan_title)]),
                        ]) !!}
                        @error('lang_plan_title.' . $key)
                            <div class="pristine-error text-help">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach

            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.recurring_type') }}*</label>
                    <select data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.plans.recurring_type'))])}}" name="recurring_type" class="form-control" required>
                        <option value="">{{trans('system.plans.recurring_type')}}</option>
                        <option {{ isset($plan) && $plan->type == 'onetime' ? 'selected' : '' }} value="onetime">{{ trans('system.plans.onetime') }}</option>
                        <option {{ isset($plan) && $plan->type == 'monthly' ? 'selected' : '' }} value="monthly">{{ trans('system.plans.monthly') }}</option>
                        <option {{ isset($plan) && $plan->type == 'yearly' ? 'selected' : '' }} value="yearly">{{ trans('system.plans.yearly') }}</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.amount') }}*</label>
                    <input  data-pristine-required-message="{{__('validation.required', ['attribute' => strtolower(trans('system.plans.amount'))])}}" value="{{ old('amount') ? old('amount') : (isset($plan) ? $plan->amount : '') }}" min="0" step="0.01" type="number" name="amount" class="form-control" placeholder="Ex: 200" required>
                </div>
            </div>


            <div class="col-lg-4 mb-2">
                <label class="text-label">{{ trans('system.plans.restaurant_limit') }}*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text is-unlimited">
                            <input data-name="restaurant_limit" {{ isset($plan) && $plan->restaurant_unlimited == 'yes' ? 'checked' : '' }} id="is_restaurant_unlimited" data-target="#restaurant_limit" name="is_restaurant_unlimited" type="checkbox" class="isUnlimited" value="yes">
                            <label for="is_restaurant_unlimited" class="form-check-label ml-3"> {{ trans('system.plans.is_unlimited') }}</label>
                        </div>
                    </div>
                    <input value="{{ old('restaurant_limit') ? old('restaurant_limit') : (isset($plan) ? $plan->restaurant_limit : 0) }}" type="number" name="restaurant_limit" id="restaurant_limit" class="form-control" placeholder="Ex: 5" required min="0">
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <label class="text-label">{{ trans('system.plans.item_limit') }}*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text is-unlimited">
                            <input data-name="item_limit" {{ isset($plan) && $plan->item_unlimited == 'yes' ? 'checked' : '' }} name="is_item_unlimited" id="is_item_unlimited" type="checkbox" data-target="#item_limit" class="isUnlimited" value="yes">
                            <label class="form-check-label ml-3" for="is_item_unlimited">
                                {{ trans('system.plans.is_unlimited') }}
                            </label>
                        </div>
                    </div>
                    <input value="{{ old('item_limit') ? old('item_limit') : (isset($plan) ? $plan->item_limit : 0) }}" type="number" name="item_limit" id="item_limit" class="form-control" placeholder="Ex: 5" required min="0">
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <label class="text-label">{{ trans('system.plans.staff_limit') }}*</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text is-unlimited">
                            <input data-name="staff_limit" {{ isset($plan) && $plan->staff_unlimited == 'yes' ? 'checked' : '' }} name="is_staff_unlimited" id="is_staff_unlimited" type="checkbox" data-target="#staff_limit" class="isUnlimited" value="yes">
                            <label class="form-check-label ml-3" for="is_staff_unlimited">
                                {{ trans('system.plans.is_unlimited') }}
                            </label>
                        </div>
                    </div>
                    <input value="{{ old('staff_limit') ? old('staff_limit') : (isset($plan) ? $plan->staff_limit : 0) }}" type="number" name="staff_limit" id="staff_limit" class="form-control" placeholder="Ex: 5" required min="0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.plans.status') }}*</label>
                    <select name="status" class="form-control">
                        <option {{ isset($plan) && $plan->status == 'active' ? 'selected' : '' }} value="active">{{ trans('system.crud.active') }}</option>
                        <option {{ isset($plan) && $plan->status == 'inactive' ? 'selected' : '' }} value="inactive">{{ trans('system.crud.inactive') }}</option>
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
