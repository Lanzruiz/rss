@extends('layouts.dashboard.dashboard')
@section('content')
<form class="form-horizontal" id="popup-validation" method="post" enctype="multipart/form-data">

<div class="col-lg-6" style="padding-left:0; padding-right:5px">
	<header>
        <div class="icons"><i class="fa fa-edit"></i></div>
        <h5>Profile</h5>
    </header>
      <div class="col-lg-12 top_margin">

            @if (Session::has('success'))
                <div class="alert alert-success">Profile was successfully updated</div>
             @endif

        <!--<div class='form-group top_margin'>
            <label class="col-lg-4">ID</label>
            <div class='col-lg-8'>< ?php echo $client_id;?></div>
        </div>-->
        <div class="form-group">
            <label class="col-lg-4">Email</label>
              <div class="col-lg-8 padding-right-0">
                <input type="email" name="email" placeholder="mail@domain.com" class="validate[required, custom[email]] form-control" value="{{$users->fldUsersEmail}}" required>
                @if($errors->users->first('email'))
                  <div class="text-danger">{!!$errors->users->first('email')!!}</div>
               @endif
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4">Mobile</label>
						<div class="col-lg-4">
		            <select name="country_code" id="country_code" class="form-control js-example-basic-single s">
		               @foreach($country as $countries)
		                <option value="{{$countries->id}}" {{$countries->id==$users->fldUserCountryID ? "selected='selected'" : ""}}>{{$countries->nicename}} (+{{$countries->phonecode}})</option>
		               @endforeach
		            </select>
		        </div>
            <div class="col-lg-4 padding-right-0">
				<input type="text" onKeyPress="return numbersOnly(this, event);" onpaste="return false;" name="mobile" placeholder="Enter only digits (no spaces and no symbols)" class="validate[required] form-control" maxlength="15" value="{{$users->fldUsersMobile}}" required>
               @if($errors->users->first('mobile'))
                  <div class="text-danger">{!!$errors->users->first('mobile')!!}</div>
               @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4">Team Name</label>
            <div class="col-lg-8 padding-right-0">
				<input type="text" name="fullname" placeholder="Team Name" class="validate[required] form-control" value="{{$users->fldUsersFullname}}" required>
        @if($errors->users->first('fullname'))
                  <div class="text-danger">{!!$errors->users->first('fullname')!!}</div>
               @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4">New Password</label>
            <div class="col-lg-8 padding-right-0">
				<input type="text" name="password" placeholder="Enter New Password" autocomplete="off" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 padding-right-0" align="right">
                <a href="{{url('dashboard/console')}}" class="btn btn-danger btn-sm">Cancel</a>
                <input type="submit" name="submit" class="btn btn-success btn-sm" value="Update">
            </div>
        </div>
      </div>
</div>
<div class="col-lg-6" style="padding-left:5px; padding-right:0">
    <header>
        <div class="icons"><i class="fa fa-table"></i></div>
        <h5>Security Code</h5>
    </header>
      <div class="col-lg-12" style="padding:0; margin-bottom:50px;">
        <h3>Turn on/off your double verify security option.</h3> Current Status:
        @if($users->fldUserSCStatus == 1)
            <input type="radio" name="scOnOffStatus" value="1" checked/> On
            <input type="radio" name="scOnOffStatus" value="0"/> Off
        @else
             <input type="radio" name="scOnOffStatus" value="1"/> On
            <input type="radio" name="scOnOffStatus" value="0" checked/> Off
        @endif

      </div>
</div>

</form>
<style>
.top_margin{margin-top:10px;}
.form-group{margin-bottom:5px;}
.failure{color:#F00; text-align:center; font-size:20px;}
.form-horizontal{white-space: normal;}
.padding-right-0{padding-right:0}
hr{width:100%; margin: 10px 0px 10px 0}
</style>
@stop

@section('headercodes')
<link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/select2/select2.min.css')}}">
@stop

@section('extracodes')
<script src="{{url('public/assets/select2/select2.min.js')}}"></script>
<script type="text/javascript">
       $('#country_code').select2();
</script>
@stop
