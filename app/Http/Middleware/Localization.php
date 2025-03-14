<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale($request->session()->get('locale', config('app.locale')));
        return $next($request);
    }
}
