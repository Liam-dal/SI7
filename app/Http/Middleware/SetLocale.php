<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 관리자(Twill)는 자체 로케일 처리를 하므로 건드리지 않음.
        if ($request->is('admin', 'admin/*')) {
            return $next($request);
        }

        $locale = $request->session()->get('locale', config('app.locale'));

        if (in_array($locale, ['ko', 'en'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
