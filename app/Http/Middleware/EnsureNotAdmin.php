<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureNotAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Role 1 and 2 considered admin/staff here
            if (in_array($user->role_id, [1, 2])) {
                return redirect()->route('admin.home');
            }
        }

        return $next($request);
    }
}
