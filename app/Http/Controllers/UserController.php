<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App;

class UserController extends Controller
{

    // user login form blade
    public function login()
    {
        return view('auth.login') ;
    }


    // user register form blade
    public function register()
    {
        return view('auth.register') ;
    }


    // add user to DB
    public function addUser(Request $request)
    {

        //Validate requests
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|unique:users',
            'password'=>'required|min:5',
            'avatar' => 'required'
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


         $role = Role::where('slug','user')->first();
         $permiss1 = Permission::where('slug','read-self')->first();
         $permiss2 = Permission::where('slug','update-self')->first();

         if($role && $permiss1 && $permiss2)
         {
            $user->roles()->attach(3);
            $user->save();

            $permissions = array(9,10);
            foreach ($permissions as $permission) {
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


    // check user credentials to login or not  
    public function checkUser(Request $request)
    {

        //Validate requests
        $request->validate([
            'username'=>'required',
            'password'=>'required|min:5'
        ]);

        $user = User::where('email','=', $request->username)->orWhere('phone','=', $request->username)->first();

        if(!$user)
        {
        return back()->with('failed','We do not recognize your email address or phone');
        }
        else
        { 
          
          if(Hash::check($request->password, $user->password))
            {
               $request->session()->put('LoggedUser', $user->id);
               return redirect('user/profile');
            }
            else 
            {
               return back()->with('fail','Incorrect password');
            }
        }
    }


    // get user profile 
    public function profile()
    {
        $user = User::where('id','=',session('LoggedUser'))->first();
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
        if($user)
        {
            return view('user.profile', $data)->with('user',$user);
        }
        else
        {
            abort(404);
        }
       
    }


    // get user setting to update his data
    public function settings()
    {
        $user = User::where('id','=',session('LoggedUser'))->first();

        if($user && $user->can('read-self'))
        {
             $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))->first()];
             return view('user.settings', $data)->with('user',$user);
        }
        else
        {
            abort(401);
        }
    }


    // edit user avatar
    public function editAvatar(Request $request , $userId)
    {
            // $admin = User::where('id','=',session('LoggedUser'))->first();
            $user = User::find($userId);

            if($user && $user->can('update-self'))
            {
                $file = $request->file('avatar');

                $extension = $file->getClientOriginalExtension();
                $path = $file->store('public/users');
                $truepath = substr($path, 7);
    
                $user->avatar = URL::to('/') . '/storage/' . $truepath ;
                $user->save();
            
                return redirect()->route('user.settings');
            }
            else
            {
                abort(401);
            }

    }


     // edit user name
    public function editName(Request $request , $userId)
    {
        // $admin = User::where('id','=',session('LoggedUser'))->first();

        $user = User::find($userId);

        if($user && $user->can('update-self'))
        {
            $user->name = $request->name ;
            $user->save();
        
            return redirect()->route('user.settings');
        }
        else
        {
            abort(401);
        }
    }


    // edit user email
    public function editEmail(Request $request , $userId)
    {
        $admin = User::where('id','=',session('LoggedUser'))->first();

        if($admin && $admin->can('update-self'))
        {
            $user = User::find($userId);
            $user->email = $request->email ;
            $user->save();
        
            return redirect()->route('user.settings');
        }
        else
        {
            abort(401);
        }
    }

    
    // edit user phone
    public function editPhone(Request $request , $userId)
    {
        $admin = User::where('id','=',session('LoggedUser'))->first();

        if($admin && $admin->can('update-self'))
        {
            $user = User::find($userId);
            $user->phone = $request->phone ;
            $user->save();
            return redirect()->route('user.settings');
        }
        else
        {
            abort(401);
        }
    }


     // edit user password
     public function editPassword(Request $request , $userId)
     {
        $admin = User::where('id','=',session('LoggedUser'))->first();
        if($admin && $admin->can('update-self'))
        {
           $user = User::find($userId);
            $this->validate($request, [
                'old_password'  => 'required',
                'new_password'  => 'required'
            ]);

            $data = $request->all();

            if(Hash::check($data['old_password'], $user->password))
            {
                $user->password = bcrypt($request->input('new_password'));
                $user->save();

                // return 'password changed successfully';
                return redirect()->route('user.settings');
            }
            else
            {
                return "<h2 style=\"margin:200px;padding:15px;text-align:center\"> passwords don't match </h2>";
            }
        }
        else
        {
            abort(401);
        }
     
     }


    // user logout 
    function logout()
    {
        if(session()->has('LoggedUser'))
        {
            session()->pull('LoggedUser');
            return redirect()->route('auth.login');
        }
    }


}
