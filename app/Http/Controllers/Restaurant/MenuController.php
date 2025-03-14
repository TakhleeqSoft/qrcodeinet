<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\Language;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function show(Restaurant $restaurant)
    {
        $dataTheme = $restaurant->theme;
        if (request()->restaurant_view)
        {
            $dataTheme = request()->restaurant_view;
        }

        $restaurant->loadMissing(['tables' => function ($query) {
            $query->where('status', 'active');
        }]);
        switch ($dataTheme) {
            case ('theme1'):
                $theme = 'theme1';
                $restaurant->load(['food_categories.foods' => function ($q) {
                    return $q->where('is_available', 1);
                }, 'foods']);
                break;
            case ('theme2'):
                $restaurant->load(['food_categories.foods']);
                $theme = 'theme2';

                break;
            case ('theme3'):
                $theme = 'theme3';
                $restaurant->load(['food_categories.foods' => function ($q) {
                    return $q->where('is_available', 1);
                }]);
                break;
            case ('theme4'):
                $theme = 'theme4';
                $restaurant->load(['food_categories.foods' =>  function ($q) {
                    return $q->where('is_available', 1);
                }, 'foods']);
                break;

            case ('theme5'):
                $theme = 'theme1';
                $restaurant->load(['food_categories.foods']);
                break;
            default:
                $restaurant->load(['food_categories.foods' =>  function ($q) {
                    return $q->where('is_available', 1);
                }]);
                $theme = 'theme1';
                break;
        }

        $food_categories = $restaurant->food_categories;
        $food_categories = $food_categories->loadMissing('foods.restaurant.vendor_setting');
        $vendor_setting = isset($restaurant->settings) ? $restaurant->settings : null;
        $lang = App::currentLocale();
        $language = Language::where('store_location_name', $lang)->first();
        return view("frontend.$theme.index", ['restaurant' => $restaurant, 'vendor_setting' => $vendor_setting, 'food_categories' => $food_categories, 'language' => $language, 'tables' => $restaurant->tables]);
    }

    public function getFoodDetails(Food $food)
    {
        $compact = [];
        $compact['food'] = $food->load('food_categories', 'restaurant.vendor_setting');
        $compact['restaurant'] = Restaurant::with('vendor_setting', 'settings')->find($food->restaurant_id);
        $compact['restaurant_setting'] = !empty($compact['restaurant']->settings) ? $compact['restaurant']->settings : null;
        $compact['vendor_setting'] = !empty($compact['restaurant']->vendor_setting) ? $compact['restaurant']->vendor_setting : null;
        return view('frontend.food_modal', $compact)->render();
    }

    public function categoryItems($restaurant_slug, FoodCategory $foodCategory)
    {
        $restaurant = Restaurant::where('slug', $restaurant_slug)->with('tables')->first();
        if (empty($restaurant)) {
            abort(404);
        }

        if (request()->restaurant_view) {
            if (!in_array(request()->restaurant_view, ['theme2', 'theme4']))
                return redirect(route('restaurant.menu', ['restaurant' => $restaurant, 'restaurant_view' => request()->restaurant_view]));
        } else {
            if (!(in_array($restaurant->theme, ['theme2', 'theme4'])))
                return redirect(route('restaurant.menu', ['restaurant' => $restaurant]));
        }
        $restaurant->load(['food_categories' => function ($q) use ($foodCategory) {
            $q->where('id', $foodCategory->id);
        }]);

        $theme = request()->restaurant_view ?? $restaurant->theme;
        if (count($restaurant->food_categories) == 0)
            return redirect(route('restaurant.menu', ['restaurant' => $restaurant]));
        $restaurant->load(['food_categories']);
        // $categoires = $restaurant->food_categories->pluck('local_lang_name', 'id');
        $categoires = $restaurant->food_categories;

        $foodCategory->load(['foods' => function ($q) {
            return $q->where('is_available', 1)->with('restaurant.vendor_setting');
        }]);

        $lang = App::currentLocale();
        $language = Language::where('store_location_name', $lang)->first();

        $vendor_setting = isset($restaurant->settings) ? $restaurant->settings : null;

        return view("frontend.{$theme}.foods", ['restaurant' => $restaurant, 'vendor_setting' => $vendor_setting, 'categoires' => $categoires, 'food_category' => $foodCategory, 'foods' => $foodCategory->foods, 'language' => $language, 'tables' => $restaurant->tables, 'selectedCategoryId' => $foodCategory->id]);
    }
}
