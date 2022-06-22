@extends('layouts.app')

@section('content')

    <div class="profile">
         <div class="row justify-content-center">
            <div class="sidebar col-md-3 col-md-offset-3 col-sm-10 col-12">
                   <h4> {{__("roles.Profile")}}  </h4><hr> <br> 

                   <div class="image">
                     <img src="{{asset($LoggedUserInfo['avatar'])}}">
                     {{ $LoggedUserInfo['name'] }} 
                   </div> <br> 
                   
                   <ul>
                   @if($user->hasRole('admin'))                       
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard") }}</a></li> 
                       <li> <a href="/admin/get-users"> <i class="fas fa-users"> </i> {{__("roles.Users") }} </a></li>
                       <li> <a href="/admin/roles"> <i class="fas fa-table"> </i> {{__("roles.Roles") }} </a></li> 
                   @elseif($user->hasRole('client'))
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard") }} </a></li> 
                       <li> <a href="/admin/get-users"> <i class="fas fa-users"> </i> {{__("roles.Users") }} </a></li> 
                   @else
                       <li> <a href="/user/profile"> <i class="fas fa-table"> </i>{{__("roles.Profile") }}  </a></li> 
                   @endif
                       <li> <a href="/user/settings"> <i class="fa fa-cog"> </i>  {{__("roles.Settings") }}</a></li> 
                       <li> <a href="{{ route('auth.logout') }}"> <i class="fas fa-sign-out-alt"></i>  {{__("roles.Logout") }}</a> </li>
                   </ul>

            </div>
            <div class="home col-md-8 col-md-offset-3 col-sm-10 col-12">
                   <h4> {{__("roles.AllRoles")}} </h4> <hr> <br> 
                   <button type="button" class="btn btn-primary" onclick="window.location='{{ url('/admin/roles/create') }}'"> {{__("roles.addRole")}}  </button>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">{{__("roles.Id")}}</th>
                            <th scope="col">{{__("roles.Name")}} </th>
                            <th scope="col">{{__("roles.Slug")}} </th>
                            <th scope="col">{{__("roles.Permissions")}}  </th>
                            <th scope="col">{{__("roles.Actions")}} </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                            <th scope="row">  {{ $role->id }} </th>
                            <td>  {{ $role->name }} </td>
                            <td> {{ $role->slug }} </td>
                            <td>  
                                @if ($role->permissions != null)
                                    
                                    @foreach ($role->permissions as $permission)
                                    <span class="badge badge-secondary">
                                        {{ $permission->name }}                                    
                                    </span>
                                    @endforeach
                                
                                @endif
                            </td>
                            <td>  
                                <a href="/admin/roles/{{ $role->id }}/edit"> <i class="fas fa-edit" style="color:green"> </i> </a>
                                <a href="/admin/roles/delete/{{ $role->id }}"> <i class="fas fa-trash-alt" style="color:red"> </i> </a>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>

            </div>
         </div>
    </div>

@endsection
