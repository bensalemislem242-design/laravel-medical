<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRoles;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Sépare les rôles passés dans le middleware: 'doctor|secretary'
        $route_roles_array = explode('|', $roles);

        // Récupère tous les rôles définis dans l'Enum
        $users_roles = UserRoles::values(); // ex: ['ADMIN'=>1, 'DOCTOR'=>2, 'SECRETARY'=>3]

        if (Auth::check()) {
            $current_user_role = Auth::user()->role->value;

            foreach ($route_roles_array as $role) {
                $role_upper = strtoupper($role); // correspond à la clé dans l'Enum

                // Vérifie que la clé existe avant de l'utiliser
                if (isset($users_roles[$role_upper]) && $users_roles[$role_upper] == $current_user_role) {
                    return $next($request);
                }
            }
        }

        // Si aucun rôle ne correspond → accès refusé
        return response()->json(['message' => 'You do not have permission to access this page.'], 403);
    }
}
