@extends('layouts.app')

@section('content')

    <div class="profile">
         <div class="row justify-content-center">
            <div class="sidebar col-md-3 col-md-offset-3 col-sm-10 col-12">
                   <h4> {{__("users.Profile")}} </h4><hr> <br> 

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
                   <h4>  {{__("users.Users") }} </h4> <hr> <br> 
                   @if($user->hasRole('admin')) 
                   <button type="button" class="btn btn-primary" onclick="window.location='{{ route('admin.addUser') }}'">{{__("users.AddUser") }} </button> 
                    @endif
                   <table class="table">
                   
                        <thead>
                            <tr>
                            <th scope="col">{{__("users.Id")}}</th>
                            <th scope="col" class="name">{{__("users.Name")}} </th>
                            <th scope="col">{{__("users.Phone")}} </th>
                            <th scope="col">{{__("users.Role")}}  </th>
                            <th scope="col">{{__("users.Permissions")}}  </th>
                            <th scope="col">{{__("users.Actions")}} </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $userr)
                            <tr>
                            <th scope="row">  {{ $userr->id }} </th>
                            <td class="name">  {{ $userr->name }} </td>
                            <td> {{ $userr->phone }} </td>
                            <td>
                                @if ($userr->roles->isNotEmpty())
                                    @foreach ($userr->roles as $role)
                                        <span class="badge badge-secondary">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @endif

                            </td>
                            <td>
                                @if ($userr->permissions->isNotEmpty())
                                                
                                    @foreach ($userr->permissions as $permission)
                                        <span class="badge badge-secondary">
                                            {{ $permission->name }}                                    
                                        </span>
                                    @endforeach
                                
                                @endif
                            </td>
                            <td>
                            @if($user->hasRole('admin')) 
                                <a href="/admin/show-edit-user/{{ $userr->id }}"> <i class="fas fa-edit" style="color:green"> </i> </a> 
                            @endif    
                                <a href="/admin/delete-user/{{ $userr->id }}"> <i class="fas fa-trash-alt" style="color:red"> </i> </a> 
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        <br> 
                        {{$users->links()}}
            </div>
         </div>
    </div>
    
    
@section('js_user_page')

<script src="/vendor/chart.js/Chart.min.js"></script>
<script src="/js/admin/demo/chart-area-demo.js"></script>


@endsection

@endsection
