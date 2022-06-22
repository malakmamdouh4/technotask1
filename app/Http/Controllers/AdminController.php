<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{

     // get admin dashboard 
     public function dashboard()
     {
         $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
         $user = User::where('id','=',session('LoggedUser'))->first();
         if($user && $user->can('read-user'))
         {
            return view('admin.dashboard', $data)->with(['user'=>$user]);
         }
         else
         {
            abort(401);
         }

     }
     

    // get users in dashboard 
    public function getUsers()
    {
        $user = User::where('id','=',session('LoggedUser'))->first();

        if ($user && $user->can('read-user'))
        {
             $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
             $users = User::where([['id','!=',session('LoggedUser')],['status','!=',4],['id','!=',1]])->latest()->simplePaginate(5);
             return view('admin.users.getUsers', $data)->with(['users'=>$users,'user'=>$user]);
        }
        else
        {
            abort(401);
        }
    }


    // get (add user) blade 
    public function addUser(Request $request)
    {
        $user = User::where('id','=',session('LoggedUser'))->first();

        if ($user && $user->can('create-user'))
        {
            if($request->ajax()){
                $roles = Role::where('id', $request->role_id)->first();
                $permissions = $roles->permissions;
    
                return $permissions;
            }
    
            $roles = Role::where('status','!=',0)->get();
            $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
            return view('admin.users.addUser',$data)->with(['roles'=>$roles,'user'=>$user]);
        }
        else
        {
            abort(401);
        }
    }


    // add user to DB by admin with role & permissions
    public function saveUser(Request $request)
    {

        // validate requests
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|unique:users',
            'password'=>'required|min:5',
            'avatar' =>'required'
        ]);

        $file = $request->file('avatar');
    
        $extension = $file->getClientOriginalExtension();
        $path = $file->store('public/users');
        $truepath = substr($path, 7);
        
         
        // insert data into database
         $user = User::create([
            'name' => $request->name , 
            'email' => $request->email , 
            'phone' => $request->phone , 
            'avatar' => URL::to('/') . '/storage/' . $truepath ,
            'password' => Hash::make($request->password) , 
          ]);
 
          if($request->role != null){
             $user->roles()->attach($request->role);
             $user->save();
          }
 
         if($request->permissions != null){            
             foreach ($request->permissions as $permission) {
                 $user->permissions()->attach($permission);
                 $user->save();
             }
         }
     
          if($user)
          {
             return back()->with('success','New User has been successfuly added to database');
          }
          else
          {
              return back()->with('fail','Something went wrong, try again later');
          }
        

    }


    // get edit user blade 
    public function showEditUser($userId)
    {
       
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        $admin = User::where('id','=',session('LoggedUser'))->first();

        if ($admin && $admin->can('update-user')) 
        {
            $user = User::find($userId) ;
            $roles = Role::where('status','!=',0)->get();

            $userRole = $user->roles->first();
            
            if($userRole != null)
            {
                $rolePermissions = $userRole->allRolePermissions;
            }
            else
            {
                $rolePermissions = null;
            }
            $userPermissions = $user->permissions;

                return view('admin.users.editUser', $data)->with([
                    'user'=>$user,
                    'admin'=>$admin,
                    'roles'=>$roles,
                    'userRole'=>$userRole,
                    'rolePermissions'=>$rolePermissions,
                    'userPermissions'=>$userPermissions
                    ]);   
        }
        else
        {
            abort(401);
        }
       
    }


    // admin edit user
    public function editUser(Request $request , $userId)
    {

        // $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        // $users = User::where('id','!=',session('LoggedUser'))->get();
        
        $user = User::find($userId) ;
        $file = $request->file('avatar');

        if(!$file)
        {
            $user->avatar = $user->avatar ;
            $user->save();
        }
        else
        {
            $extension = $file->getClientOriginalExtension();
            $path = $file->store('public/users');
            $truepath = substr($path, 7);

            $user->avatar = URL::to('/') . '/storage/' . $truepath  ;
            $user->save();
        }

        $request->password  == null ? $user->update(['password'=>$user->password]) : $user->update(['password'=>bcrypt($request->password)]) ;

        $user->roles()->detach();
        $user->permissions()->detach();

        if($request->role != null){
            $user->roles()->attach($request->role);
            $user->save();
        }

        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }
        return redirect()->route('admin.getUsers');

    }


     // admin delete user
     public function deleteUser(Request $request , $userId)
     {
 
        $admin = User::where('id','=',session('LoggedUser'))->first();

        if ($admin && $admin->can('delete-user')) 
        {
            
            $user = User::find($userId) ;
            $user->status = 4*1  ;
            $user->roles()->detach();
            $user->permissions()->detach();
            $user->save();    
        
            return redirect()->route('admin.getUsers');
        }
        else
        {
            abort(401);
        }
    } 


}

