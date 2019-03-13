@extends('layouts.front.index')

@section('content')  
<div id='reg'>
  <form class="form-horizontal" id="popup-validation" method="post" enctype="multipart/form-data">
  <div class="col-lg-3"></div>
  <div class="col-lg-6" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
  <!--<div class="tbl">-->
  <div style='margin-top:25px;'>
  <fieldset><legend>Set up Commander</legend>
    @if (Session::has('success'))
      <div class="alert alert-success">Registration for commander is successful. Mail is sent to commander's email account. Please check <a href="{{url('/')}}">here</a> to login</div>
    @endif
  
    <div class='form-group'>
        <label class="col-lg-4">Register As</label>
    	<div class='col-lg-8'>Commander</div>
    </div>
     <div class="form-group">
          <label class="col-lg-4">Username</label>
          <div class="col-lg-8">
              <input type="text" name="username" class="validate[required] form-control" placeholder="Username" value="{{Input::old('username')}}">
               @if($errors->users->first('username'))
                  <div class="text-danger">{!!$errors->users->first('username')!!}</div>
               @endif
          </div>
      </div>
     <div class="form-group">
          <label class="col-lg-4">Password</label>
            <div class="col-lg-8">
            <input type="password" name="password" id="password" placeholder="password"  class="validate[required,minSize[6],maxSize[12]] form-control middle" value="">
                @if($errors->users->first('password'))
                  <div class="text-danger">{!!$errors->users->first('password')!!}</div>
               @endif
            </div>
      </div>
      <input type="hidden" name="act_code" id="act_code" value="" />
    <div class="form-group" id="flName">
        <label class="col-lg-4">Commander's Name</label>
        <div class="col-lg-8">
            <input type="text" name="fullname" onpaste="return false;" onkeypress="return onlyAlphabets(event,this);" placeholder="Full Name" class="validate[required] form-control" value="{{Input::old('fullname')}}">

             @if($errors->users->first('fullname'))
                  <div class="text-danger">{!!$errors->users->first('fullname')!!}</div>
               @endif

        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-4">Email</label>
          <div class="col-lg-8">
          <input type="email" name="email" placeholder="mail@domain.com" class="validate[required, custom[email]] form-control middle" value="{{Input::old('email')}}">

               @if($errors->users->first('email'))
                  <div class="text-danger">{!!$errors->users->first('email')!!}</div>
               @endif

          </div>
      </div>
        <div class="form-group">
        <label class="col-lg-4">Mobile</label>
        <div class="col-lg-8">
        <input type="text" onKeyPress="return numbersOnly(this, event);" onpaste="return false;"  name="mobile" placeholder="Enter only digits" class="validate[required, maxSize[10],minSize[10]] form-control middle" maxlength="10" value="{{Input::old('mobile')}}">

             @if($errors->users->first('mobile'))
                  <div class="text-danger">{!!$errors->users->first('mobile')!!}</div>
               @endif

        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-12" align="right">
        <a class="btn btn-danger" href="./">Cancel</a>
        <input type="submit" name="register" class="btn btn-success" value="Submit">
         </div>
      </div>
    </fieldset>
    </div>
    </div>
    <div class="col-lg-3"></div>
  </form>
</div>
@stop

@section('headercodes')
  
@stop