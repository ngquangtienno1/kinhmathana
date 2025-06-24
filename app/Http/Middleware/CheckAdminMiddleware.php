<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::warning('Unauthorized access attempt: User not logged in', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            return redirect()->route('login')
                ->with('message', 'Bạn phải đăng nhập trước');
        }

        $user = Auth::user();

        // Debug thông tin user
        Log::info('Checking admin access', [
            'user_id' => $user->id,
            'role_id' => $user->role_id,
            'email' => $user->email
        ]);

        // Kiểm tra role_id - cho phép cả admin (1), staff (2) và user (3)
        if (!in_array($user->role_id, [1, 2])) {
            Log::warning('Unauthorized access attempt: User role not allowed', [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'ip' => $request->ip()
            ]);
            Auth::logout();
            return redirect()->route('client.login')
                ->withErrors(['message' => 'Bạn không có quyền truy cập trang quản trị']);
        }

        return $next($request);
    }
}