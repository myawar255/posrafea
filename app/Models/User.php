<?php

namespace App\Models;
use App\Models\UserManagement\UserRole;
use App\Models\UserManagement\Role;
use App\Models\Establishment\Employee;
use App\Models\UserManagement\UserPermission;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    /**
     * Get the users that user created.
     */
    public function usersCreatedBy()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Get the users that user updated.
     */
    public function usersUpdatedBy()
    {
        return $this->hasMany(User::class, 'updated_by');
    }

    /**
     * Get the roles that user have.
     */
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    /**
     * Get the roles that user created.
     */
    public function rolesCreatedBy()
    {
        return $this->hasMany(Role::class, 'created_by');
    }

    /**
     * Get the roles that user updated.
     */
    public function rolesUpdatedBy()
    {
        return $this->hasMany(Role::class, 'updated_by');
    }

    /**
     * Get the permissions that user have.
     */
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'user_id');
    }

    public $relationMethods = [];
}
