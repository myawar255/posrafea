<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = 'user_permissions';

    /**
     * Get the user that owns the data.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
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
