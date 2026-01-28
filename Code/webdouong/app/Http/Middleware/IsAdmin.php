<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra user có đăng nhập không
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Kiểm tra user có phải admin không
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->withErrors(['error' => 'Bạn không có quyền truy cập']);
        }

        return $next($request);
    }
}
