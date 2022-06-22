@extends('layouts.app')

@section('content')

    <div class="contain">
         <div class="row justify-content-center">
            <div class="sidebar col-md-3 col-md-offset-3 col-sm-10 col-10">
                   <h4> {{__("roles.Profile")}} </h4><hr> <br> 

                   <div class="image">
                     <img src="{{asset($LoggedUserInfo['avatar'])}}">
                     {{ $LoggedUserInfo['name'] }} 
                   </div> <br> 
                   
                   <ul>
                   @if($user->hasRole('admin'))                       
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard") }} </a></li> 
                       <li> <a href="/admin/get-users"> <i class="fas fa-users"> </i> {{__("roles.Users") }} </a></li>
                       <li> <a href="/admin/roles"> <i class="fas fa-table"> </i> {{__("roles.Roles") }} </a></li> 
                   @elseif($user->hasRole('client'))
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard") }}  </a></li> 
                       <li> <a href="/admin/get-users"> <i class="fas fa-users"> </i> {{__("roles.Users") }} </a></li> 
                   @else
                       <li> <a href="/user/profile"> <i class="fas fa-table"> </i>{{__("roles.Profile") }}  </a></li> 
                   @endif
                       <li> <a href="/user/settings"> <i class="fa fa-cog"> </i>  {{__("roles.Settings") }}</a></li> 
                       <li> <a href="{{ route('auth.logout') }}"> <i class="fas fa-sign-out-alt"></i>  {{__("roles.Logout") }}</a> </li>
                   </ul>

            </div>
            <div class="home col-md-8 col-md-offset-3 col-sm-10 col-10">
                   <h4> {{__("roles.Update") }} </h4> <hr> <br> 
                 
                   @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li> 
                                @endforeach
                            </ul>
                        </div>
                    @endif

        <form method="POST" action="/admin/roles/{{$role->id}}">
            @csrf
            @method('PATCH')
            
            <div class="form-group">
                <label for="role_name">{{__("roles.Name")}}</label>
                <input type="text" name="role_name" class="form-control" id="role_name" style="width:100%;margin:auto" placeholder="{{__("roles.rolename") }}" value="{{$role->name}}" required>
            </div>
            <div class="form-group">
                <label for="role_slug">{{__("roles.Slug") }}</label>
                <input type="text" name="role_slug" tag="role_slug" class="form-control" style="width:100%;margin:auto" id="role_slug" placeholder="{{__("roles.roleslug") }}" value="{{$role->slug}}" required>
            </div>
            <div class="form-group" >
                <label for="roles_permissions">{{__("roles.Permissions") }}</label>
                <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control" style="width:100%;margin:auto" id="roles_permissions" required value="@foreach ($role->permissions as $permission)
                    {{$permission->name. ","}}
                @endforeach">   
            </div>     

            <div class="form-group pt-2">
                <input class="btn btn-success" type="submit" value="{{__("roles.saveRole") }}">
            </div>
        </form>
            </div>
         </div>
    </div>




    @section('css_role_page')
    <link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css') }}">
@endsection

@section('js_role_page')
    <script src="{{asset('js/bootstrap-tagsinput.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#role_name').keyup(function(e){
                var str = $('#role_name').val();
                str = str.replace(/\W+(?!$)/g, '-').toLowerCase();//rplace stapces with dash
                $('#role_slug').val(str);
                $('#role_slug').attr('placeholder', str);
            });
        });
        
    </script>

@endsection

@endsection
