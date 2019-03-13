@extends('layouts.front.index')

@section('content')

  <div class="col-lg-12" id='login'>
  <form class="form-horizontal" id="popup-validation" action="" method="post" enctype="multipart/form-data">
  <div class="col-lg-4"></div>
  <div class="col-lg-4" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
      <div style='margin-top:25px;'>
        <fieldset><legend>Forgot Password</legend>
         @if (Session::has('error'))
              <div class="alert alert-danger">Invalid Email Address</div>
          @endif

          @if(Session::has('success'))
             <div class="alert alert-success"> Your password reset link has been sent to your email on file.</div>
          @endif

         <p>Please provide the email address that you used when you signed up for your LiveWitness account.</p>
         <p>We will send you an email that will allow you to reset your password.</p> 
         <div class="form-group">
            <label class="col-lg-12">Email</label>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
              
            <input type="email" name="email"  placeholder="Email address" class="validate[required] form-control">
                @if($errors->users->first('email'))
                  <div class="text-danger">{!!$errors->users->first('email')!!}</div>
               @endif
            </div>
         </div>
         
        
         </div>
         <div class="form-group">
            <div class="col-lg-12" align="right">
                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Send Verification Email">
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
