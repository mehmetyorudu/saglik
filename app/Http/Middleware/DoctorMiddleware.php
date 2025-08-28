<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::id();
            //user_id si ile doctors tablosunda böyle bir id var mı diye bakar
            $isDoctor = DB::table('doctors')->where('user_id', $userId)->exists();

            if ($isDoctor) {
                return $next($request);
            }
        }

        return redirect('/')->with('error', 'Bu sayfaya erişim yetkiniz yok.');
    }
}
