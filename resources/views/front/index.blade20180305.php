@extends('layouts.front.index')

@section('content')

  <div class="col-lg-12" id='login'>
  <form class="form-horizontal" id="popup-validation" action="" method="post" enctype="multipart/form-data">
  <div class="col-lg-4"></div>
  <div class="col-lg-4" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
      <div style='margin-top:25px;'>
        <fieldset><legend>Login</legend>
         @if (Session::has('error'))
              <div class="alert alert-danger">Invalid username or password</div>
          @endif


         <div class="form-group">
            <label class="col-lg-12">Email/Username</label>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
              <?php $username = isset($_COOKIE['remember_me']) ? $_COOKIE['remember_me'] : '' ?>
            <input type="text" name="username"  value="{{$username}}" placeholder="Email/Username" class="validate[required] form-control">
                @if($errors->users->first('username'))
                  <div class="text-danger">{!!$errors->users->first('username')!!}</div>
               @endif
            </div>
         </div>
         <div class="form-group">
            <label class="col-lg-12">Password</label>
         </div>
         <div class="form-group">
             <div class="col-lg-12">
               <?php $password = isset($_COOKIE['remember_ps']) ? $_COOKIE['remember_ps'] : ''; ?>
            <input type="password" name="password" value="{{$password}}" autocomplete="off" placeholder="password" class="validate[required] form-control">
            @if($errors->users->first('password'))
                  <div class="text-danger">{!!$errors->users->first('password')!!}</div>
               @endif
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-6">
                <input type="checkbox" name="remember" id="remember" <?php

                if(isset($_COOKIE['remember_me'])) {
echo 'checked="checked"';
}
else {
echo '';
}

?> > <label for="remember" style="font-weight:normal">Remember Me</label>
            </div>
            <!--<div class="col-lg-6" align="right">
                <a href="?_fp=_t" style="text-decoration:none;">Forgot Password?</a>
            </div>-->
         </div>
         <div class="form-group">
            <div class="col-lg-12" align="right">
                <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
            </div>
         </div>
       </fieldset>
       </div>
   </div>
   <div class="col-lg-4"></div>
  </form>
</div>

@stop

@section('headercodes')

@stop
