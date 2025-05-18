<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!$request->user()) {
            abort(403, 'Bạn chưa đăng nhập.');
        }

        if (!$request->user()->hasPermission($permission)) {
            abort(403, 'Bạn không có quyền truy cập trang này. Yêu cầu quyền: ' . $permission);
        }

        return $next($request);
    }
}
