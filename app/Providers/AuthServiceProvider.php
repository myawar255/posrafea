<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* ***********************
            User Management
        ************************ */
        // Users
        Gate::define('create-user', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('create-user', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('create-user', $user_permissions)):
                return 0;
            endif;


            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('create-user', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('view-user', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('view-user', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('view-user', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('view-user', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('update-user', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('update-user', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('update-user', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('update-user', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('delete-user', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('delete-user', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('delete-user', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('delete-user', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });

        // Roles
        Gate::define('create-role', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('create-role', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('create-role', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('create-role', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('view-role', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('view-role', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('view-role', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('view-role', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('update-role', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('update-role', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('update-role', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('update-role', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('delete-role', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('delete-role', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('delete-role', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('delete-role', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });

        // Stock Unit
        Gate::define('create-stock-unit', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('create-stock-unit', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('create-stock-unit', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('create-stock-unit', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('view-stock-unit', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('view-stock-unit', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('view-stock-unit', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('view-stock-unit', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('update-stock-unit', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('update-stock-unit', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('update-stock-unit', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('update-stock-unit', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('delete-stock-unit', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('delete-stock-unit', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('delete-stock-unit', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('delete-stock-unit', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });

        /* ***********************
            Stock Management
        ************************ */
        // Stock
        Gate::define('create-stock', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('create-stock', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('create-stock', $user_permissions)):
                return 0;
            endif;


            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('create-stock', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('view-stock', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('view-stock', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('view-stock', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('view-stock', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('update-stock', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('update-stock', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('update-stock', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('update-stock', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
        Gate::define('delete-stock', function (User $user) {
            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',1)->pluck('permission.key')->toArray() : [];
            $user_roles = $user->userRoles ? $user->userRoles->pluck('role.name')->toArray() : [];

            if(in_array('delete-stock', $user_permissions) || in_array('Super Admin', $user_roles)):
                return 1;
            endif;

            $user_permissions = $user->userPermissions ? $user->userPermissions->where('granted',0)->pluck('permission.key')->toArray() : [];
            if(in_array('delete-stock', $user_permissions)):
                return 0;
            endif;

            foreach($user->userRoles as $user_role):
                $role_permissions = $user_role->role->permissions ? $user_role->role->permissions->pluck('permission.key')->toArray() : [];
                if(in_array('delete-stock', $role_permissions)):
                    return 1;
                endif;
            endforeach;

            return 0;
        });
    }
}
