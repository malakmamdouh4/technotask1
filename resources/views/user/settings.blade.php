@extends('layouts.app')

@section('content')

    <div class="profile">
         <div class="row justify-content-center">
            <div class="sidebar col-md-3 col-md-offset-3 col-sm-10 col-10">
                   <h4> {{__("users.Profile")}} </h4><hr> <br> 

                   <div class="image">
                     <img src="{{asset($LoggedUserInfo['avatar'])}}">
                     {{ $LoggedUserInfo['name'] }} 
                   </div> <br> 
                   
                   <ul>
                   @if($user->hasRole('admin'))                       
                       <li> <a href="/admin/dashboard"> <i class="fas fa-table"> </i> {{__("roles.Dashboard")}} </a></li> 
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
            <div class="settings col-md-8 col-md-offset-3 col-sm-10 col-10">
                   <h4> {{ __("users.Data")}}  </h4> <hr> <br> 
                   <p> <span>   <img class="uimage" src="{{asset($LoggedUserInfo['avatar'])}}">  </span>  </p> 
                 
                        <div class="bottom-right"> 
                               <button onclick="document.getElementById('id05').style.display='block'" style="width:auto;cursor: pointer;background-color:white;border-radius:50px;"> <i class="fas fa-camera"></i> </button>
                        </div> 

                   <p> {{__("users.Name")}} : <span>  {{ $LoggedUserInfo['name'] }}  </span> <span class="edit"> 
                      <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;"> <i class="fas fa-edit"></i> {{__("users.Edit")}}  </button> </span> 
                   </p> 
                   <p>  {{__("users.Email")}}  : <span>  {{ $LoggedUserInfo['email'] }}  </span> <span class="edit"> 
                      <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;"> <i class="fas fa-edit"></i>  {{__("users.Edit")}}  </button> </span> 
                   </p> 
                   <p> {{__("users.Phone")}} : <span>  {{ $LoggedUserInfo['phone'] }}  </span> <span class="edit"> 
                      <button onclick="document.getElementById('id03').style.display='block'" style="width:auto;"> <i class="fas fa-edit"></i>  {{__("users.Edit")}} </button> </span> 
                   </p> 
                   <p style="margin-left:20px;"> 
                      <button onclick="document.getElementById('id04').style.display='block'" style="color:blue">  {{__("users.Changepassword")}}  </button> 
                   </p> 
            </div>
         </div>




         <!-- start edit name form -->
        <div id="id01" class="modal">
                                                         
            <form class="modal-content animate col-sm-10 col-10" action="{{ route('user.editName',['userId'=>$LoggedUserInfo['id']])  }}" method="POST" style=" width: 600px;">
             @csrf
                <div class="img-container">
                     <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>             
                </div>

                <div class="container">
                    <h4 style="text-align:center"> Change Name </h4>

                    <div class="form-group">
                        <label for="formGroupExampleInput">Name</label>
                        <input type="text" class="form-control" name="name" id="formGroupExampleInput" placeholder="Enter..." style="width:95%" required>
                    </div>
                    
                    <button type="submit" class="btn-form"> Save </button> <br> 
                </div>
            </form>

        </div>
        <!-- end edit name form -->

        <!-- start edit email form -->
        <div id="id02" class="modal">
        
            <form class="modal-content animate col-sm-10 col-10" action="{{ route('user.editEmail',['userId'=>$LoggedUserInfo['id']])}}" method="POST" style=" width: 600px;">
            @csrf
                <div class="img-container">
                   <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>             
                </div>

                <div class="container">
                    <h4 style="text-align:center"> Change Email </h4>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter..." required>
                    </div>
                        
                    <button type="submit" class="btn-form"> Save </button> <br> 
                </div>
            </form>

        </div>
        <!-- end edit email form -->

        <!-- start edit phone form -->
        <div id="id03" class="modal">
        
            <form class="modal-content animate col-sm-10 col-10" action="{{ route('user.editPhone',['userId'=>$LoggedUserInfo['id']])}}" method="POST" style=" width: 600px;">
            @csrf
                <div class="img-container">
                   <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>             
                </div>

                <div class="container">
                    <h4 style="text-align:center"> Change Phone </h4>

                    <div class="form-group">
                        <label for="formGroupExampleInput">Phone</label>
                        <input type="text" class="form-control" name="phone" id="formGroupExampleInput" placeholder="Enter..." style="width:95%" required>
                    </div>
                        
                    <button type="submit" class="btn-form"> Save </button> <br> 
                </div>
            </form>

        </div>
        <!-- end edit phone form -->

         <!-- start edit password form -->
         <div id="id04" class="modal">
        
        <form class="modal-content animate col-sm-10 col-10" action="{{ route('user.editPassword',['userId'=>$LoggedUserInfo['id']])}}" method="POST" style=" width: 600px;">
        @csrf
            <div class="img-container">
               <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>             
            </div>

            <div class="container">
                <h4 style="text-align:center"> Change Password </h4>
              
                <div class="form-group">
                    <label for="exampleInputPassword1">old password</label>
                    <input type="password" class="form-control" name="old_password" id="exampleInputPassword1" required>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">new password</label>
                    <input type="password" class="form-control" name="new_password" id="exampleInputPassword1" required>
                </div>
                    
                <button type="submit" class="btn-form"> Save </button> <br> 
            </div>
        </form>

    </div>
    <!-- end edit password form -->


     <!-- start edit name form -->
     <div id="id05" class="modal">
                         
        <form class="modal-content animate col-sm-10 col-10" action="{{ route('user.editAvatar',['userId'=>$LoggedUserInfo['id']]) }}" method="POST" enctype="multipart/form-data" style=" width: 600px;">
        @csrf
            <div class="img-container">
                <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>             
            </div>

            <div class="container">
                <h4 style="text-align:center"> Change Image </h4>
                
                <div class="form-group">
                    <label for="exampleFormControlFile1">Upload Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="avatar">
                </div>
                <button type="submit" class="btn-form"> Save </button> <br> 
            </div>
        </form>

    </div>
    <!-- end edit name form -->


    </div>

@endsection
