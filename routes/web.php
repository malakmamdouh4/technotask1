<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolesController;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


    Route::get('/', function () {
        return view('welcome');
    });

    // change languages
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

    // add user to DB
    Route::post('/auth/add-user', [UserController::class,'addUser'])->name('auth.addUser');

    // user login
    Route::post('/auth/check-user', [UserController::class,'checkUser'])->name('auth.checkUser');

    // user logout
    Route::get('/auth/logout', [UserController::class,'logout'])->name('auth.logout');


    Route::group(['middleware'=>['AuthCheck']], function()
    {

        Route::group(['prefix'=>'auth'], function()
        {
            // get login form 
            Route::get('/login', [UserController::class,'login'])->name('auth.login');

            // get register blade
            Route::get('/register', [UserController::class,'register'])->name('auth.register');
        });

        
        Route::group(['prefix'=>'user'], function()
        { 

            // get user profile
            Route::get('/profile', [UserController::class,'profile'])->name('user.profile');

            // get settings to edit profile
            Route::get('/settings', [UserController::class,'settings'])->name('user.settings');
        
            // edit user avatar 
            Route::post('/editAvatar/{userId}', [UserController::class,'editAvatar'])->name('user.editAvatar');

            // edit user name 
            Route::post('/editName/{userId}', [UserController::class,'editName'])->name('user.editName');
        
            // edit user email 
            Route::post('/editEmail/{userId}', [UserController::class,'editEmail'])->name('user.editEmail');
        
            // edit user phone 
            Route::post('/editPhone/{userId}', [UserController::class,'editPhone'])->name('user.editPhone');
        
            // edit user password 
            Route::post('/editPassword/{userId}', [UserController::class,'editPassword'])->name('user.editPassword');
        });

 
        Route::group(['prefix'=>'admin'], function()
        {

            // get admin dashboard
            Route::get('/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');

            // get all users
            Route::get('/get-users', [AdminController::class,'getUsers'])->name('admin.getUsers');

            // get user create form 
            Route::get('/add-user', [AdminController::class,'addUser'])->name('admin.addUser');

            // save user to DB
            Route::post('/save-user', [AdminController::class,'saveUser'])->name('admin.saveUser');

            // get user edit form 
            Route::get('/show-edit-user/{userId}', [AdminController::class,'showEditUser'])->name('admin.showEditUser');
            
            // updat user data
            Route::post('/edit-user/{userId}', [AdminController::class,'editUser'])->name('admin.editUser');
        
            // delete user 
            Route::get('/delete-user/{userId}', [AdminController::class,'deleteUser'])->name('admin.deleteUser');

            // Role 
            Route::resource('/roles', 'App\Http\Controllers\RolesController');

            // delete role with its permissions
            Route::get('/roles/delete/{roleId}', [RolesController::class,'destroy']);
        
        });


    });
   


