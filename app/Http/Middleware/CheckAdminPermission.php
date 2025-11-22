<?php

// app/Http/Middleware/CheckAdminPermission.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Lấy quyền của admin hiện tại từ session hoặc auth
        $adminPermissions = auth()->user()->permissions;

        // Kiểm tra nếu quyền cần thiết có trong mảng quyền của admin
        if (!in_array($permission, $adminPermissions)) {
            // Nếu không có quyền, trả về lỗi
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
}

