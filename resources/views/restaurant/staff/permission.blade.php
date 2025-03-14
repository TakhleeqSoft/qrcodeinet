<?php
$permission = [];
if (old('permission') && old('permission') != null) {
    $permission = old('permission');
} else {
    if (isset($user->permissions) && $user->permissions->count() > 0) {
        $permission = $user->permissions->pluck('name')->toArray();
    }
}
?>

<!-- Restaurant Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.fields.restaurant') }}</h6>
    </div>
</div>



<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="restaurant_show"
                    value="show restaurants" onchange="check_permission(this)"
                    @if (in_array('show restaurants', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="restaurant_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2 p-2" type="checkbox" name="permission[]" id="restaurant_add"
                    value="add restaurants" onchange="check_permission(this)"
                    @if (in_array('add restaurants', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="restaurant_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="restaurant_edit"
                    value="edit restaurants" onchange="check_permission(this)"
                    @if (in_array('edit restaurants', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="restaurant_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="restaurant_delete"
                    value="delete restaurants" onchange="check_permission(this)"
                    @if (in_array('delete restaurants', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="restaurant_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>

<!-- Category Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.food_categories.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="category_show"
                    value="show category" onchange="check_permission(this)"
                    @if (in_array('show category', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="category_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="category_add"
                    value="add category" onchange="check_permission(this)"
                    @if (in_array('add category', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="category_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="category_edit"
                    value="edit category" onchange="check_permission(this)"
                    @if (in_array('edit category', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="category_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="category_delete"
                    value="delete category" onchange="check_permission(this)"
                    @if (in_array('delete category', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="category_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>

<!-- Food Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.theme.foods') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="food_show"
                    value="show food" onchange="check_permission(this)"
                    @if (in_array('show food', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="food_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="food_add" value="add food"
                    onchange="check_permission(this)" @if (in_array('add food', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="food_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="food_edit"
                    value="edit food" onchange="check_permission(this)"
                    @if (in_array('edit food', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="food_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="food_delete"
                    value="delete food" onchange="check_permission(this)"
                    @if (in_array('delete food', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="food_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>


<!-- staff Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.staffs.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_show"
                    value="show staff" onchange="check_permission(this)"
                    @if (in_array('show staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_add"
                    value="add staff" onchange="check_permission(this)"
                    @if (in_array('add staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_edit"
                    value="edit staff" onchange="check_permission(this)"
                    @if (in_array('edit staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="staff_delete"
                    value="delete staff" onchange="check_permission(this)"
                    @if (in_array('delete staff', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="staff_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>



<!-- staff Permission -->
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.tables.menu') }}</h6>
    </div>
</div>
<div class="row mb-2">

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="tables_show"
                    value="show tables" onchange="check_permission(this)"
                    @if (in_array('show tables', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="tables_show">
                    {{ __('system.crud.show') }}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="tables_add"
                    value="add tables" onchange="check_permission(this)"
                    @if (in_array('add tables', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="tables_add">
                    {{ __('system.crud.add_new') }}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="tables_edit"
                    value="edit tables" onchange="check_permission(this)"
                    @if (in_array('edit tables', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="tables_edit">
                    {{ __('system.crud.edit') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="tables_delete"
                    value="delete tables" onchange="check_permission(this)"
                    @if (in_array('delete tables', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="tables_delete">
                    {{ __('system.crud.delete') }}
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h6>{{ __('system.fields.other') }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="qrcode_show"
                    value="show qrcode" onchange="check_permission(this)"
                    @if (in_array('show qrcode', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="qrcode_show">
                    {{ __('system.qr_code.menu') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="themes_add"
                    value="show themes" onchange="check_permission(this)"
                    @if (in_array('show themes', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="themes_add">
                    {{ __('system.themes.menu') }}
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <div class="form-check mb-3">
                <input class="form-control form-check-input p-2" type="checkbox" name="permission[]" id="call_waiter"
                    value="show callwaiter" onchange="check_permission(this)"
                    @if (in_array('show callwaiter', $permission)) {{ 'checked' }} @endif>
                <label class="form-check-label ms-2" for="call_waiter">
                    {{ __('system.call_waiters.menu') }}
                </label>
            </div>
        </div>
    </div>
    @error('permission')
        <div class="pristine-error text-help">{{ $message }}</div>
    @enderror
</div>
