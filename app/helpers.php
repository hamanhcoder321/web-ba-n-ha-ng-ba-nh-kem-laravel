<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
{
    $user = Auth::guard('admins')->user();
    if (!$user) return false;

    if ($user->role === 'admin') {
        return true;
    }

    return in_array($permission, $user->permissions ?? []);
}
}
