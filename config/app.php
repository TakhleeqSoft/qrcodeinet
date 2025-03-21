<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
     */

    'name' => env('APP_NAME', 'Laravel'),
    'hide_restaurant_after_days' => env('HIDE_RESTAURANT', 14),
    'trial_days' => env('TRIAL_DAYS', 14),

    'trial_restaurant' => env('TRIAL_RESTAURANT', 1),
    'trial_food' => env('TRIAL_FOOD', 1),
    'trial_staff' => env('TRIAL_STAFF', 1),

    'dark_sm_logo' => env('APP_DARK_SMALL_LOGO', '/front-images/logo-dark.png'),
    'ligth_sm_logo' => env('APP_LIGHT_SMALL_LOGO', '/front-images/logo-light.png'),
    'favicon_icon' => env('APP_FAVICON_ICON', '/front-images/logo-light.png'),

    'banner_image_one' => env('BANNER_IMAGE_ONE', '/front-images/background-min.jpg'),
    'banner_image_two' => env('BANNER_IMAGE_TWO', '/front-images/iphone.png'),
    'how_it_works_step_one' => env('HOW_IT_WORKS_STEP_ONE', '/front-images/register.png'),
    'how_it_works_step_two' => env('HOW_IT_WORKS_STEP_TWO', '/front-images/form.png'),
    'how_it_works_step_three' => env('HOW_IT_WORKS_STEP_THREE', '/front-images/qr.png'),
    'default_restaurant' => env('APP_DEFAULT_RESTAURANT', 1),
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
     */

    /*
    |--------------------------------------------------------------------------
    | Social Media
    |--------------------------------------------------------------------------
     */

    'facebook_url' => env('FACEBOOK_URL'),
    'instagram_url' => env('INSTAGRAM_URL'),
    'twitter_url' => env('TWITTER_URL'),
    'youtube_url' => env('YOUTUBE_URL'),
    'linkedin_url' => env('LINKEDIN_URL'),
    'support_email' => env('SUPPORT_EMAIL'),
    'support_phone' => env('SUPPORT_PHONE'),

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
     */

    'debug' => (bool)env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
     */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
     */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    'date_time_format' => env('APP_DATE_TIME_FORMAT', 'Y-m-d H:i:s'),
    'date_format' => env('APP_DATE_FORMAT', 'Y-m-d'),
    'time_format' => env('APP_TIME_FORMAT', 'H:i:s'),
    'currency' => env('APP_CURRENCY', 'USD'),
    'currency_symbol' => env('APP_CURRENCY_SYMBOL', '$'),
    'currency_position' => env('CURRENCY_POSITION', 'left'),


    'display_language' => env('DISPLAY_LANGUAGE', 1),
    'dark_light_change' => env('DARK_LIGHT_CHANGE', 1),
    'direction_change' => env('DIRECTION_CHANGE', 1),

    'is_allergies_field_visible' => env('ALLERGIES', 1),
    'is_calories_field_visible' => env('CALORIES', 1),
    'is_preparation_time_field_visible' => env('PREPARATION_TIME', 1),
    'is_show_display_full_details_model' => env('FULL_DETAILS_MODEL', 1),
    'show_banner' => env('SHOW_BANNER', 1),
    'show_restaurant_name' => env('SHOW_RESTAURANT_NAME', 1),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
     */

    'locale' => env('APP_SET_DEFAULT_LANGUAGE', 'en'),
    'app_locale' => env('APP_SET_DEFAULT_LANGUAGE', 'en'),
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
     */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
     */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
     */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
     */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        //Barryvdh\Debugbar\ServiceProvider::class,

        Kyslik\ColumnSortable\ColumnSortableServiceProvider::class,

        SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class,
        Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,

        Maatwebsite\Excel\ExcelServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
     */

    'aliases' => Facade::defaultAliases()->merge([
        'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ])->toArray(),

];
