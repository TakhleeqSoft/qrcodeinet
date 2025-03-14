<?php

namespace App\Models;

use App\Models\FoodCategory;
use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model implements Searchable
{
    use HasFactory, Sortable;

    public $table = 'foods';
    const DISCOUNT_TYPE_FIXED = 'fixed';
    const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'price',
        'ingredient',
        'preparation_time',
        'is_featured',
        'is_available',
        'is_default_image',
        'is_out_of_sold',
        'label_image',
        'food_image',
        'lang_name',
        'lang_description',
        'lang_allergy',
        'lang_calories',
        'gallery_images',
        'calories',
        'allergy',
        'discount_price',
        'discount_type',
        'key',
        'custom_field'
    ];

    protected $casts = [

        'restaurant_id' => "integer",
        'name' => "string",
        'description' => "string",
        'price' => "double",
        'ingredient' => "array",
        'preparation_time' => "string",
        'is_featured' => "boolean",
        'is_available' => "boolean",
        'is_out_of_sold' => "boolean",
        'label_image' => "string",
        'food_image' => "string",
        'calories' => "string",
        'allergy' => "string",
        'lang_name' => "array",
        'lang_description' => "array",
        'lang_allergy' => "array",
        'lang_calories' => "array",
        'gallery_images' => "array",
        'custom_field' => 'array'
    ];
    public $sortable = [
        'id',
        'name',
        'preparation_time',
        'price',
        'is_available',
        'created_at',
        'food_categories.pivot_sort_order'
    ];

    public function getFoodImageNameAttribute()
    {
        return ucfirst(substr($this->name, 0, 1));
    }

    public function getFoodImageUrlAttribute()
    {
        return getFileUrl($this->attributes['food_image']);
    }

    public function setFoodImageAttribute($value)
    {
        if ($value != null) {
            if (gettype($value) == 'string') {
                $this->attributes['food_image'] = $value;
            } else {
                $this->attributes['food_image'] = uploadFile($value, 'food_image');
            }
        }
    }

    public function setKeyAttribute($value)
    {
        $data = [];
        foreach (request()->val as $k => $v) {
            $new = [];
            foreach ($value[$k] as $i => $vs) {
                if (!(empty($vs) || !isset($v[$i]) || empty($v[$i]))) {
                    $new[$vs] = $v[$i];
                }
            }
            $data[$k] = $new;
        }
        $this->attributes['custom_field'] = json_encode($data);
    }

    public function getUsdPriceAttribute()
    {
        $vendorSetting = $this->restaurant->vendor_setting;
        if (!empty($vendorSetting)) {
            $symbol = $vendorSetting->default_currency_symbol;
            if ($vendorSetting->default_currency_position == 'right') {
                return $this->attributes['price'] > 0 ? number_format($this->attributes['price'], 2) . "$symbol" : "00.00{$symbol}";
            } else {
                return $this->attributes['price'] > 0 ? "$symbol" . number_format($this->attributes['price'], 2) : "{$symbol}00.00";
            }
        }
        $symbol = config('app.currency_symbol');
        return $this->attributes['price'] > 0 ? "$symbol" . number_format($this->attributes['price'], 2) : "{$symbol}00.00";
    }

    public function getUsdDiscountedPriceAttribute()
    {
        if ($this->attributes['discount_type'] != null) {
            $discont_type = $this->attributes['discount_type'];
            if ($discont_type == null) {
                return false;
            }

            if ($discont_type == 'fixed') {
                $price_after_discount = $this->attributes['price'] - $this->attributes['discount_price'];
            } else {
                $price_after_discount = $this->attributes['price'] - ($this->attributes['price'] * ($this->attributes['discount_price'] / 100));
            }

            $vendorSetting = $this->restaurant->vendor_setting;
            if (!empty($vendorSetting)) {
                $symbol = $vendorSetting->default_currency_symbol;
                if ($vendorSetting->default_currency_position == 'right') {
                    $price_after_discount = $price_after_discount > 0 ? number_format($price_after_discount, 2) . "$symbol" : "00.00{$symbol}";
                } else {
                    $price_after_discount = $price_after_discount > 0 ? "$symbol" . number_format($price_after_discount, 2) : "{$symbol}00.00";
                }
            }

            $symbol = config('app.currency_symbol');
            return $price_after_discount;
        }
    }

    public function setIngredientAttribute($value)
    {
        if (gettype($value) == 'string') {
            $value = explode(',', $value);
        }
        $this->attributes['ingredient'] = json_encode($value);
    }

    public function getLabelImageUrlAttribute()
    {
        return getFileUrl($this->attributes['label_image']);
    }

    public function setLabelImageAttribute($value)
    {
        if ($value != null) {
            if (gettype($value) == 'string') {
                $this->attributes['label_image'] = $value;
            } else {
                $this->attributes['label_image'] = uploadFile($value, 'label_image');
            }
        }
    }

    public function setLangNameAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_name'] = json_encode($value);
        }
    }

    public function setLangDescriptionAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_description'] = json_encode($value);
        }
    }

    public function setLangCaloriesAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_calories'] = json_encode($value);
        }
    }

    public function setLangAllergyAttribute($value)
    {
        if (gettype($value) == 'array') {
            $this->attributes['lang_allergy'] = json_encode($value);
        }
    }

    public function food_category()
    {
        return $this->hasOne(FoodCategory::class, 'id', 'food_category_id');
    }

    public function food_categories()
    {
        $table = (new FoodCategory)->getTable();
        return $this->belongsToMany(FoodCategory::class, 'food_food_category')->withPivot('sort_order')->select(
            "$table.id",
            "$table.restaurant_id",
            "$table.category_name",
            "$table.category_image",
            "$table.lang_category_name",
            "$table.sort_order",
            "$table.created_at",
        );
    }

    public function getCategoriesIdsAttribute()
    {
        return $this->food_categories()->pluck('id')->toArray();;
    }

    public function getLocalLangNameAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->name;
        } else {
            return $this->lang_name[app()->getLocale()] ?? $this->name;
        }
    }

    public function getLocalLangDescriptionAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->description;
        } else {
            return $this->lang_description[app()->getLocale()] ?? $this->description;
        }
    }

    public function getLocalLangCaloriesAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->calories;
        } else {
            return $this->lang_calories[app()->getLocale()] ?? $this->calories;
        }
    }

    public function getLocalLangAllergyAttribute()
    {
        if (app()->getLocale() == 'en') {
            return $this->allergy;
        } else {
            return $this->lang_allergy[app()->getLocale()] ?? $this->allergy;
        }
    }

    public function getGalleryImagesWithDetailsAttribute()
    {
        $imgs = [];
        foreach ($this->gallery_images ?? [] as $img) {
            $name = basename($img);
            $newFileName = substr($name, 0, (strrpos($name, ".")));
            $n['url'] = $url = getFileUrl($img);
            $n['name'] = $name;
            $n['img'] = $img;
            $n['id'] = $newFileName;
            $imgs[] = $n;
        }
        return $imgs;
    }

    public function getGalleryImagesSliderDataAttribute()
    {
        $imgs = [];
        $default_image = getFileUrl($this->attributes['food_image']);
        if ($this->is_default_image) {
            $default_image = !empty(($this->restaurant->vendor_setting)) ? getFileUrl($this->restaurant->vendor_setting->default_food_image) : asset('assets/images/default_food.png');
        }
        $imgs[] = ['src' => $default_image, 'title' => $this->getLocalLangNameAttribute()];
        foreach ($this->gallery_images ?? [] as $img) {
            $imgs[] = ['src' => getFileUrl($img)];
        }
        return $imgs;
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('restaurant.foods.show', $this->id);
        $url .= "|" . route('restaurant.foods.edit', $this->id);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function getLocalCustomFieldAttribute()
    {
        return $this->custom_field[app()->getLocale()] ?? [];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
}
