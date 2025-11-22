<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $casts = [
        'permissions' => 'array',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSupper()
    {
        return $this->role === 'supper'; 
    }

    public function isOperator()
    {
        return $this->role === 'operator';
    }

    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isSupper() && is_array($this->permissions)) {
            return in_array($permission, $this->permissions);
        }

        if ($this->isOperator()) {
            return $permission === 'category';
        }

        return false;
    }
}
