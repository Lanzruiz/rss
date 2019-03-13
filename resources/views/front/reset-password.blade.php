@extends('layouts.front.index')

@section('content')

  <div class="col-lg-12" id='login'>
  <form class="form-horizontal" id="popup-validation" action="" method="post" enctype="multipart/form-data">
  <div class="col-lg-4"></div>
  <div class="col-lg-4" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
      <div style='margin-top:25px;'>
        <fieldset><legend>New Password</legend>
         @if (Session::has('error'))
              <div class="alert alert-danger">Password and confirm password was not identical</div>
          @endif

          @if(Session::has('success'))
             <div class="alert alert-success"> </div>
          @endif

         <div class="form-group">
            <label class="col-lg-12">Password</label>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
              
            <input type="password" name="password"  placeholder="Password" class="validate[required] form-control">
               
            </div>
         </div>


         <div class="form-group">
            <label class="col-lg-12">Confirm Password</label>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
              
            <input type="password" name="password1"  placeholder="Password" class="validate[required] form-control">
               
            </div>
         </div>
         
        
         </div>
         <div class="form-group">
            <div class="col-lg-12" align="right">
                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Reset Password">
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
