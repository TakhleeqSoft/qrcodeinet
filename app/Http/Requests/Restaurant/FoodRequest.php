<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
        $request = request();

        $langs = getAllCurrentRestaruentLanguages();
        $rules = [
            'food_image' => [$request->is_default_image == 'on' ? 'nullable' : 'required', 'max:50000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'description' => ['nullable',],
            'price' => ['required', 'numeric'],
            'preparation_time' => ['nullable', 'string'],
            'categories' => ['required'],
            'calories' => ['nullable'],
            'allergy' => ['nullable'],
            'categories.*' => ['exists:food_categories,id'],
            'restaurant_id' => ['required', 'unique:foods,restaurant_id,null,id,name,' . $request->name],
        ];

        if(!empty(request()->discount_type)){
            $rules['discount_price'] = request()->discount_type == 'fixed' ? ['required', 'min:1'] : ['required', 'min:1', 'max:99'];
            $rules['discount_type'] = ['nullable', 'in:fixed,percentage'];
        }

        if (isset($this->food)) {
            $rules['food_image'] = 'nullable';
            $rules['restaurant_id'] = ['required', 'unique:foods,restaurant_id,' . $this->food->id . ',id,name,' . $request->name];
            if (count($langs) > 0) {
                $old_id = $this->food->id;
                $rules['lang_name.*'] = ['required'];
                $rules['lang_description.*'] = ['nullable'];
                $rules['lang_calories.*'] = ['nullable'];
                $rules['lang_allergy.*'] = ['nullable'];
                $rules['restaurant_ids.*'] = ['required'];

                foreach ($langs as $key => $lang) {
                    $rules['lang_description.' . $key] = ['nullable'];
                    $rules['lang_calories.' . $key] = ['nullable'];
                    $rules['lang_allergy.' . $key] = ['nullable'];
                    $rules['lang_name.' . $key] = ['string', 'max:255', 'min:2'];
                    $rules['restaurant_ids.' . $key] = ["unique:foods,restaurant_id,$old_id,id,lang_name->$key," .  str_replace("%", "%%", $request->lang_name[$key])];
                }
            }
        } else {
            $rules['lang_name.*'] = ['required'];
            $rules['lang_calories.*'] = ['nullable'];
            $rules['lang_allergy.*'] = ['nullable'];
            $rules['lang_description.*'] = ['nullable'];
            $rules['restaurant_ids.*'] = ['required'];
            foreach ($langs as $key => $lang) {
                $rules['lang_name.' . $key] = ['string', 'max:255', 'min:2'];
                $rules['restaurant_ids.' . $key] = ["unique:foods,restaurant_id,null,id,lang_name->$key," .  str_replace("%", "%%", $request->lang_name[$key])];
            }
        }
        return $rules;
    }

    public function messages()
    {
        $langs = getAllCurrentRestaruentLanguages();
        $request = request();
        $lbl_food_name = strtolower(__('system.fields.food_name'));
        $lbl_food_image = strtolower(__('system.fields.food_image'));
        $lbl_food_category = strtolower(__('system.fields.food_category'));
        $lbl_food_description = strtolower(__('system.fields.food_description'));
        $lbl_food_price = strtolower(__('system.fields.food_price'));
        $lbl_preparation_time = strtolower(__('system.fields.preparation_time'));
        $lbl_is_featured = strtolower(__('system.fields.is_featured'));
        $lbl_is_available = strtolower(__('system.fields.is_available'));
        $lbl_calories = strtolower(__('system.fields.calories'));
        $lbl_allergies = strtolower(__('system.fields.allergies'));

        $messages = [
            "food_image.max" => __('validation.gt.file', ['attribute' => $lbl_food_image, 'value' => 50000]),
            "food_image.image" => __('validation.enum', ['attribute' => $lbl_food_image]),
            "food_image.mimes" => __('validation.enum', ['attribute' => $lbl_food_image]),
            "food_image.required" => __('validation.custom.select_required', ['attribute' => $lbl_food_image]),

            "name.required" => __('validation.required', ['attribute' => $lbl_food_name]),
            "name.string" => __('validation.custom.invalid', ['attribute' => $lbl_food_name]),
            "name.max" => __('validation.custom.invalid', ['attribute' => $lbl_food_name]),

            "description.required" => __('validation.required', ['attribute' => $lbl_food_description]),
            "description.string" => __('validation.custom.invalid', ['attribute' => $lbl_food_description]),
            "description.min" => __('validation.custom.invalid', ['attribute' => $lbl_food_description]),

            "price.required" => __('validation.required', ['attribute' => $lbl_food_price]),
            "price.numeric" => __('validation.custom.invalid', ['attribute' => $lbl_food_price]),
            "price.min" => __('validation.custom.invalid', ['attribute' => $lbl_food_price]),

            "preparation_time.required" => __('validation.required', ['attribute' => $lbl_preparation_time]),

            "restaurant_id.required" => __('validation.custom.select_required', ['attribute' => 'restaurant']),

            "categories.required" => __('validation.custom.select_required', ['attribute' => $lbl_food_category]),
            "categories.exists" => __('validation.enum', ['attribute' => $lbl_food_category]),

            "restaurant_id.unique" => __('validation.unique', ['name' => $request->name, 'attribute' => 'food']),
        ];
        if (count($langs) > 0) {

            foreach ($langs as $key => $lang) {
                $lbl_food_name = strtolower(__('system.fields.food_name') . " " . $lang);
                $lbl_food_desc = strtolower(__('system.fields.description') . " " . $lang);
                $messages["lang_name.$key.string"] = __('validation.custom.invalid', ['attribute' => $lbl_food_name]);
                $messages["lang_name.$key.max"] = __('validation.custom.invalid', ['attribute' => $lbl_food_name]);
                $messages["lang_name.$key.min"] = __('validation.custom.invalid', ['attribute' => $lbl_food_name]);
                $messages["lang_description.$key.string"] = __('validation.custom.invalid', ['attribute' => $lbl_food_desc]);
                $messages["lang_description.$key.max"] = __('validation.custom.invalid', ['attribute' => $lbl_food_desc]);
                $messages["lang_description.$key.min"] = __('validation.custom.invalid', ['attribute' => $lbl_food_desc]);
                $messages["restaurant_ids.$key.unique"]  = __('validation.unique', ['name' => $request->lang_name[$key], 'attribute' => $lbl_food_name]);
            }
        }
        return $messages;
    }
}
