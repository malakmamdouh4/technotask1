<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;


class PermissionsServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        //
    }

    public function boot()
    {

        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives
        Blade::directive('role', function ($role) {

              $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
              $user = User::where('id','=',session('LoggedUser'))->first();
             return "if(session()->has('LoggedUser') && $user->hasRole({$role}))"; 
        });

        Blade::directive('endrole', function ($role) {
             return "endif;"; 
        });

    }
}