<?php

namespace App\Http\Middleware;

use App\Models\VendorSetting;
use Closure;
use Illuminate\Http\Request;

class VendorSettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $vendorSetting = null;
        if (auth()->user()->user_type == 3) {
            $vendorSetting = VendorSetting::where('user_id', auth()->user()->id)->first();
        }elseif(auth()->user()->user_type == 2) {
            $vendorSetting = VendorSetting::where('user_id', auth()->user()->created_by)->first();
        }
        config(['vendor_setting' => $vendorSetting]);

        return $next($request);
    }
}
