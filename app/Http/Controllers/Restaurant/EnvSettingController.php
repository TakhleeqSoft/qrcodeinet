<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class EnvSettingController extends Controller
{
    public static $timeformate = [
        'd/m/Y h:i' => [
            'date' => "d/m/Y",
            'time' => 'h:i',
            'value' => 'd/m/Y h:i (EX: 02/09/2022 10:37)',
        ],
        'd-m-Y h:i' => [
            'date' => "d-m-Y",
            'time' => 'h:i',
            'value' => 'd-m-Y h:i (EX: 02-09-2022 10:37)',
        ],
        'm-d-Y h:i' => [
            'date' => "m-d-Y",
            'time' => 'h:i',
            'value' => 'm-d-Y h:i (EX: 02/09/2022 10:37)',
        ],
        'm/d/Y h:i' => [
            'date' => "m/d/Y",
            'time' => 'h:i',
            'value' => 'm/d/Y h:i (EX: 09/02/2022 10:37)',
        ],
        'Y/m/d h:i' => [
            'date' => "Y/m/d",
            'time' => 'h:i',
            'value' => 'Y/m/d h:i  (EX: 2022/09/02 10:37)',
        ],
        'Y-m-d h:i' => [
            'date' => "Y-m-d h:i",
            'time' => 'h:i',
            'value' => 'Y-m-d h:i  (EX: 2022-09-02 10:37)',
        ],

        'd/m/Y H:i' => [
            'date' => "d/m/Y",
            'time' => 'H:i',
            'value' => 'd/m/Y H:i (EX: 02/09/2022 20:37)',
        ],
        'd-m-Y H:i' => [
            'date' => "d-m-Y",
            'time' => 'H:i',
            'value' => 'd-m-Y H:i (EX: 02-09-2022 20:37)',
        ],
        'm-d-Y H:i' => [
            'date' => "m-d-Y",
            'time' => 'H:i',
            'value' => 'm-d-Y H:i (EX: 02/09/2022 20:37)',
        ],
        'm/d/Y H:i' => [
            'date' => "m/d/Y",
            'time' => 'H:i',
            'value' => 'm/d/Y H:i (EX: 09/02/2022 20:37)',
        ],
        'Y/m/d H:i' => [
            'date' => "Y/m/d",
            'time' => 'H:i',
            'value' => 'Y/m/d H:i  (EX: 2022/09/02 20:37)',
        ],
        'Y-m-d H:i' => [
            'date' => "Y-m-d H:i",
            'time' => 'H:i',
            'value' => 'Y-m-d H:i  (EX: 2022-09-02 20:37)',
        ],

        'F j, Y, g:i a' => [
            'date' => "F j, Y",
            'time' => 'g:i a',
            'value' => 'F j, Y, g:i a (EX: March 10, 2001, 5:16 pm)',
        ],
        'Y-m-d H:i:s' => [
            'date' => "Y-m-d",
            'time' => 'H:i:s',
            'value' => 'Y-m-d H:i:s (EX: 2001-03-10 17:16:18)',
        ],
        'h:i A d/m/Y' => [
            'date' => "d/m/Y",
            'time' => 'h:i A',
            'value' => 'h:i A d/m/Y (EX: 17:16 AM 10/03/2022)',
        ],
        'd/m/Y h:i A' => [
            'date' => "d/m/Y",
            'time' => 'h:i A',
            'value' => 'd/m/Y h:i A (EX: 10/03/2022 17:16 AM)',
        ],
        'd F Y, h:i:s A' => [
            'date' => "d F Y",
            'time' => 'h:i:s A',
            'value' => 'd F Y, h:i:s A (EX: 13 September 2018, 11:05:00 AM)',
        ],
    ];

    public function show()
    {
        return view('restaurant.settings.create');
    }

    public function update()
    {
        $request = request();

        $lbl_app_name = strtolower(__('system.fields.app_name'));
        $lbl_app_dark_logo = strtolower(__('system.fields.logo'));
        $lbl_app_light_logo = strtolower(__('system.fields.app_dark_logo'));
        $lbl_app_timezone = strtolower(__('system.fields.app_timezone'));
        $lbl_app_date_time_format = strtolower(__('system.fields.app_date_time_format'));

        $lbl_app_currency = __('system.fields.select_app_currency');
        $lbl_app_defult_language = __('system.fields.select_app_defult_language');
        $lbl_app_favicon_logo = __('system.fields.app_favicon_logo');
        $currencies = getAllCurrencies();
        $langs = getAllLanguages(1);
        $request->validate([
            'app_name' => ['required', 'string', 'min:2'],
            'app_dark_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'app_light_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'app_favicon_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp,ico'],
            'app_timezone' => ['required', 'in:' . implode(',', array_keys(self::GetTimeZones()))],
            'hide_restaurant_after_days' => ['required','integer'],
            'app_date_time_format' => ['required'],
            'currency_position' => ['required', 'in:' . implode(',', array_keys(['left' => 'left', 'right' => 'right']))],
            'app_currency' => ['required', 'in:' . implode(',', array_keys($currencies))],
            'app_defult_language' => ['required', 'in:' . implode(',', array_keys($langs))]
        ], [

            "app_name.required" => __('validation.required', ['attribute' => $lbl_app_name]),
            "app_name.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_name]),
            "app_name.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_name]),

            "app_dark_logo.max" => __('validation.gt.file', ['attribute' => $lbl_app_dark_logo, 'value' => 10000]),
            "app_dark_logo.image" => __('validation.enum', ['attribute' => $lbl_app_dark_logo]),
            "app_dark_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_dark_logo]),

            "app_light_logo.max" => __('validation.gt.file', ['attribute' => $lbl_app_light_logo, 'value' => 10000]),
            "app_light_logo.image" => __('validation.enum', ['attribute' => $lbl_app_light_logo]),
            "app_light_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_light_logo]),

            "app_favicon_logo.max" => __('validation.gt.file', ['attribute' => $lbl_app_favicon_logo, 'value' => 10000]),
            "app_favicon_logo.image" => __('validation.enum', ['attribute' => $lbl_app_favicon_logo]),
            "app_favicon_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_favicon_logo]),

            "app_timezone.required" => __('validation.required', ['attribute' => $lbl_app_timezone]),
            "app_timezone.in" => __('validation.enum', ['attribute' => $lbl_app_timezone]),

            "app_defult_language.required" => __('validation.required', ['attribute' => $lbl_app_defult_language]),
            "app_defult_language.in" => __('validation.enum', ['attribute' => $lbl_app_defult_language]),

            "app_date_time_format.required" => __('validation.required', ['attribute' => $lbl_app_date_time_format]),
            "app_date_time_format.in" => __('validation.enum', ['attribute' => $lbl_app_date_time_format]),

            "app_currency.required" => __('validation.required', ['attribute' => $lbl_app_currency]),

        ]);
        $dates = self::$timeformate[$request->app_date_time_format] ?? null;
        if ($dates == null) {
            $request->validate([
                'app_date_time_format' => ['in:_____'],
            ], [
                "app_timezone.in" => __('validation.enum', ['attribute' => $lbl_app_timezone]),
            ]);
        }
        $data = [
            'SUPPORT_EMAIL' => $request->support_email,
            'SUPPORT_PHONE' => $request->support_phone,
            'HIDE_RESTAURANT' => $request->hide_restaurant_after_days,
            'FACEBOOK_URL' => $request->facebook_url,
            'INSTAGRAM_URL' => $request->instagram_url,
            'TWITTER_URL' => $request->twitter_url,
            'YOUTUBE_URL' => $request->youtube_url,
            'LINKEDIN_URL' => $request->linkedin_url,

            'CURRENCY_POSITION' => $request->currency_position,
            'APP_NAME' => $request->app_name,
            'APP_DATE_TIME_FORMAT' => $request->app_date_time_format,
            'APP_DATE_FORMAT' => $dates['date'],
            'APP_TIME_FORMAT' => $dates['time'],
            'APP_TIMEZONE' => $request->app_timezone,

            'APP_SET_DEFAULT_LANGUAGE' => $request->app_defult_language,
            'APP_CURRENCY' => $request->app_currency,
            'APP_CURRENCY_SYMBOL' => explode(' - ', $currencies[$request->app_currency])[0],
        ];

        if ($request->has('app_light_logo')) {
            $data['APP_LIGHT_SMALL_LOGO'] = '/storage/' . uploadFile($request->app_light_logo, 'logo');
        }

        if ($request->has('app_dark_logo')) {
            $data['APP_DARK_SMALL_LOGO'] = '/storage/' . uploadFile($request->app_dark_logo, 'logo');
        }

        if ($request->has('app_favicon_logo')) {
            $data['APP_FAVICON_ICON'] = '/storage/' . uploadFile($request->app_favicon_logo, 'logo');
        }

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }

    public static function GetTimeZones()
    {
        return [
            'Africa/Abidjan' => 'UTC/GMT +00:00 - Africa/Abidjan',
            'Africa/Accra' => 'UTC/GMT +00:00 - Africa/Accra',
            'Africa/Addis_Ababa' => 'UTC/GMT +03:00 - Africa/Addis_Ababa',
            'Africa/Algiers' => 'UTC/GMT +01:00 - Africa/Algiers',
            'Africa/Asmara' => 'UTC/GMT +03:00 - Africa/Asmara',
            'Africa/Bamako' => 'UTC/GMT +00:00 - Africa/Bamako',
            'Africa/Bangui' => 'UTC/GMT +01:00 - Africa/Bangui',
            'Africa/Banjul' => 'UTC/GMT +00:00 - Africa/Banjul',
            'Africa/Bissau' => 'UTC/GMT +00:00 - Africa/Bissau',
            'Africa/Blantyre' => 'UTC/GMT +02:00 - Africa/Blantyre',
            'Africa/Brazzaville' => 'UTC/GMT +01:00 - Africa/Brazzaville',
            'Africa/Bujumbura' => 'UTC/GMT +02:00 - Africa/Bujumbura',
            'Africa/Cairo' => 'UTC/GMT +02:00 - Africa/Cairo',
            'Africa/Casablanca' => 'UTC/GMT +01:00 - Africa/Casablanca',
            'Africa/Ceuta' => 'UTC/GMT +02:00 - Africa/Ceuta',
            'Africa/Conakry' => 'UTC/GMT +00:00 - Africa/Conakry',
            'Africa/Dakar' => 'UTC/GMT +00:00 - Africa/Dakar',
            'Africa/Dar_es_Salaam' => 'UTC/GMT +03:00 - Africa/Dar_es_Salaam',
            'Africa/Djibouti' => 'UTC/GMT +03:00 - Africa/Djibouti',
            'Africa/Douala' => 'UTC/GMT +01:00 - Africa/Douala',
            'Africa/El_Aaiun' => 'UTC/GMT +01:00 - Africa/El_Aaiun',
            'Africa/Freetown' => 'UTC/GMT +00:00 - Africa/Freetown',
            'Africa/Gaborone' => 'UTC/GMT +02:00 - Africa/Gaborone',
            'Africa/Harare' => 'UTC/GMT +02:00 - Africa/Harare',
            'Africa/Johannesburg' => 'UTC/GMT +02:00 - Africa/Johannesburg',
            'Africa/Juba' => 'UTC/GMT +02:00 - Africa/Juba',
            'Africa/Kampala' => 'UTC/GMT +03:00 - Africa/Kampala',
            'Africa/Khartoum' => 'UTC/GMT +02:00 - Africa/Khartoum',
            'Africa/Kigali' => 'UTC/GMT +02:00 - Africa/Kigali',
            'Africa/Kinshasa' => 'UTC/GMT +01:00 - Africa/Kinshasa',
            'Africa/Lagos' => 'UTC/GMT +01:00 - Africa/Lagos',
            'Africa/Libreville' => 'UTC/GMT +01:00 - Africa/Libreville',
            'Africa/Lome' => 'UTC/GMT +00:00 - Africa/Lome',
            'Africa/Luanda' => 'UTC/GMT +01:00 - Africa/Luanda',
            'Africa/Lubumbashi' => 'UTC/GMT +02:00 - Africa/Lubumbashi',
            'Africa/Lusaka' => 'UTC/GMT +02:00 - Africa/Lusaka',
            'Africa/Malabo' => 'UTC/GMT +01:00 - Africa/Malabo',
            'Africa/Maputo' => 'UTC/GMT +02:00 - Africa/Maputo',
            'Africa/Maseru' => 'UTC/GMT +02:00 - Africa/Maseru',
            'Africa/Mbabane' => 'UTC/GMT +02:00 - Africa/Mbabane',
            'Africa/Mogadishu' => 'UTC/GMT +03:00 - Africa/Mogadishu',
            'Africa/Monrovia' => 'UTC/GMT +00:00 - Africa/Monrovia',
            'Africa/Nairobi' => 'UTC/GMT +03:00 - Africa/Nairobi',
            'Africa/Ndjamena' => 'UTC/GMT +01:00 - Africa/Ndjamena',
            'Africa/Niamey' => 'UTC/GMT +01:00 - Africa/Niamey',
            'Africa/Nouakchott' => 'UTC/GMT +00:00 - Africa/Nouakchott',
            'Africa/Ouagadougou' => 'UTC/GMT +00:00 - Africa/Ouagadougou',
            'Africa/Porto-Novo' => 'UTC/GMT +01:00 - Africa/Porto-Novo',
            'Africa/Sao_Tome' => 'UTC/GMT +00:00 - Africa/Sao_Tome',
            'Africa/Tripoli' => 'UTC/GMT +02:00 - Africa/Tripoli',
            'Africa/Tunis' => 'UTC/GMT +01:00 - Africa/Tunis',
            'Africa/Windhoek' => 'UTC/GMT +02:00 - Africa/Windhoek',
            'America/Adak' => 'UTC/GMT -09:00 - America/Adak',
            'America/Anchorage' => 'UTC/GMT -08:00 - America/Anchorage',
            'America/Anguilla' => 'UTC/GMT -04:00 - America/Anguilla',
            'America/Antigua' => 'UTC/GMT -04:00 - America/Antigua',
            'America/Araguaina' => 'UTC/GMT -03:00 - America/Araguaina',
            'America/Argentina/Buenos_Aires' => 'UTC/GMT -03:00 - America/Argentina/Buenos_Aires',
            'America/Argentina/Catamarca' => 'UTC/GMT -03:00 - America/Argentina/Catamarca',
            'America/Argentina/Cordoba' => 'UTC/GMT -03:00 - America/Argentina/Cordoba',
            'America/Argentina/Jujuy' => 'UTC/GMT -03:00 - America/Argentina/Jujuy',
            'America/Argentina/La_Rioja' => 'UTC/GMT -03:00 - America/Argentina/La_Rioja',
            'America/Argentina/Mendoza' => 'UTC/GMT -03:00 - America/Argentina/Mendoza',
            'America/Argentina/Rio_Gallegos' => 'UTC/GMT -03:00 - America/Argentina/Rio_Gallegos',
            'America/Argentina/Salta' => 'UTC/GMT -03:00 - America/Argentina/Salta',
            'America/Argentina/San_Juan' => 'UTC/GMT -03:00 - America/Argentina/San_Juan',
            'America/Argentina/San_Luis' => 'UTC/GMT -03:00 - America/Argentina/San_Luis',
            'America/Argentina/Tucuman' => 'UTC/GMT -03:00 - America/Argentina/Tucuman',
            'America/Argentina/Ushuaia' => 'UTC/GMT -03:00 - America/Argentina/Ushuaia',
            'America/Aruba' => 'UTC/GMT -04:00 - America/Aruba',
            'America/Asuncion' => 'UTC/GMT -04:00 - America/Asuncion',
            'America/Atikokan' => 'UTC/GMT -05:00 - America/Atikokan',
            'America/Bahia' => 'UTC/GMT -03:00 - America/Bahia',
            'America/Bahia_Banderas' => 'UTC/GMT -05:00 - America/Bahia_Banderas',
            'America/Barbados' => 'UTC/GMT -04:00 - America/Barbados',
            'America/Belem' => 'UTC/GMT -03:00 - America/Belem',
            'America/Belize' => 'UTC/GMT -06:00 - America/Belize',
            'America/Blanc-Sablon' => 'UTC/GMT -04:00 - America/Blanc-Sablon',
            'America/Boa_Vista' => 'UTC/GMT -04:00 - America/Boa_Vista',
            'America/Bogota' => 'UTC/GMT -05:00 - America/Bogota',
            'America/Boise' => 'UTC/GMT -06:00 - America/Boise',
            'America/Cambridge_Bay' => 'UTC/GMT -06:00 - America/Cambridge_Bay',
            'America/Campo_Grande' => 'UTC/GMT -04:00 - America/Campo_Grande',
            'America/Cancun' => 'UTC/GMT -05:00 - America/Cancun',
            'America/Caracas' => 'UTC/GMT -04:00 - America/Caracas',
            'America/Cayenne' => 'UTC/GMT -03:00 - America/Cayenne',
            'America/Cayman' => 'UTC/GMT -05:00 - America/Cayman',
            'America/Chicago' => 'UTC/GMT -05:00 - America/Chicago',
            'America/Chihuahua' => 'UTC/GMT -06:00 - America/Chihuahua',
            'America/Costa_Rica' => 'UTC/GMT -06:00 - America/Costa_Rica',
            'America/Creston' => 'UTC/GMT -07:00 - America/Creston',
            'America/Cuiaba' => 'UTC/GMT -04:00 - America/Cuiaba',
            'America/Curacao' => 'UTC/GMT -04:00 - America/Curacao',
            'America/Danmarkshavn' => 'UTC/GMT +00:00 - America/Danmarkshavn',
            'America/Dawson' => 'UTC/GMT -07:00 - America/Dawson',
            'America/Dawson_Creek' => 'UTC/GMT -07:00 - America/Dawson_Creek',
            'America/Denver' => 'UTC/GMT -06:00 - America/Denver',
            'America/Detroit' => 'UTC/GMT -04:00 - America/Detroit',
            'America/Dominica' => 'UTC/GMT -04:00 - America/Dominica',
            'America/Edmonton' => 'UTC/GMT -06:00 - America/Edmonton',
            'America/Eirunepe' => 'UTC/GMT -05:00 - America/Eirunepe',
            'America/El_Salvador' => 'UTC/GMT -06:00 - America/El_Salvador',
            'America/Fort_Nelson' => 'UTC/GMT -07:00 - America/Fort_Nelson',
            'America/Fortaleza' => 'UTC/GMT -03:00 - America/Fortaleza',
            'America/Glace_Bay' => 'UTC/GMT -03:00 - America/Glace_Bay',
            'America/Goose_Bay' => 'UTC/GMT -03:00 - America/Goose_Bay',
            'America/Grand_Turk' => 'UTC/GMT -04:00 - America/Grand_Turk',
            'America/Grenada' => 'UTC/GMT -04:00 - America/Grenada',
            'America/Guadeloupe' => 'UTC/GMT -04:00 - America/Guadeloupe',
            'America/Guatemala' => 'UTC/GMT -06:00 - America/Guatemala',
            'America/Guayaquil' => 'UTC/GMT -05:00 - America/Guayaquil',
            'America/Guyana' => 'UTC/GMT -04:00 - America/Guyana',
            'America/Halifax' => 'UTC/GMT -03:00 - America/Halifax',
            'America/Havana' => 'UTC/GMT -04:00 - America/Havana',
            'America/Hermosillo' => 'UTC/GMT -07:00 - America/Hermosillo',
            'America/Indiana/Indianapolis' => 'UTC/GMT -04:00 - America/Indiana/Indianapolis',
            'America/Indiana/Knox' => 'UTC/GMT -05:00 - America/Indiana/Knox',
            'America/Indiana/Marengo' => 'UTC/GMT -04:00 - America/Indiana/Marengo',
            'America/Indiana/Petersburg' => 'UTC/GMT -04:00 - America/Indiana/Petersburg',
            'America/Indiana/Tell_City' => 'UTC/GMT -05:00 - America/Indiana/Tell_City',
            'America/Indiana/Vevay' => 'UTC/GMT -04:00 - America/Indiana/Vevay',
            'America/Indiana/Vincennes' => 'UTC/GMT -04:00 - America/Indiana/Vincennes',
            'America/Indiana/Winamac' => 'UTC/GMT -04:00 - America/Indiana/Winamac',
            'America/Inuvik' => 'UTC/GMT -06:00 - America/Inuvik',
            'America/Iqaluit' => 'UTC/GMT -04:00 - America/Iqaluit',
            'America/Jamaica' => 'UTC/GMT -05:00 - America/Jamaica',
            'America/Juneau' => 'UTC/GMT -08:00 - America/Juneau',
            'America/Kentucky/Louisville' => 'UTC/GMT -04:00 - America/Kentucky/Louisville',
            'America/Kentucky/Monticello' => 'UTC/GMT -04:00 - America/Kentucky/Monticello',
            'America/Kralendijk' => 'UTC/GMT -04:00 - America/Kralendijk',
            'America/La_Paz' => 'UTC/GMT -04:00 - America/La_Paz',
            'America/Lima' => 'UTC/GMT -05:00 - America/Lima',
            'America/Los_Angeles' => 'UTC/GMT -07:00 - America/Los_Angeles',
            'America/Lower_Princes' => 'UTC/GMT -04:00 - America/Lower_Princes',
            'America/Maceio' => 'UTC/GMT -03:00 - America/Maceio',
            'America/Managua' => 'UTC/GMT -06:00 - America/Managua',
            'America/Manaus' => 'UTC/GMT -04:00 - America/Manaus',
            'America/Marigot' => 'UTC/GMT -04:00 - America/Marigot',
            'America/Martinique' => 'UTC/GMT -04:00 - America/Martinique',
            'America/Matamoros' => 'UTC/GMT -05:00 - America/Matamoros',
            'America/Mazatlan' => 'UTC/GMT -06:00 - America/Mazatlan',
            'America/Menominee' => 'UTC/GMT -05:00 - America/Menominee',
            'America/Merida' => 'UTC/GMT -05:00 - America/Merida',
            'America/Metlakatla' => 'UTC/GMT -08:00 - America/Metlakatla',
            'America/Mexico_City' => 'UTC/GMT -05:00 - America/Mexico_City',
            'America/Miquelon' => 'UTC/GMT -02:00 - America/Miquelon',
            'America/Moncton' => 'UTC/GMT -03:00 - America/Moncton',
            'America/Monterrey' => 'UTC/GMT -05:00 - America/Monterrey',
            'America/Montevideo' => 'UTC/GMT -03:00 - America/Montevideo',
            'America/Montserrat' => 'UTC/GMT -04:00 - America/Montserrat',
            'America/Nassau' => 'UTC/GMT -04:00 - America/Nassau',
            'America/New_York' => 'UTC/GMT -04:00 - America/New_York',
            'America/Nipigon' => 'UTC/GMT -04:00 - America/Nipigon',
            'America/Nome' => 'UTC/GMT -08:00 - America/Nome',
            'America/Noronha' => 'UTC/GMT -02:00 - America/Noronha',
            'America/North_Dakota/Beulah' => 'UTC/GMT -05:00 - America/North_Dakota/Beulah',
            'America/North_Dakota/Center' => 'UTC/GMT -05:00 - America/North_Dakota/Center',
            'America/North_Dakota/New_Salem' => 'UTC/GMT -05:00 - America/North_Dakota/New_Salem',
            'America/Nuuk' => 'UTC/GMT -02:00 - America/Nuuk',
            'America/Ojinaga' => 'UTC/GMT -06:00 - America/Ojinaga',
            'America/Panama' => 'UTC/GMT -05:00 - America/Panama',
            'America/Pangnirtung' => 'UTC/GMT -04:00 - America/Pangnirtung',
            'America/Paramaribo' => 'UTC/GMT -03:00 - America/Paramaribo',
            'America/Phoenix' => 'UTC/GMT -07:00 - America/Phoenix',
            'America/Port-au-Prince' => 'UTC/GMT -04:00 - America/Port-au-Prince',
            'America/Port_of_Spain' => 'UTC/GMT -04:00 - America/Port_of_Spain',
            'America/Porto_Velho' => 'UTC/GMT -04:00 - America/Porto_Velho',
            'America/Puerto_Rico' => 'UTC/GMT -04:00 - America/Puerto_Rico',
            'America/Punta_Arenas' => 'UTC/GMT -03:00 - America/Punta_Arenas',
            'America/Rainy_River' => 'UTC/GMT -05:00 - America/Rainy_River',
            'America/Rankin_Inlet' => 'UTC/GMT -05:00 - America/Rankin_Inlet',
            'America/Recife' => 'UTC/GMT -03:00 - America/Recife',
            'America/Regina' => 'UTC/GMT -06:00 - America/Regina',
            'America/Resolute' => 'UTC/GMT -05:00 - America/Resolute',
            'America/Rio_Branco' => 'UTC/GMT -05:00 - America/Rio_Branco',
            'America/Santarem' => 'UTC/GMT -03:00 - America/Santarem',
            'America/Santiago' => 'UTC/GMT -04:00 - America/Santiago',
            'America/Santo_Domingo' => 'UTC/GMT -04:00 - America/Santo_Domingo',
            'America/Sao_Paulo' => 'UTC/GMT -03:00 - America/Sao_Paulo',
            'America/Scoresbysund' => 'UTC/GMT +00:00 - America/Scoresbysund',
            'America/Sitka' => 'UTC/GMT -08:00 - America/Sitka',
            'America/St_Barthelemy' => 'UTC/GMT -04:00 - America/St_Barthelemy',
            'America/St_Johns' => 'UTC/GMT -02:30 - America/St_Johns',
            'America/St_Kitts' => 'UTC/GMT -04:00 - America/St_Kitts',
            'America/St_Lucia' => 'UTC/GMT -04:00 - America/St_Lucia',
            'America/St_Thomas' => 'UTC/GMT -04:00 - America/St_Thomas',
            'America/St_Vincent' => 'UTC/GMT -04:00 - America/St_Vincent',
            'America/Swift_Current' => 'UTC/GMT -06:00 - America/Swift_Current',
            'America/Tegucigalpa' => 'UTC/GMT -06:00 - America/Tegucigalpa',
            'America/Thule' => 'UTC/GMT -03:00 - America/Thule',
            'America/Thunder_Bay' => 'UTC/GMT -04:00 - America/Thunder_Bay',
            'America/Tijuana' => 'UTC/GMT -07:00 - America/Tijuana',
            'America/Toronto' => 'UTC/GMT -04:00 - America/Toronto',
            'America/Tortola' => 'UTC/GMT -04:00 - America/Tortola',
            'America/Vancouver' => 'UTC/GMT -07:00 - America/Vancouver',
            'America/Whitehorse' => 'UTC/GMT -07:00 - America/Whitehorse',
            'America/Winnipeg' => 'UTC/GMT -05:00 - America/Winnipeg',
            'America/Yakutat' => 'UTC/GMT -08:00 - America/Yakutat',
            'America/Yellowknife' => 'UTC/GMT -06:00 - America/Yellowknife',
            'Antarctica/Casey' => 'UTC/GMT +11:00 - Antarctica/Casey',
            'Antarctica/Davis' => 'UTC/GMT +07:00 - Antarctica/Davis',
            'Antarctica/DumontDUrville' => 'UTC/GMT +10:00 - Antarctica/DumontDUrville',
            'Antarctica/Macquarie' => 'UTC/GMT +10:00 - Antarctica/Macquarie',
            'Antarctica/Mawson' => 'UTC/GMT +05:00 - Antarctica/Mawson',
            'Antarctica/McMurdo' => 'UTC/GMT +12:00 - Antarctica/McMurdo',
            'Antarctica/Palmer' => 'UTC/GMT -03:00 - Antarctica/Palmer',
            'Antarctica/Rothera' => 'UTC/GMT -03:00 - Antarctica/Rothera',
            'Antarctica/Syowa' => 'UTC/GMT +03:00 - Antarctica/Syowa',
            'Antarctica/Troll' => 'UTC/GMT +02:00 - Antarctica/Troll',
            'Antarctica/Vostok' => 'UTC/GMT +06:00 - Antarctica/Vostok',
            'Arctic/Longyearbyen' => 'UTC/GMT +02:00 - Arctic/Longyearbyen',
            'Asia/Aden' => 'UTC/GMT +03:00 - Asia/Aden',
            'Asia/Almaty' => 'UTC/GMT +06:00 - Asia/Almaty',
            'Asia/Amman' => 'UTC/GMT +03:00 - Asia/Amman',
            'Asia/Anadyr' => 'UTC/GMT +12:00 - Asia/Anadyr',
            'Asia/Aqtau' => 'UTC/GMT +05:00 - Asia/Aqtau',
            'Asia/Aqtobe' => 'UTC/GMT +05:00 - Asia/Aqtobe',
            'Asia/Ashgabat' => 'UTC/GMT +05:00 - Asia/Ashgabat',
            'Asia/Atyrau' => 'UTC/GMT +05:00 - Asia/Atyrau',
            'Asia/Baghdad' => 'UTC/GMT +03:00 - Asia/Baghdad',
            'Asia/Bahrain' => 'UTC/GMT +03:00 - Asia/Bahrain',
            'Asia/Baku' => 'UTC/GMT +04:00 - Asia/Baku',
            'Asia/Bangkok' => 'UTC/GMT +07:00 - Asia/Bangkok',
            'Asia/Barnaul' => 'UTC/GMT +07:00 - Asia/Barnaul',
            'Asia/Beirut' => 'UTC/GMT +03:00 - Asia/Beirut',
            'Asia/Bishkek' => 'UTC/GMT +06:00 - Asia/Bishkek',
            'Asia/Brunei' => 'UTC/GMT +08:00 - Asia/Brunei',
            'Asia/Chita' => 'UTC/GMT +09:00 - Asia/Chita',
            'Asia/Choibalsan' => 'UTC/GMT +08:00 - Asia/Choibalsan',
            'Asia/Colombo' => 'UTC/GMT +05:30 - Asia/Colombo',
            'Asia/Damascus' => 'UTC/GMT +03:00 - Asia/Damascus',
            'Asia/Dhaka' => 'UTC/GMT +06:00 - Asia/Dhaka',
            'Asia/Dili' => 'UTC/GMT +09:00 - Asia/Dili',
            'Asia/Dubai' => 'UTC/GMT +04:00 - Asia/Dubai',
            'Asia/Dushanbe' => 'UTC/GMT +05:00 - Asia/Dushanbe',
            'Asia/Famagusta' => 'UTC/GMT +03:00 - Asia/Famagusta',
            'Asia/Gaza' => 'UTC/GMT +03:00 - Asia/Gaza',
            'Asia/Hebron' => 'UTC/GMT +03:00 - Asia/Hebron',
            'Asia/Ho_Chi_Minh' => 'UTC/GMT +07:00 - Asia/Ho_Chi_Minh',
            'Asia/Hong_Kong' => 'UTC/GMT +08:00 - Asia/Hong_Kong',
            'Asia/Hovd' => 'UTC/GMT +07:00 - Asia/Hovd',
            'Asia/Irkutsk' => 'UTC/GMT +08:00 - Asia/Irkutsk',
            'Asia/Jakarta' => 'UTC/GMT +07:00 - Asia/Jakarta',
            'Asia/Jayapura' => 'UTC/GMT +09:00 - Asia/Jayapura',
            'Asia/Jerusalem' => 'UTC/GMT +03:00 - Asia/Jerusalem',
            'Asia/Kabul' => 'UTC/GMT +04:30 - Asia/Kabul',
            'Asia/Kamchatka' => 'UTC/GMT +12:00 - Asia/Kamchatka',
            'Asia/Karachi' => 'UTC/GMT +05:00 - Asia/Karachi',
            'Asia/Kathmandu' => 'UTC/GMT +05:45 - Asia/Kathmandu',
            'Asia/Khandyga' => 'UTC/GMT +09:00 - Asia/Khandyga',
            'Asia/Kolkata' => 'UTC/GMT +05:30 - Asia/Kolkata',
            'Asia/Krasnoyarsk' => 'UTC/GMT +07:00 - Asia/Krasnoyarsk',
            'Asia/Kuala_Lumpur' => 'UTC/GMT +08:00 - Asia/Kuala_Lumpur',
            'Asia/Kuching' => 'UTC/GMT +08:00 - Asia/Kuching',
            'Asia/Kuwait' => 'UTC/GMT +03:00 - Asia/Kuwait',
            'Asia/Macau' => 'UTC/GMT +08:00 - Asia/Macau',
            'Asia/Magadan' => 'UTC/GMT +11:00 - Asia/Magadan',
            'Asia/Makassar' => 'UTC/GMT +08:00 - Asia/Makassar',
            'Asia/Manila' => 'UTC/GMT +08:00 - Asia/Manila',
            'Asia/Muscat' => 'UTC/GMT +04:00 - Asia/Muscat',
            'Asia/Nicosia' => 'UTC/GMT +03:00 - Asia/Nicosia',
            'Asia/Novokuznetsk' => 'UTC/GMT +07:00 - Asia/Novokuznetsk',
            'Asia/Novosibirsk' => 'UTC/GMT +07:00 - Asia/Novosibirsk',
            'Asia/Omsk' => 'UTC/GMT +06:00 - Asia/Omsk',
            'Asia/Oral' => 'UTC/GMT +05:00 - Asia/Oral',
            'Asia/Phnom_Penh' => 'UTC/GMT +07:00 - Asia/Phnom_Penh',
            'Asia/Pontianak' => 'UTC/GMT +07:00 - Asia/Pontianak',
            'Asia/Pyongyang' => 'UTC/GMT +09:00 - Asia/Pyongyang',
            'Asia/Qatar' => 'UTC/GMT +03:00 - Asia/Qatar',
            'Asia/Qostanay' => 'UTC/GMT +06:00 - Asia/Qostanay',
            'Asia/Qyzylorda' => 'UTC/GMT +05:00 - Asia/Qyzylorda',
            'Asia/Riyadh' => 'UTC/GMT +03:00 - Asia/Riyadh',
            'Asia/Sakhalin' => 'UTC/GMT +11:00 - Asia/Sakhalin',
            'Asia/Samarkand' => 'UTC/GMT +05:00 - Asia/Samarkand',
            'Asia/Seoul' => 'UTC/GMT +09:00 - Asia/Seoul',
            'Asia/Shanghai' => 'UTC/GMT +08:00 - Asia/Shanghai',
            'Asia/Singapore' => 'UTC/GMT +08:00 - Asia/Singapore',
            'Asia/Srednekolymsk' => 'UTC/GMT +11:00 - Asia/Srednekolymsk',
            'Asia/Taipei' => 'UTC/GMT +08:00 - Asia/Taipei',
            'Asia/Tashkent' => 'UTC/GMT +05:00 - Asia/Tashkent',
            'Asia/Tbilisi' => 'UTC/GMT +04:00 - Asia/Tbilisi',
            'Asia/Tehran' => 'UTC/GMT +04:30 - Asia/Tehran',
            'Asia/Thimphu' => 'UTC/GMT +06:00 - Asia/Thimphu',
            'Asia/Tokyo' => 'UTC/GMT +09:00 - Asia/Tokyo',
            'Asia/Tomsk' => 'UTC/GMT +07:00 - Asia/Tomsk',
            'Asia/Ulaanbaatar' => 'UTC/GMT +08:00 - Asia/Ulaanbaatar',
            'Asia/Urumqi' => 'UTC/GMT +06:00 - Asia/Urumqi',
            'Asia/Ust-Nera' => 'UTC/GMT +10:00 - Asia/Ust-Nera',
            'Asia/Vientiane' => 'UTC/GMT +07:00 - Asia/Vientiane',
            'Asia/Vladivostok' => 'UTC/GMT +10:00 - Asia/Vladivostok',
            'Asia/Yakutsk' => 'UTC/GMT +09:00 - Asia/Yakutsk',
            'Asia/Yangon' => 'UTC/GMT +06:30 - Asia/Yangon',
            'Asia/Yekaterinburg' => 'UTC/GMT +05:00 - Asia/Yekaterinburg',
            'Asia/Yerevan' => 'UTC/GMT +04:00 - Asia/Yerevan',
            'Atlantic/Azores' => 'UTC/GMT +00:00 - Atlantic/Azores',
            'Atlantic/Bermuda' => 'UTC/GMT -03:00 - Atlantic/Bermuda',
            'Atlantic/Canary' => 'UTC/GMT +01:00 - Atlantic/Canary',
            'Atlantic/Cape_Verde' => 'UTC/GMT -01:00 - Atlantic/Cape_Verde',
            'Atlantic/Faroe' => 'UTC/GMT +01:00 - Atlantic/Faroe',
            'Atlantic/Madeira' => 'UTC/GMT +01:00 - Atlantic/Madeira',
            'Atlantic/Reykjavik' => 'UTC/GMT +00:00 - Atlantic/Reykjavik',
            'Atlantic/South_Georgia' => 'UTC/GMT -02:00 - Atlantic/South_Georgia',
            'Atlantic/St_Helena' => 'UTC/GMT +00:00 - Atlantic/St_Helena',
            'Atlantic/Stanley' => 'UTC/GMT -03:00 - Atlantic/Stanley',
            'Australia/Adelaide' => 'UTC/GMT +09:30 - Australia/Adelaide',
            'Australia/Brisbane' => 'UTC/GMT +10:00 - Australia/Brisbane',
            'Australia/Broken_Hill' => 'UTC/GMT +09:30 - Australia/Broken_Hill',
            'Australia/Darwin' => 'UTC/GMT +09:30 - Australia/Darwin',
            'Australia/Eucla' => 'UTC/GMT +08:45 - Australia/Eucla',
            'Australia/Hobart' => 'UTC/GMT +10:00 - Australia/Hobart',
            'Australia/Lindeman' => 'UTC/GMT +10:00 - Australia/Lindeman',
            'Australia/Lord_Howe' => 'UTC/GMT +10:30 - Australia/Lord_Howe',
            'Australia/Melbourne' => 'UTC/GMT +10:00 - Australia/Melbourne',
            'Australia/Perth' => 'UTC/GMT +08:00 - Australia/Perth',
            'Australia/Sydney' => 'UTC/GMT +10:00 - Australia/Sydney',
            'Europe/Amsterdam' => 'UTC/GMT +02:00 - Europe/Amsterdam',
            'Europe/Andorra' => 'UTC/GMT +02:00 - Europe/Andorra',
            'Europe/Astrakhan' => 'UTC/GMT +04:00 - Europe/Astrakhan',
            'Europe/Athens' => 'UTC/GMT +03:00 - Europe/Athens',
            'Europe/Belgrade' => 'UTC/GMT +02:00 - Europe/Belgrade',
            'Europe/Berlin' => 'UTC/GMT +02:00 - Europe/Berlin',
            'Europe/Bratislava' => 'UTC/GMT +02:00 - Europe/Bratislava',
            'Europe/Brussels' => 'UTC/GMT +02:00 - Europe/Brussels',
            'Europe/Bucharest' => 'UTC/GMT +03:00 - Europe/Bucharest',
            'Europe/Budapest' => 'UTC/GMT +02:00 - Europe/Budapest',
            'Europe/Busingen' => 'UTC/GMT +02:00 - Europe/Busingen',
            'Europe/Chisinau' => 'UTC/GMT +03:00 - Europe/Chisinau',
            'Europe/Copenhagen' => 'UTC/GMT +02:00 - Europe/Copenhagen',
            'Europe/Dublin' => 'UTC/GMT +01:00 - Europe/Dublin',
            'Europe/Gibraltar' => 'UTC/GMT +02:00 - Europe/Gibraltar',
            'Europe/Guernsey' => 'UTC/GMT +01:00 - Europe/Guernsey',
            'Europe/Helsinki' => 'UTC/GMT +03:00 - Europe/Helsinki',
            'Europe/Isle_of_Man' => 'UTC/GMT +01:00 - Europe/Isle_of_Man',
            'Europe/Istanbul' => 'UTC/GMT +03:00 - Europe/Istanbul',
            'Europe/Jersey' => 'UTC/GMT +01:00 - Europe/Jersey',
            'Europe/Kaliningrad' => 'UTC/GMT +02:00 - Europe/Kaliningrad',
            'Europe/Kiev' => 'UTC/GMT +03:00 - Europe/Kiev',
            'Europe/Kirov' => 'UTC/GMT +03:00 - Europe/Kirov',
            'Europe/Lisbon' => 'UTC/GMT +01:00 - Europe/Lisbon',
            'Europe/Ljubljana' => 'UTC/GMT +02:00 - Europe/Ljubljana',
            'Europe/London' => 'UTC/GMT +01:00 - Europe/London',
            'Europe/Luxembourg' => 'UTC/GMT +02:00 - Europe/Luxembourg',
            'Europe/Madrid' => 'UTC/GMT +02:00 - Europe/Madrid',
            'Europe/Malta' => 'UTC/GMT +02:00 - Europe/Malta',
            'Europe/Mariehamn' => 'UTC/GMT +03:00 - Europe/Mariehamn',
            'Europe/Minsk' => 'UTC/GMT +03:00 - Europe/Minsk',
            'Europe/Monaco' => 'UTC/GMT +02:00 - Europe/Monaco',
            'Europe/Moscow' => 'UTC/GMT +03:00 - Europe/Moscow',
            'Europe/Oslo' => 'UTC/GMT +02:00 - Europe/Oslo',
            'Europe/Paris' => 'UTC/GMT +02:00 - Europe/Paris',
            'Europe/Podgorica' => 'UTC/GMT +02:00 - Europe/Podgorica',
            'Europe/Prague' => 'UTC/GMT +02:00 - Europe/Prague',
            'Europe/Riga' => 'UTC/GMT +03:00 - Europe/Riga',
            'Europe/Rome' => 'UTC/GMT +02:00 - Europe/Rome',
            'Europe/Samara' => 'UTC/GMT +04:00 - Europe/Samara',
            'Europe/San_Marino' => 'UTC/GMT +02:00 - Europe/San_Marino',
            'Europe/Sarajevo' => 'UTC/GMT +02:00 - Europe/Sarajevo',
            'Europe/Saratov' => 'UTC/GMT +04:00 - Europe/Saratov',
            'Europe/Simferopol' => 'UTC/GMT +03:00 - Europe/Simferopol',
            'Europe/Skopje' => 'UTC/GMT +02:00 - Europe/Skopje',
            'Europe/Sofia' => 'UTC/GMT +03:00 - Europe/Sofia',
            'Europe/Stockholm' => 'UTC/GMT +02:00 - Europe/Stockholm',
            'Europe/Tallinn' => 'UTC/GMT +03:00 - Europe/Tallinn',
            'Europe/Tirane' => 'UTC/GMT +02:00 - Europe/Tirane',
            'Europe/Ulyanovsk' => 'UTC/GMT +04:00 - Europe/Ulyanovsk',
            'Europe/Uzhgorod' => 'UTC/GMT +03:00 - Europe/Uzhgorod',
            'Europe/Vaduz' => 'UTC/GMT +02:00 - Europe/Vaduz',
            'Europe/Vatican' => 'UTC/GMT +02:00 - Europe/Vatican',
            'Europe/Vienna' => 'UTC/GMT +02:00 - Europe/Vienna',
            'Europe/Vilnius' => 'UTC/GMT +03:00 - Europe/Vilnius',
            'Europe/Volgograd' => 'UTC/GMT +03:00 - Europe/Volgograd',
            'Europe/Warsaw' => 'UTC/GMT +02:00 - Europe/Warsaw',
            'Europe/Zagreb' => 'UTC/GMT +02:00 - Europe/Zagreb',
            'Europe/Zaporozhye' => 'UTC/GMT +03:00 - Europe/Zaporozhye',
            'Europe/Zurich' => 'UTC/GMT +02:00 - Europe/Zurich',
            'Indian/Antananarivo' => 'UTC/GMT +03:00 - Indian/Antananarivo',
            'Indian/Chagos' => 'UTC/GMT +06:00 - Indian/Chagos',
            'Indian/Christmas' => 'UTC/GMT +07:00 - Indian/Christmas',
            'Indian/Cocos' => 'UTC/GMT +06:30 - Indian/Cocos',
            'Indian/Comoro' => 'UTC/GMT +03:00 - Indian/Comoro',
            'Indian/Kerguelen' => 'UTC/GMT +05:00 - Indian/Kerguelen',
            'Indian/Mahe' => 'UTC/GMT +04:00 - Indian/Mahe',
            'Indian/Maldives' => 'UTC/GMT +05:00 - Indian/Maldives',
            'Indian/Mauritius' => 'UTC/GMT +04:00 - Indian/Mauritius',
            'Indian/Mayotte' => 'UTC/GMT +03:00 - Indian/Mayotte',
            'Indian/Reunion' => 'UTC/GMT +04:00 - Indian/Reunion',
            'Pacific/Apia' => 'UTC/GMT +13:00 - Pacific/Apia',
            'Pacific/Auckland' => 'UTC/GMT +12:00 - Pacific/Auckland',
            'Pacific/Bougainville' => 'UTC/GMT +11:00 - Pacific/Bougainville',
            'Pacific/Chatham' => 'UTC/GMT +12:45 - Pacific/Chatham',
            'Pacific/Chuuk' => 'UTC/GMT +10:00 - Pacific/Chuuk',
            'Pacific/Easter' => 'UTC/GMT -06:00 - Pacific/Easter',
            'Pacific/Efate' => 'UTC/GMT +11:00 - Pacific/Efate',
            'Pacific/Fakaofo' => 'UTC/GMT +13:00 - Pacific/Fakaofo',
            'Pacific/Fiji' => 'UTC/GMT +12:00 - Pacific/Fiji',
            'Pacific/Funafuti' => 'UTC/GMT +12:00 - Pacific/Funafuti',
            'Pacific/Galapagos' => 'UTC/GMT -06:00 - Pacific/Galapagos',
            'Pacific/Gambier' => 'UTC/GMT -09:00 - Pacific/Gambier',
            'Pacific/Guadalcanal' => 'UTC/GMT +11:00 - Pacific/Guadalcanal',
            'Pacific/Guam' => 'UTC/GMT +10:00 - Pacific/Guam',
            'Pacific/Honolulu' => 'UTC/GMT -10:00 - Pacific/Honolulu',
            'Pacific/Kanton' => 'UTC/GMT +13:00 - Pacific/Kanton',
            'Pacific/Kiritimati' => 'UTC/GMT +14:00 - Pacific/Kiritimati',
            'Pacific/Kosrae' => 'UTC/GMT +11:00 - Pacific/Kosrae',
            'Pacific/Kwajalein' => 'UTC/GMT +12:00 - Pacific/Kwajalein',
            'Pacific/Majuro' => 'UTC/GMT +12:00 - Pacific/Majuro',
            'Pacific/Marquesas' => 'UTC/GMT -09:30 - Pacific/Marquesas',
            'Pacific/Midway' => 'UTC/GMT -11:00 - Pacific/Midway',
            'Pacific/Nauru' => 'UTC/GMT +12:00 - Pacific/Nauru',
            'Pacific/Niue' => 'UTC/GMT -11:00 - Pacific/Niue',
            'Pacific/Norfolk' => 'UTC/GMT +11:00 - Pacific/Norfolk',
            'Pacific/Noumea' => 'UTC/GMT +11:00 - Pacific/Noumea',
            'Pacific/Pago_Pago' => 'UTC/GMT -11:00 - Pacific/Pago_Pago',
            'Pacific/Palau' => 'UTC/GMT +09:00 - Pacific/Palau',
            'Pacific/Pitcairn' => 'UTC/GMT -08:00 - Pacific/Pitcairn',
            'Pacific/Pohnpei' => 'UTC/GMT +11:00 - Pacific/Pohnpei',
            'Pacific/Port_Moresby' => 'UTC/GMT +10:00 - Pacific/Port_Moresby',
            'Pacific/Rarotonga' => 'UTC/GMT -10:00 - Pacific/Rarotonga',
            'Pacific/Saipan' => 'UTC/GMT +10:00 - Pacific/Saipan',
            'Pacific/Tahiti' => 'UTC/GMT -10:00 - Pacific/Tahiti',
            'Pacific/Tarawa' => 'UTC/GMT +12:00 - Pacific/Tarawa',
            'Pacific/Tongatapu' => 'UTC/GMT +13:00 - Pacific/Tongatapu',
            'Pacific/Wake' => 'UTC/GMT +12:00 - Pacific/Wake',
            'Pacific/Wallis' => 'UTC/GMT +12:00 - Pacific/Wallis',
            'UTC' => 'UTC/GMT +00:00 - UTC',
        ];
    }

    public static function GetDateFormat()
    {
        $results = array_map(
            function ($element) {
                return $element['value'];
            },
            self::$timeformate
        );
        return $results;
    }


    //Email Setting
    public function emailSetting()
    {
        return view('restaurant.settings.email');
    }

    public function emailSave()
    {
        $request = request();

        $lbl_app_smtp_host = strtolower(__('system.fields.app_smtp_host'));
        $lbl_app_smtp_username = strtolower(__('system.fields.app_smtp_username'));
        $lbl_app_smtp_port = strtolower(__('system.fields.app_smtp_port'));
        $lbl_app_smtp_password = strtolower(__('system.fields.app_smtp_password'));
        $lbl_app_smtp_encryption = strtolower(__('system.fields.app_smtp_encryption'));
        $lbl_app_smtp_from_address = strtolower(__('system.fields.app_smtp_from_address'));

        $request->validate([
            'app_smtp_host' => ['required','min:2'],
            'app_smtp_username' => ['required', 'string', 'min:2'],
            'app_smtp_password' => ['required', 'string', 'min:2'],
            'app_smtp_from_address' => ['required', 'email', 'min:2']
        ], [
            "app_smtp_host.required" => __('validation.required', ['attribute' => $lbl_app_smtp_host]),
            "app_smtp_host.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_host]),
            "app_smtp_host.regex" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_host]),

            "app_smtp_port.required" => __('validation.required', ['attribute' => $lbl_app_smtp_port]),
            "app_smtp_port.in" => __('validation.enum', ['attribute' => $lbl_app_smtp_port]),

            "app_smtp_encryption.required" => __('validation.required', ['attribute' => $lbl_app_smtp_encryption]),
            "app_smtp_encryption.in" => __('validation.enum', ['attribute' => $lbl_app_smtp_encryption]),

            "app_smtp_username.required" => __('validation.required', ['attribute' => $lbl_app_smtp_username]),
            "app_smtp_username.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_username]),
            "app_smtp_username.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_username]),

            "app_smtp_password.required" => __('validation.required', ['attribute' => $lbl_app_smtp_password]),
            "app_smtp_password.string" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_password]),
            "app_smtp_password.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_password]),

            "app_smtp_from_address.required" => __('validation.required', ['attribute' => $lbl_app_smtp_from_address]),
            "app_smtp_from_address.email" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_from_address]),
            "app_smtp_from_address.min" => __('validation.custom.invalid', ['attribute' => $lbl_app_smtp_from_address])

        ]);

        $data = [
            'MAIL_HOST' => $request->app_smtp_host,
            'MAIL_PORT' => $request->app_smtp_port,
            'MAIL_USERNAME' => $request->app_smtp_username,
            'MAIL_PASSWORD' => $request->app_smtp_password,
            'MAIL_ENCRYPTION' => $request->app_smtp_encryption,
            'MAIL_FROM_ADDRESS' => $request->app_smtp_from_address
        ];

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }


    //Email Setting
    public function displaySetting()
    {
        return view('restaurant.settings.display');
    }

    public function displaySave()
    {
        $request = request();

        $request->validate([
            'display_language' => ['required'],
            'dark_light_change' => ['required'],
            'direction_change' => ['required'],
            'is_allergies_field_visible' => ['required'],
            'is_calories_field_visible' => ['required'],
            'is_preparation_time_field_visible' => ['required'],
            'is_show_display_full_details_model' => ['required'],
            'show_banner' => ['required'],
            'show_restaurant_name' => ['required'],
        ]);

        $data = [
            'DISPLAY_LANGUAGE' => $request->display_language,
            'DARK_LIGHT_CHANGE' => $request->dark_light_change,
            'DIRECTION_CHANGE' => $request->direction_change,
            'ALLERGIES' => $request->is_allergies_field_visible,
            'CALORIES' => $request->is_calories_field_visible,
            'PREPARATION_TIME' => $request->is_preparation_time_field_visible,
            'FULL_DETAILS_MODEL' => $request->is_show_display_full_details_model,
            'SHOW_BANNER' => $request->show_banner,
            'SHOW_RESTAURANT_NAME' => $request->show_restaurant_name,
        ];

        DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }


    //Email Setting
    public function paymentShow()
    {
        $stripe_data = Settings::where('title', 'stripe')->first();
        $paypal_data = Settings::where('title', 'paypal')->first();
        $offline_data = Settings::where('title', 'offline')->first();
        $paytm_data = Settings::where('title', 'paytm')->first();

        $stripe = ($stripe_data != null) ? json_decode($stripe_data->value) : array();
        $paypal = ($paypal_data != null) ? json_decode($paypal_data->value) : array();
        $offline = ($offline_data != null) ? json_decode($offline_data->value) : array();
        $paytm = ($paytm_data != null) ? json_decode($paytm_data->value) : array();

        return view('restaurant.settings.payment', compact('stripe', 'paypal', 'offline', 'paytm'));
    }

    public function paymentUpdate(Request $request)
    {
        try {

            DB::beginTransaction();
            $input = $request->only('stripe_publish_key','stripe_mode','gateway_type', 'stripe_secret_key', 'stripe_status','paypal_client_id','paypal_mode','paypal_secret_key','paypal_status','instructions','offline_status');

            if (isset($input['gateway_type']) && in_array($input['gateway_type'],array('stripe','paypal','offline'))){
                //Stripe Payment Save
                if (isset($input['gateway_type']) && $input['gateway_type']=="stripe"){
                    $stripe=array();
                    $stripe['stripe_publish_key']=$input['stripe_publish_key'];
                    $stripe['stripe_secret_key']=$input['stripe_secret_key'];
                    $stripe['stripe_mode']=$input['stripe_mode'];
                    $stripe['stripe_status']=$input['stripe_status'];

                    Settings::updateOrCreate(['title'=>'stripe'],['value'=>json_encode($stripe)]);
                }

                //Save PayPal Details
                if (isset($input['gateway_type']) && $input['gateway_type']=="paypal"){
                    $paypal=array();
                    $paypal['paypal_client_id']=$input['paypal_client_id'];
                    $paypal['paypal_secret_key']=$input['paypal_secret_key'];
                    $paypal['paypal_mode']=$input['paypal_mode'];
                    $paypal['paypal_status']=$input['paypal_status'];
                    Settings::updateOrCreate(['title'=>'paypal'],['value'=>json_encode($paypal)]);
                }

                //Save offline Details
                if (isset($input['gateway_type']) && $input['gateway_type']=="offline"){
                    $offline=array();
                    $offline['instructions']=$input['instructions'];
                    $offline['offline_status']=$input['offline_status'];
                    Settings::updateOrCreate(['title'=>'offline'],['value'=>json_encode($offline)]);
                }
            }

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.payment_setting.payment_gateway')]));
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
    }

    public function frontend()
    {
        return view('restaurant.settings.frontend');
    }
    public function frontendImages(Request $request)
    {
        $request = request();

        $lbl_banner_image_one = strtolower(__('system.fields.banner_image_one'));
        $lbl_banner_image_two = strtolower(__('system.fields.banner_image_two'));
        $lbl_how_it_works_step_one = strtolower(__('system.fields.how_it_works_step_one'));
        $lbl_how_it_works_step_two = strtolower(__('system.fields.how_it_works_step_two'));
        $lbl_how_it_works_step_three = strtolower(__('system.fields.how_it_works_step_three'));

        $request->validate([
            'banner_image_one' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'banner_image_two' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'how_it_works_step_one' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'how_it_works_step_two' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'how_it_works_step_three' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg,webp']
        ], [
            "banner_image_one.max" => __('validation.gt.file', ['attribute' => $lbl_banner_image_one, 'value' => 10000]),
            "banner_image_one.image" => __('validation.enum', ['attribute' => $lbl_banner_image_one]),
            "banner_image_one.mimes" => __('validation.enum', ['attribute' => $lbl_banner_image_one]),

            "banner_image_two.max" => __('validation.gt.file', ['attribute' => $lbl_banner_image_two, 'value' => 10000]),
            "banner_image_two.image" => __('validation.enum', ['attribute' => $lbl_banner_image_two]),
            "banner_image_two.mimes" => __('validation.enum', ['attribute' => $lbl_banner_image_two]),

            "how_it_works_step_one.max" => __('validation.gt.file', ['attribute' => $lbl_how_it_works_step_one, 'value' => 10000]),
            "how_it_works_step_one.image" => __('validation.enum', ['attribute' => $lbl_how_it_works_step_one]),
            "how_it_works_step_one.mimes" => __('validation.enum', ['attribute' => $lbl_how_it_works_step_one]),

            "how_it_works_step_two.max" => __('validation.gt.file', ['attribute' => $lbl_how_it_works_step_two, 'value' => 10000]),
            "how_it_works_step_two.image" => __('validation.enum', ['attribute' => $lbl_how_it_works_step_two]),
            "how_it_works_step_two.mimes" => __('validation.enum', ['attribute' => $lbl_how_it_works_step_two]),

            "how_it_works_step_three.max" => __('validation.gt.file', ['attribute' => $lbl_how_it_works_step_three, 'value' => 10000]),
            "how_it_works_step_three.image" => __('validation.enum', ['attribute' => $lbl_how_it_works_step_three]),
            "how_it_works_step_three.mimes" => __('validation.enum', ['attribute' => $lbl_how_it_works_step_three])
        ]);

        $data = null;
        if ($request->has('banner_image_one')) {
            $data['BANNER_IMAGE_ONE'] = '/storage/' . uploadFile($request->banner_image_one, 'frontend_images');
        }
        if ($request->has('banner_image_two')) {
            $data['BANNER_IMAGE_TWO'] = '/storage/' . uploadFile($request->banner_image_two, 'frontend_images');
        }
        if ($request->has('how_it_works_step_one')) {
            $data['HOW_IT_WORKS_STEP_ONE'] = '/storage/' . uploadFile($request->how_it_works_step_one, 'frontend_images');
        }
        if ($request->has('how_it_works_step_two')) {
            $data['HOW_IT_WORKS_STEP_TWO'] = '/storage/' . uploadFile($request->how_it_works_step_two, 'frontend_images');
        }
        if ($request->has('how_it_works_step_three')) {
            $data['HOW_IT_WORKS_STEP_THREE'] = '/storage/' . uploadFile($request->how_it_works_step_three, 'frontend_images');
        }

        if ($data) {
            DotenvEditor::setKeys($data)->save();
            Artisan::call('config:clear');
        }

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }

    public function seoSetting()
    {

        $seo_keyword_data=Settings::where('title','seo_keyword')->first();
        $seo_keyword=$seo_keyword_data->value??'';

        $seo_description_data=Settings::where('title','seo_description')->first();
        $seo_description=$seo_description_data->value??'';

        return view('restaurant.settings.seo',compact('seo_keyword','seo_description'));
    }

    public function seoSave()
    {
        $request = request();

        Settings::updateOrCreate(['title'=>'seo_keyword'],[
            'value'=>$request->seo_keyword
        ]);

        Settings::updateOrCreate(['title'=>'seo_description'],[
            'value'=>$request->seo_description
        ]);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }


    public function analyticsSetting()
    {
        $setting_data=Settings::where('title','analytics_code')->first();
        $analytics_code=$setting_data->value??'';
        return view('restaurant.settings.analytics',compact('analytics_code'));
    }

    public function analyticsSave()
    {
        $request = request();
        Settings::updateOrCreate(['title'=>'analytics_code'],[
            'value'=>$request->analytics_code
        ]);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));
        return redirect()->back();
    }
}
