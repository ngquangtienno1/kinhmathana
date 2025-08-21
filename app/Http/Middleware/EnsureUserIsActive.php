<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && $user->status_user !== 'active') {
                Log::info('Middleware EnsureUserIsActive: logging out non-active user', ['user_id' => $user->id, 'status' => $user->status_user]);
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // If the request expects JSON, return 401 so client JS polling can handle it
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['message' => 'Tài khoản không còn hoạt động'], 401);
                }

                return redirect('/login')->with('error', 'Tài khoản của bạn đã bị ' . $user->status_user);
            }
        }

        return $next($request);
    }
}
