<?php

namespace App\Http\Requests\Restaurant;

use App\Http\Controllers\Restaurant\RestaurantController;
use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = isset($this->restaurant->id) ? $this->restaurant->id : 0;
        $rules = [
            'logo' => ['nullable', 'max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'dark_logo' => ['nullable', 'max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'cover_image' => ['nullable', 'max:50000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'clone_data_into' => ["nullable", 'in:' . (implode(',', array_keys(RestaurantController::getRestaurantsDropdown())))],
            'phone_number' => ['required'],
            'slug' => ['required', 'unique:restaurants,slug,' . $id],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'zip' => ['required', 'min:2', "max:8"],
            'address' => ['required'],
            'user_id' => ['required'],

        ];

        if (isset($this->restaurant)) {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:restaurants,name,' . $this->restaurant->id];
            $rules['phone_number'] = ['required','unique:restaurants,phone_number,' . $this->restaurant->id];
        }
        return $rules;
    }
    public function messages()
    {
        $lbl_phone_number = strtolower(__('system.fields.phone_number'));
        $lbl_restaurant_name = strtolower(__('system.fields.restaurant_name'));
        $lbl_restaurant_type = strtolower(__('system.fields.restaurant_type'));
        $lbl_logo = strtolower(__('system.fields.app_light_logo'));
        $lbl_dark_logo = strtolower(__('system.fields.app_dark_logo'));
        $lbl_contact_email = strtolower(__('system.fields.contact_email'));
        $lbl_city = strtolower(__('system.fields.city'));
        $lbl_state = strtolower(__('system.fields.state'));
        $lbl_country = strtolower(__('system.fields.country'));
        $lbl_zip = strtolower(__('system.fields.zip'));
        $lbl_address = strtolower(__('system.fields.address'));
        $lbl_cover_image = strtolower(__('system.fields.cover_image'));
        return [
            "name.required" => __('validation.required', ['attribute' => $lbl_restaurant_name]),
            "name.string" => __('validation.custom.invalid', ['attribute' => $lbl_restaurant_name]),
            "name.max" => __('validation.custom.invalid', ['attribute' => $lbl_restaurant_name]),
            "name.unique" => __('validation.unique', ['attribute' => $lbl_restaurant_name]),

            // "type.required" => __('validation.custom.select_required', ['attribute' => $lbl_restaurant_type]),
            // "type.string" => __('validation.enum', ['attribute' => $lbl_restaurant_type]),
            // "type.in" => __('validation.enum', ['attribute' => $lbl_restaurant_type]),

            "phone_number.required" => __('validation.required', ['attribute' => $lbl_phone_number]),
            "phone_number.regex" => __('validation.custom.invalid', ['attribute' => $lbl_phone_number]),
            "phone_number.unique" => __('validation.unique', ['attribute' => $lbl_phone_number]),

            "logo.max" => __('validation.gt.file', ['attribute' => $lbl_logo, 'value' => 10000]),
            "logo.image" => __('validation.enum', ['attribute' => $lbl_logo]),
            "logo.mimes" => __('validation.enum', ['attribute' => $lbl_logo]),

            "dark_logo.max" => __('validation.gt.file', ['attribute' => $lbl_dark_logo, 'value' => 10000]),
            "dark_logo.image" => __('validation.enum', ['attribute' => $lbl_dark_logo]),
            "dark_logo.mimes" => __('validation.enum', ['attribute' => $lbl_dark_logo]),

            "cover_image.max" => __('validation.gt.file', ['attribute' => $lbl_cover_image, 'value' => 50000]),
            "cover_image.image" => __('validation.enum', ['attribute' => $lbl_cover_image]),
            "cover_image.mimes" => __('validation.enum', ['attribute' => $lbl_cover_image]),

            "contact_email.required" => __('validation.required', ['attribute' => $lbl_contact_email]),
            "contact_email.string" => __('validation.custom.invalid', ['attribute' => $lbl_contact_email]),
            "contact_email.email" => __('validation.custom.invalid', ['attribute' => $lbl_contact_email]),


            "city.required" => __('validation.required', ['attribute' => $lbl_city]),
            "city.min" => __('validation.custom.invalid', ['attribute' => $lbl_city]),

            "state.required" => __('validation.required', ['attribute' => $lbl_state]),
            "state.min" => __('validation.custom.invalid', ['attribute' => $lbl_state]),

            "country.required" => __('validation.required', ['attribute' => $lbl_country]),
            "country.min" => __('validation.custom.invalid', ['attribute' => $lbl_country]),

            "zip.required" => __('validation.required', ['attribute' => $lbl_zip]),
            "zip.min" => __('validation.custom.invalid', ['attribute' => $lbl_zip]),
            "zip.max" => __('validation.custom.invalid', ['attribute' => $lbl_zip]),

            "address.required" => __('validation.required', ['attribute' => $lbl_address]),
            "address.min" => __('validation.custom.invalid', ['attribute' => $lbl_address]),

        ];
    }
}
