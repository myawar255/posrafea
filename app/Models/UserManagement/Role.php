<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Get the user that created the data.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get the user that updated the data.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function permissions(){
        return $this->hasMany(RolePermission::class, 'role_id');
    }

    public function users(){
        return $this->hasMany(UserRole::class, 'role_id');
    }

    public $relationMethods = ['users'];
}
