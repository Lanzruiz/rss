@extends('layouts.front.index')

@section('content')

  <div class="col-lg-12" id='login'>
  <form class="form-horizontal" id="popup-validation" action="" method="post" enctype="multipart/form-data">
  <div class="col-lg-4"></div>
  <div class="col-lg-4" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
      <div style='margin-top:25px;'>
        <fieldset><legend>Super Admin</legend>
         @if (Session::has('error'))
              <div class="alert alert-danger">Invalid username or password</div>
          @endif


         <div class="form-group">
            <label class="col-lg-12">Email address</label>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
            <input type="text" name="username"  value="" placeholder="Email/Username" class="validate[required] form-control">
                @if($errors->administrator->first('username'))
                  <div class="text-danger">{!!$errors->administrator->first('username')!!}</div>
               @endif
            </div>
         </div>
         <div class="form-group">
            <label class="col-lg-12">Password</label>
         </div>
         <div class="form-group">
             <div class="col-lg-12">
            <input type="password" name="password" value="" placeholder="password" class="validate[required] form-control">
            @if($errors->administrator->first('password'))
                  <div class="text-danger">{!!$errors->administrator->first('password')!!}</div>
               @endif
            </div>
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
