@extends('layouts.front.index')

@section('content')  
<style>
.timer{color:#FFF; font-size:18px}
</style>
<form class="form-horizontal log" id="popup-validation" action="" method="post" enctype="multipart/form-data">
<div class="col-lg-3"></div>
<div class="col-lg-6 shadow">
<h3>Please input security code or press logout button to go back:</h3>
Your Login Security Code has been sent to the following: <br />Email: <span style="color:#F00">{{$users->fldUsersEmail}}</span></span>
<hr />

  @if (Session::has('error'))
      <div class="alert alert-danger">Invalid security code.</div>
    @endif

    <div class="form-group">
        <label class="col-lg-4">Security Code</label>
        <div class="col-lg-4" style="padding:0">
            <input type="text" name="security_code" placeholder="Security Code" class="validate[required] form-control">
        </div>
        <div class="col-lg-4" align="right" style="padding-left:0">
          <input type="submit" name="security" class="btn btn-primary" value="Submit" style="width:48%">
            <a class="text-muted btn btn-success" href="{{url('/logout')}}" style="width:48%">Logout</a>
        </div>
    </div>
    <div class="form-group">
      <label class="col-lg-4">.</label>
        <div class="col-lg-4" style="padding:0">
            <input type="radio" name="scOnOffStatus" value="1" checked="checked"/> On
          <input type="radio" name="scOnOffStatus" value="0" /> Off
        </div>
        <div class="col-lg-4" style="padding:0">
        </div>
    </div>
</div>
<div class="col-lg-3"></div>
</form>
@stop

@section('headercodes')
  
@stop