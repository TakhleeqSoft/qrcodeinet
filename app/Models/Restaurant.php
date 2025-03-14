<?php

namespace App\Models;

use App\Models\User;
use App\Models\Feedback;
use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model implements Searchable
{
    use HasFactory, Sortable;

    protected $table = 'restaurants';

    const RESTAURANT_TYPE = [
        'Cafe' => 'Cafe',
        'Hotel' => 'Hotel',
        'Food Truck' => 'Food Truck',
        'Quick Service Restaurant' => 'Quick Service Restaurant',
        'Pub/Bar' => 'Pub/Bar',
    ];

    const LANGUAGES = ["English" => "English", "Hindi" => "Hindi"];

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'logo',
        'cover_image',
        'contact_email',
        'address',
        'phone_number',
        'city',
        'state',
        'country',
        'currency',
        'language',
        'zip',
        'qr_details',
        'theme',
        'dark_logo',
        'slug',
        'restaurant_type_id',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'linkedin_url',
        'tiktok_url'
    ];

    protected $casts = [
        'name' => "string",
        'type' => "string",
        'slug' => "string",
        'logo' => "string",
        'dark_logo' => "string",
        'cover_image' => "string",
        'phone_number' => "string",
        'address' => "string",
        'city' => "string",
        'state' => "string",
        'country' => "string",
        'currency' => "string",
        'language' => "array",
        'qr_details' => "json",
        'contact_email' => "string",
        'theme' => "string",
    ];

    public $sortable = [
        'id',
        'name',
        'type',
        'phone_number',
        'contact_email',
    ];

    public function users()
    {
        $table = (new User())->getTable();
        return $this->belongsToMany(User::class, 'restaurant_users', 'restaurant_id', 'user_id')->select(
            "$table.first_name",
            "$table.last_name",
            "$table.phone_number",
            "$table.email",
            "$table.profile_image",
            "$table.id",
            "$table.created_at",

        );
    }

    public function scopeAdmin($q, $params)
    {

        return $q->when(isset($params['admin_user_id']), function ($q) use ($params) {
            $q->whereHas('users', function ($q) use ($params) {
                $q->whereRaw('restaurant_users.restaurant_id in (select restaurant_id from restaurant_users where user_id = ' . $params['admin_user_id'] . ')');
            });
        });
    }

    public function created_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function food_categories()
    {
        $table = (new FoodCategory)->getTable();
        return $this->hasMany(FoodCategory::class, 'restaurant_id', 'id')->orderBy('sort_order', 'ASC')->select(
            "$table.id",
            "$table.restaurant_id",
            "$table.category_name",
            "$table.category_image",
            "$table.lang_category_name",
            "$table.sort_order",
            "$table.created_at",
        );
    }

    public function restaurant_type(){
        return $this->belongsTo(RestaurantType::class, 'type', 'id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'restaurant_id', 'id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'restaurant_id', 'id');
    }
    public function tables()
    {
        return $this->hasMany(Table::class, 'restaurant_id', 'id');
    }

    public function settings()
    {
        return $this->belongsTo(RestaurantSettings::class, 'id', 'restaurant_id');
    }

    public function vendor_setting()
    {
        return $this->hasOne(VendorSetting::class, 'user_id', 'user_id');
    }

    public static function restaurant_type_dropdown()
    {
        return ['' => __('system.fields.select_restaurant_type')] + Self::RESTAURANT_TYPE;
    }

    public function getLogoNameAttribute()
    {
        return ucfirst(substr($this->name, 0, 1));
    }

    public function getLanguageStringAttribute()
    {
        return implode(', ', $this->language ?? []);
    }

    public function getLogoUrlAttribute()
    {
        return getFileUrl($this->attributes['logo']);
    }

    public function getDarkLogoUrlAttribute()
    {
        return getFileUrl($this->attributes['dark_logo']);
    }

    public function setLogoAttribute($value)
    {
        if ($value != null) {
            $this->attributes['logo'] = uploadFile($value, 'logo');
        }
    }

    public function setDarkLogoAttribute($value)
    {
        if ($value != null) {
            $this->attributes['dark_logo'] = uploadFile($value, 'dark_logo');
        }
    }

    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = str_replace(' ', '', $value);
    }


    public function setQrDetailsAttribute($value)
    {
        if (gettype($value) != 'array') {
            $value = explode(',', $value);
        }

        $this->attributes['qr_details'] = json_encode($value);
    }

    public function getCoverImageUrlAttribute()
    {
        return getFileUrl($this->attributes['cover_image']);
    }

    public function setCoverImageAttribute($value)
    {
        if ($value != null) {
            $this->attributes['cover_image'] = uploadFile($value, 'cover_image');
        }
    }

    public function getLanguageAttribute()
    {

        return array_filter((json_decode($this->attributes['language'], 1) ?? []));
    }


    public function getFullAddressAttribute()
    {
        $add = '';
        if ($this->attributes['address']) {
            $add = $this->attributes['address'];
        }
        if ($this->attributes['city']) {
            $add = ($add ? $add . ", " : '') . $this->attributes['city'];
        }
        if ($this->attributes['state']) {
            $add = ($add ? $add . ", " : '') . $this->attributes['state'];
        }
        if ($this->attributes['zip']) {
            $add = ($add ? $add . "- " : '') . $this->attributes['zip'];
        }
        return $add;
    }

    public function setThemeAttribute($value)
    {

        $this->attributes['theme'] = strtolower($value);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('restaurant.restaurants.show', $this->id);
        $url .= "|" . route('restaurant.restaurants.edit', $this->id);
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function userFeedback()
    {
        return $this->hasMany(UserFeedback::class, 'restaurant_id', 'id');
    }
}
