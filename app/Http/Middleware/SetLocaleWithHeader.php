<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class SetLocaleWithHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 前端於header帶的區域
        $localeFromHeader = $request->header('Locale');

        // 若無帶入則使用系統預設語系
        $locale = in_array($localeFromHeader, config('app.locale_supported')) ? $localeFromHeader : config('app.locale');

        //設置
        App::setLocale($locale);
        
        return $next($request);
    }
}
