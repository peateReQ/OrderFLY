<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $permission = $request->route()->getAction('permission');
        $scope = $request->route()->getAction('scope');

        if (!$user) {
            abort(403, 'Brak autoryzacji');
        }

        if ($permission) {
            if ($scope) {
                if (!$user->hasPermissionWithScope($permission, $scope)) {
                    abort(403, 'Brak uprawnień (' . $permission . ':' . $scope . ')');
                }
            } else {
                if (!$user->hasPermission($permission)) {
                    abort(403, 'Brak uprawnień (' . $permission . ')');
                }
            }
        }
        return $next($request);
    }
}
