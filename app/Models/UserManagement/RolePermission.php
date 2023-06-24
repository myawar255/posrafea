<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permissions';

    /**
     * Get the role that owns the data.
     */
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }

    /**
     * Get the permission that owns the data.
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }

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

    public $relationMethods = [];
}
