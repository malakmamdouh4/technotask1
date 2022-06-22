@extends('layouts.app')

@section('content')

    <div class="container">
         <div class="row justify-content-center">
            <div class="sidebar col-md-3 col-md-offset-3 col-sm-10 col-10">
                   <h4> {{__("users.Profile")}} </h4><hr> <br> 

                   <div class="image">
                     <img src="{{asset($LoggedUserInfo['avatar'])}}">
                     {{ $LoggedUserInfo['name'] }} 
                   </div> <br> 
                    
                   <ul>
                   @if($admin->hasRole('admin'))                       
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard") }} </a></li> 
                       <li> <a href="/admin/get-users"> <i class="fas fa-users"> </i> {{__("roles.Users") }} </a></li>
                       <li> <a href="/admin/roles"> <i class="fas fa-table"> </i> {{__("roles.Roles") }} </a></li> 
                   @elseif($admin->hasRole('client'))
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard") }} </a></li> 
                       <li> <a href="/admin/get-users"> <i class="fas fa-users"> </i> {{__("roles.Users") }} </a></li> 
                   @else
                       <li> <a href="/user/profile"> <i class="fas fa-table"> </i>{{__("roles.Profile") }}  </a></li> 
                   @endif
                       <li> <a href="/user/settings"> <i class="fa fa-cog"> </i>  {{__("roles.Settings") }}</a></li> 
                       <li> <a href="{{ route('auth.logout') }}"> <i class="fas fa-sign-out-alt"></i>  {{__("roles.Logout") }}</a> </li>
                   </ul>

            </div>
            <div class="home col-md-8 col-md-offset-3 col-sm-10 col-10">
                   <h4> {{__("users.EditUser") }} </h4> <hr> <br> 
                   <form action="{{ route('admin.editUser',['userId'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                 
                        @if(Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif

                        @if(Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                        @endif

                    
                        <div class="form-group">
                            <label>{{__("users.Name") }}</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter full name" value="{{ $user->name }}" style="width:100%;margin-left:0px">
                            <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                        </div>

                        <div class="form-group">
                            <label>{{__("users.Email") }}</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ $user->email }}" style="width:100%;margin-left:0px">
                            <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                        </div>

                        <div class="form-group">
                            <label>{{__("users.Phone") }}</label>
                            <input type="text" class="form-control" name="phone" placeholder="Enter phone" value="{{ $user->phone }}" style="width:100%;margin-left:0px">
                            <span class="text-danger">@error('phone'){{ $message }} @enderror</span>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">{{__("users.Avatar") }}</label>
                            <input class="form-control" type="file" name="avatar" id="formFile">
                        </div>

                        <div class="form-group">
                            <label>{{__("users.Password") }}</label>
                            <input type="password" class="form-control" name="password" placeholder="{{__("users.enterpassword") }}">
                            <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                        </div>
                        
                        <div class="form-group">
                            <label for="role">{{__("users.Role")}}</label>
                            <select class="role form-control" name="role" id="role">
                                <option value="">{{__("users.Role")}}...</option>
                                @foreach ($roles as $role)
                                    <option data-role-id="{{$role->id}}" data-role-slug="{{$role->slug}}" value="{{$role->id}}" {{ $user->roles->isEmpty() || $role->name != $userRole->name ? "" : "selected"}}>{{$role->name}}</option>                
                                @endforeach
                            </select>          
                        </div>

                        <div id="permissions_box" >
                            <label for="roles">{{__("roles.Permissions") }}</label>        
                            <div id="permissions_ckeckbox_list">                    
                            </div>
                        </div>   

                        @if($user->permissions->isNotEmpty())
                            @if($rolePermissions != null)
                                <div id="user_permissions_box" >
                                    <label for="roles">{{__("roles.Permissions") }}</label>
                                    <div id="user_permissions_ckeckbox_list">                    
                                        @foreach ($rolePermissions as $permission)
                                        <div class="custom-control custom-checkbox">                         
                                            <input class="custom-control-input" type="checkbox" name="permissions[]" id="{{$permission->slug}}" value="{{$permission->id}}" {{ in_array($permission->id, $userPermissions->pluck('id')->toArray() ) ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label" for="{{$permission->slug}}">{{$permission->name}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        <button type="submit" class="btn btn-block btn-success"> {{__("roles.saveRole") }} </button>
                        <br>
                    </form>

                 </div>
             </div>
        </div>


@section('js_user_page')

<script>
    $(document).ready(function(){
        var permissions_box = $('#permissions_box');
        var permissions_ckeckbox_list = $('#permissions_ckeckbox_list');
        var user_permissions_box = $('#user_permissions_box');
        var user_permissions_ckeckbox_list = $('#user_permissions_ckeckbox_list');
        permissions_box.hide(); // hide all boxes
        $('#role').on('change', function() {
            var role = $(this).find(':selected');    
            var role_id = role.data('role-id');
            var role_slug = role.data('role-slug');
            permissions_ckeckbox_list.empty();
            user_permissions_box.empty();
            $.ajax({
                url: "/admin/add-user",
                method: 'get',
                dataType: 'json',
                data: {
                    role_id: role_id,
                    role_slug: role_slug,
                }
            }).done(function(data) {
                
                console.log(data);
                
                permissions_box.show();                        
                // permissions_ckeckbox_list.empty();
                $.each(data, function(index, element){
                    $(permissions_ckeckbox_list).append(       
                        '<div class="custom-control custom-checkbox">'+                         
                            '<input class="custom-control-input" type="checkbox" name="permissions[]" id="'+ element.slug +'" value="'+ element.id +'">' +
                            '<label class="custom-control-label" for="'+ element.slug +'">'+ element.name +'</label>'+
                        '</div>'
                    );
                });
            });
        });
    });
</script>

@endsection


@endsection
