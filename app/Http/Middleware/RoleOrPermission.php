<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roleOrPermission)
    {
        $roleOrPermissions = is_array($roleOrPermission)
            ? $roleOrPermission
            : explode('|', $roleOrPermission);

        $user_permissions = $request->user()->userPermissions->where('granted',1)->pluck('permission.key')->toArray();
        $user_roles = $request->user()->userRoles->pluck('role.name')->toArray();

        foreach ($roleOrPermissions as $roleOrPermission) {
            if ( in_array($roleOrPermission, $user_permissions) || in_array($roleOrPermission, $user_roles) ) {
                return $next($request);
            }
        }

        abort(403);
    }
}
