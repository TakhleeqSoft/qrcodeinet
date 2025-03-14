<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class ClearCacheController extends Controller
{
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        return "Cache cleared successfully!";
    }
}
