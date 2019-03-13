@extends('layouts.admin.login')

@section('content')
<div class="login-box">
  <div class="login-logo">
    <img src="{{url('public/assets/images/main-logo.png')}}" width="350">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"></p>


        @if(Session::has('error'))
          <div class="text-danger text-center margin-bottom-10">{{Session::get('error')}}</div>
        @endif

      <form action="" method="post">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email">
          @if($errors->admin->first('email'))
            <div class="text-danger">{!!$errors->admin->first('email')!!}</div>
         @endif
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          @if($errors->admin->first('password'))
            <div class="text-danger">{!!$errors->admin->first('password')!!}</div>
         @endif
        </div>
        <div class="row">

          <!-- /.col -->
          <div class="col-4">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>



    </div>
    <!-- /.login-card-body -->
  </div>
</div>
@stop
