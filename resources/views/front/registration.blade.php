@extends('layouts.front.index')

@section('content')
<div id='reg'>
  <form class="form-horizontal" id="popup-validation" method="post" enctype="multipart/form-data">
  <div class="col-lg-3"></div>
  <div class="col-lg-6" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
  <!--<div class="tbl">-->
  <div style='margin-top:25px;'>
  <fieldset><legend>Set Up a Commander Account</legend>
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
        <div class="col-lg-4">
            <select name="country_code" id="country_code" class="form-control js-example-basic-single s">
               @foreach($country as $countries)
                <option value="{{$countries->id}}" {{$countries->iso=="US" ? "selected='selected'" : ""}}>{{$countries->nicename}} (+{{$countries->phonecode}})</option>
               @endforeach
            </select>
        </div>
        <div class="col-lg-4">
        	<!--09-30-2018. Removed mobile number field limit validation. By Michael //removed code - validate[required, maxSize[10],minSize[10]] and maxlength="10" -->
        <input type="text" onKeyPress="return numbersOnly(this, event);" onpaste="return false;"  name="mobile" placeholder="Enter only digits" class="validate[required] form-control middle" value="{{Input::old('mobile')}}">

             @if($errors->users->first('mobile'))
                  <div class="text-danger">{!!$errors->users->first('mobile')!!}</div>
               @endif

        </div>
      </div>

       <div class="form-group">
        <div class="col-lg-4">
          
        </div> 
        <label class="col-lg-8">
          <input type="checkbox" name="user_agreement" id="uala" required> 
          Agree to Terms & Condition.
        </label>
      </div>
        
       <div class="col-md-8">
          
          Already have an account?  <a href="{{ url('/') }}"> Login Here  </a>    
 
        </div>
 
 
       <div class="col-md-8" id = "signup-message-mobile">
            <span class="text text-danger">      
            This is web user registration. To register for the mobile apps, login to the web and create mobile accounts under dashboard. </span>
            <br>
            <img src="{{ url('public/assets/images/user-dashboard.png') }}" height="150" width="150">

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

<div id="uala-div" data-backdrop="false" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Agreement</h4>
      </div>
      <div class="modal-body pdf-content" alt="">
        <embed class="embedded-pdf" src="{{ url('public/assets/pdf/End_User_Agreement_0321_Technologies.pdf') }}">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Agree</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
 
  </div>

</div>

@stop

@section('headercodes')

  <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/select2/select2.min.css')}}">

  <style type="text/css">
  
  .embedded-pdf {
    width: 850px;
    height: 450px;
  } 

  a:link {
    text-decoration: underline;
  }
 
</style>
@stop

@section('extracodes')
<script src="{{url('public/assets/select2/select2.min.js')}}"></script>
<script type="text/javascript">
       
       $('#country_code').select2();

       $('#uala').click(function(){

        if($(this).is(':checked')){  
      
          // e.preventDefault()
          
          $('#uala-div').modal('toggle'); 
          // $(".modal-backdrop.in").css("opacity", 0);    

        }

      });         

       if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        
          $("#signup-message-mobile").show(); 

       }else {

          $("#signup-message-mobile").hide(); 

       }

</script>
@stop
