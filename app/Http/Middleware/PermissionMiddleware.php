<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        $user_permissions = $request->user()->userPermissions->where('granted',1)->pluck('permission.key')->toArray();
        foreach ($permissions as $permission) {
            if (! in_array($permission, $user_permissions)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
