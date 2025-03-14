<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FoodCategoryController extends Controller
{
    public function testImageProcessing()
    {
        // إنشاء صورة بمساحة 100x100 بكسل ولون أحمر للتأكد من عمل Intervention Image
        $img = Image::canvas(100, 100, '#ff0000');
        $path = storage_path('app/public/test_image.jpg');
        $img->save($path);
        
        return "تم حفظ الصورة في المسار: " . $path;
    }
}
