@extends('layouts.app')
@section('content')

    <div class="register">
   <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
           <h4> {{__("auth.UserRegister")}} </h4><hr>
           <form action="{{ route('auth.addUser') }}" method="POST" enctype="multipart/form-data">
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

           @csrf 
           <div class="form-group">
                 <label>{{__("users.Name") }}</label>
                 <input type="text" class="form-control" name="name" placeholder="{{__("users.entername") }}" value="{{ old('name') }}">
                 <span class="text-danger">@error('name'){{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                 <label>{{__("users.Email") }}</label>
                 <input type="text" class="form-control" name="email" placeholder="{{__("users.enteremail") }}" value="{{ old('email') }}">
                 <span class="text-danger">@error('email'){{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                 <label>{{__("users.Phone") }}</label>
                 <input type="text" class="form-control" name="phone" placeholder="{{__("users.enterphone") }}" value="{{ old('phone') }}">
                 <span class="text-danger">@error('phone'){{ $message }} @enderror</span>
              </div>
              <div class="mb-3">
                  <label for="formFile" class="form-label"> {{__("users.Avatar") }}</label>
                  <input class="form-control" type="file" name="avatar" id="formFile">
                  <span class="text-danger">@error('avatar'){{ $message }} @enderror</span>
               </div>
              <div class="form-group">
                 <label>{{__("users.Password") }}</label>
                 <input type="password" class="form-control" name="password" placeholder="{{__("users.enterpassword") }}">
                 <span class="text-danger">@error('password'){{ $message }} @enderror</span>
              </div>
              <button type="submit" class="btn btn-block btn-primary"> {{__("auth.SignUp") }} </button>
              <br>
              <a href="{{ route('auth.login') }}">{{__("auth.haveAccount")}}</a>
           </form>
        </div>
    </div> 
    </div>

@endsection