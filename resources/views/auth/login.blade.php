@extends('layouts.app')

@section('content')

<div class="login">
   <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
           <h4> {{__("auth.UserLogin")}} </h4><hr>
           <form action="{{ route('auth.checkUser') }}" method="POST">
            @csrf
            @if(Session::get('fail'))
               <div class="alert alert-danger">
                  {{ Session::get('fail') }}
               </div>
            @endif
  
           @csrf
              <div class="form-group">
                 <label>{{__("auth.UserName")}}</label>
                 <input type="text" class="form-control" name="username" placeholder="{{__("auth.enteremailorname") }}" value="{{ old('username') }}">
                 <span class="text-danger">@error('username'){{ $message }} @enderror</span>
              </div>
              <div class="form-group">
                 <label>{{__("users.Password") }}</label>
                 <input type="password" class="form-control" name="password" placeholder="{{__("users.enterpassword") }}">
                 <span class="text-danger">@error('password'){{ $message }} @enderror</span>
              </div>
              <button type="submit" class="btn btn-block btn-primary">{{__("auth.SignIn") }}</button>
              <br>
              <a href="{{ route('auth.register') }}"> {{__("auth.dontHaveAccount") }}</a>
           </form>
      </div>
   </div>
</div> 
@endsection

