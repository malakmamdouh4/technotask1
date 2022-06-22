<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id','=',session('LoggedUser'))->first();

        if ($user && $user->can('read-role')) 
        {
            $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
            $roles = Role::where('status','!=',0)->orderBy('id', 'desc')->get();
            return view('admin.roles.index', $data)->with(['roles'=>$roles,'user'=>$user]);
        }
        else
        {
            abort(401);
        }
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id','=',session('LoggedUser'))->first();

        if ($user && $user->can('create-role')) 
        {
            $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];

            return view('admin.roles.create',$data)->with('user',$user);
        }
        else
        {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the role fields
        $request->validate([
            'role_name' => 'required|max:255',
            'role_slug' => 'required|max:255'
        ]);

        $role = new Role();

        $role->name = $request->role_name;
        $role->slug = $request->role_slug;
        $role-> save();

        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions
        
        foreach ($listOfPermissions as $permission) {
            $permissions = new Permission();
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace(" ", "-", $permission));
            $permissions->save();
            $role->permissions()->attach($permissions->id);
            $role->save();
        }    

        return redirect('/admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $user = User::where('id','=',session('LoggedUser'))->first();

        if ($user && $user->can('update-role')) 
        {
            $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
            return view('admin.roles.edit',$data)->with(['role'=>$role,'user'=>$user]);
        }
        else
        {
            abort(401);
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //validate the role fields
        $request->validate([
            'role_name' => 'required|max:255',
            'role_slug' => 'required|max:255'
        ]);

        $role->name = $request->role_name;
        $role->slug = $request->role_slug;
        $role->save();

        $role->permissions()->delete();
        $role->permissions()->detach();

        $listOfPermissions = explode(',', $request->roles_permissions);//create array from separated/coma permissions
        
        foreach ($listOfPermissions as $permission) {
            $permissions = new Permission();
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace(" ", "-", $permission));
            $permissions->save();
            $role->permissions()->attach($permissions->id);
            $role->save();
        }    

        return redirect('/admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($roleId)
    {

        $user = User::where('id','=',session('LoggedUser'))->first();
        if ($user && $user->can('delete-role')) 
        {
            $role = Role::find($roleId);
            $role->status = 0*1;

            $role->permissions()->delete();
            $role->permissions()->detach();
            
            $role->save();
            return redirect('/admin/roles');
        }
        else
        {
            abort(401);
        }
    }




}
