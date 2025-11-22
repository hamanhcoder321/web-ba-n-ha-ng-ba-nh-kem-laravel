<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login'); // hoặc route tương ứng
        }

        return $next($request);
    }

}

