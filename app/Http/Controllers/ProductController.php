<?php

namespace App\Http\Controllers;
use App\Models\Restaurant;

use App\Models\Food; // تأكد من استخدام الـ Food Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // في ProductController.php
    public function show($username, $id)
    {
        // جلب المنتج بناءً على معرفه
        $product = Food::find($id);
        
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }
        $resturent = $product->load('restaurant');
        // جلب معرّفات التصنيفات الخاصة بالمنتج الحالي من الجدول الوسيط
        $categoryIds = DB::table('food_food_category')
            ->where('food_id', $product->id)
            ->pluck('food_category_id');

        // جلب المنتجات المشابهة بناءً على التصنيفات المشتركة
        $relatedProducts = Food::whereIn('id', function($query) use ($categoryIds) {
            $query->select('food_id')
                  ->from('food_food_category')
                  ->whereIn('food_category_id', $categoryIds);
        })
        ->where('id', '!=', $id) // استبعاد المنتج الحالي
        ->get();
        
        // جلب إعدادات العملة
        $currency = DB::table('vendor_settings')->where('user_id',@$resturent->restaurant->user_id ?? 0)->value('default_currency_symbol') ?? 'USD';

        return view('frontend.product-details', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'currency' => $currency,
            'username' => $username
        ]);
        
        
           $default_food_image = !empty($restaurant->vendor_setting->default_food_image) ? asset('storage/' . $restaurant->vendor_setting->default_food_image) : asset('assets/images/default_food.png');
        
        $default_food_image = !empty($restaurant->vendor_setting->default_food_image) ? getFileUrl($restaurant->vendor_setting->default_food_image) : asset('assets/images/default_food.png');
    }
    
        public function showProductDetails($restaurant_slug)
    {
        // الحصول على بيانات المطعم بناءً على الـ slug
        $restaurant = Restaurant::where('slug', $restaurant_slug)->firstOrFail();
    
        // تحديد الرابط الرئيسي بناءً على slug المطعم
        $url = route('frontend.restaurant', ['restaurant' => $restaurant->slug]);
    
        // عرض صفحة المنتج وتمرير البيانات اللازمة
        return view('frontend.product-details', compact('restaurant', 'url'));
    
        
     


    }
    
    
    
    

}
