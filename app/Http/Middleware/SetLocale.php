<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
        } elseif ($request->user() && $request->user()->preferred_language) {
            App::setLocale($request->user()->preferred_language);
        } else {
            App::setLocale('bn'); // Default to Bangla for NutriDesk
        }

        return $next($request);
    }
}
