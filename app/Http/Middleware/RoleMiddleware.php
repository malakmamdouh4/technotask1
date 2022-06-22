<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;


class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $permission = null)
    {

        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        $user = User::where('id','=',session('LoggedUser'))->first();
        if(!$user->hasRole($role)) {
             abort(401);
        }

        if($permission !== null && !$user->can($permission)) {
              abort(401);
        }

        return $next($request);
    }
}