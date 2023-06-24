<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function roles(){
        return $this->hasMany(RolePermission::class, 'permission_id');
    }

    public $relationMethods = ['roles'];
}
