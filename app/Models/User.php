<?php

namespace App\Models;

use App\Models\Feedback;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Searchable\Searchable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\SearchResult;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Searchable, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;
    use HasRoles;

    protected $table = 'users';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const USER_TYPE_ADMIN = 1;
    const USER_TYPE_STAFF = 2;
    const USER_TYPE_VENDOR = 3;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'google_token',
        'google_access_id',
        'notification_token',
        'created_by',
        'profile_image',
        'language',
        'status',
        'restaurant_id',
        'address',
        'city',
        'state',
        'country',
        'zip',
        'user_type',
        'is_trial_enabled',
        'plan_purchased',
        'trial_expire_at',
        'email_verified_at',
        'free_forever',
        'last_login_at',
        'user_ip',
    ];

    public $sortable = [
        'id',
        'first_name',
        'email',
        'created_at',
        'phone_number',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'first_name' => "string",
        'last_name' => "string",
        'email' => "string",
        'password' => "string",
        'phone_number' => "string",
        'google_token' => "string",
        'google_access_id' => "string",
        'notification_token' => "string",
        'created_by' => "integer",
        'profile_image' => "string",
        'language' => "string",
        'status' => "integer",
        'restaurant_id' => "integer",
        'address' => "string",
        'city' => "string",
        'state' => "string",
        'country' => "string",
        'user_type' => "integer"
    ];

    public function restaurant()
    {
        $table = (new Restaurant())->getTable();

        return $this->hasOne(Restaurant::class, 'id', 'restaurant_id')->select(
            "$table.name",
            "$table.slug",
            "$table.logo",
            "$table.cover_image",
            "$table.theme",
            "$table.language",
            "$table.id",
            "$table.created_at",
        );
    }

    public function restaurants()
    {
        $table = (new Restaurant())->getTable();
        return $this->belongsToMany(Restaurant::class, 'restaurant_users', 'user_id', 'restaurant_id')
            ->withPivot("role")->wherePivot('role', RestaurantUser::ROLE_STAFF)->select(
                "$table.name",
                "$table.logo",
                "$table.cover_image",
                "$table.theme",
                "$table.language",
                "$table.id",
                "$table.created_at",
            );
    }

    public function scopeAdmin($q, $params)
    {

        return $q->when(isset($params['admin_user_id']), function ($q) use ($params) {
            $q->whereHas('restaurants', function ($q) use ($params) {
                $q->whereRaw('restaurant_users.restaurant_id in (select restaurant_id from restaurant_users where user_id = ' . $params['admin_user_id'] . ')');
            });
        });
    }

    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . " " . ucfirst($this->last_name);
    }

    public function getLogoNameAttribute()
    {
        return ucfirst(substr($this->first_name, 0, 1));
    }

    public function setProfileImageAttribute($value)
    {
        $this->attributes['profile_image'] = uploadFile($value, 'profile');
    }

    public function getProfileUrlAttribute()
    {
        return getFileUrl($this->attributes['profile_image']);
    }

    public function getSearchResult(): SearchResult
    {
        $this->name;
        $user = auth()->user();
        if ($user->id == $this->id) {
            $url = route('restaurant.profile');
        } else {
            $url = route('restaurant.staff.edit', $this->id);
        }

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function vendor_setting()
    {
        return $this->belongsTo(VendorSettings::class, 'id', 'user_id');
    }

    public function user_plans()
    {
        return $this->hasMany(Subscriptions::class, 'user_id', 'id');
    }

    public function active_plan()
    {
        return $this->hasOne(Subscriptions::class, 'user_id', 'id')->where('is_current', 'yes');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id', 'id');
    }

    public function current_plans()
    {
        return $this->user_plans()->where('is_current', 'yes')->orderByDesc('created_at')->where(function ($q) {
            $q->where('expiry_date', '>', now())->orWhereNull('expiry_date');
        });
    }

    // get vendor of the staff
    public function staffVendor()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->where('user_type', 2);
    }

    public function pusher_setting()
    {
        if ($this->user_type == 3) {

            return $this->belongsTo(VendorSetting::class, 'id', 'user_id');
        } elseif ($this->user_type == 2) {

            return $this->belongsTo(VendorSetting::class, 'created_by', 'user_id');
        }
    }
}
