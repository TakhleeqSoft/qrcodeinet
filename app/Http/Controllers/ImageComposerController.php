<?php

namespace App\Http\Controllers;

use App\Models\VendorSetting;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\FoodCategory;

class ImageComposerController extends Controller
{
    public function store(Request $request)
    {
        // جلب إعدادات البائع للحصول على الصور الافتراضية
        $vendorSetting = VendorSetting::first();

        // حفظ صورة الفئة
        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $img = Image::make($file->getRealPath());
            $img->resize(1500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imagePath = 'category_image/' . $file->hashName();
            $img->save(storage_path('app/public/' . $imagePath), 50);
        } else {
            // استخدام الصورة الافتراضية من إعدادات البائع
            $imagePath = $vendorSetting && $vendorSetting->default_category_image
                ? $vendorSetting->default_category_image
                : 'assets/images/default_category.png'; // مسار الصورة الافتراضية
        }

        // حفظ أيقونة الفئة
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $iconPath = 'category_icons/' . $iconFile->hashName();
            $iconFile->storeAs('public', $iconPath);
        } else {
            // استخدام الأيقونة الافتراضية من إعدادات البائع
            $iconPath = $vendorSetting && $vendorSetting->default_category_icon
                ? $vendorSetting->default_category_icon
                : 'assets/images/default_category.png'; // مسار الأيقونة الافتراضية
        }

        // حفظ الفئة مع مسارات الصور
        $category = new FoodCategory();
        $category->restaurant_id = $request->input('restaurant_id');
        $category->category_name = $request->input('category_name');
        $category->lang_category_name = $request->input('lang_category_name');
        $category->category_image = $imagePath;
        $category->icon = $iconPath;
        $category->sort_order = $request->input('sort_order', 0);
        $category->icon_available = $request->has('icon_available') ? 1 : 0;
        $category->icon_available = $request->input('icon_available', 0);
        
        $category->save();

        return redirect('/food-categories')->with('success', 'تمت معالجة الصورة وضغطها وحفظ الفئة بنجاح!');
    }
}
