<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role == '1'){
                return $next($request);
            }else{
                return redirect()->route('login')->with([
                    'message' => 'Bạn không có quyền truy cập'
                ]);
            }
        }else{
            return redirect()->route('login')->with([
                'message' => 'Bạn phải đăng nhập trước'
            ]);
        }
       
    }
}
