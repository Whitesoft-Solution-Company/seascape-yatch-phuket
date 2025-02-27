<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('admin')->check()) {
            // เช็ค role ว่ามีค่าตรงตามที่ต้องการหรือไม่
            Auth::shouldUse('admin');
            if (session('role') !== 'admin') {
                return redirect('/'); // ถ้าไม่ใช่ admin ให้ redirect ไปหน้าแรก
            }

          
            return $next($request); // ผ่านการตรวจสอบทั้งหมดแล้วให้ไปที่ request ถัดไป
        }

         return redirect('/');
    }
}
