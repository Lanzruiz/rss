@extends('layouts.dashboard.dashboard')
@section('content')

<div class="col-lg-4" style="padding-left:0; padding-right:5px">
  <header>
        <div class="icons"><i class="fa fa-envelope"></i></div>
        <h5>Message Send</h5>
    </header>
    <form class="form-horizontal" id="popup-validation" method="post" enctype="multipart/form-data" name="f" style="margin-top:15px;">
      <div class="col-lg-12">


             @if (Session::has('success'))
                <div class="alert alert-success">SMS was successfully sent</div>
             @endif


        <div class='form-group'>
            <label class="col-lg-4">Send Message to:</label>
            <div class='col-lg-8'>
              <select name="userType"  id="userType" class="validate[required] form-control" required>
                  <option value=""> Select User Type </option>
                    <option value="1"> Agent </option>
                    <option value="0"> Transport </option>
                </select>
                @if($errors->sms->first('userType'))
                  <div class="text-danger">Please select user type:</div>
               @endif

            </div>
        </div>

        <div class='form-group' id="userDisplay">
            <label class="col-lg-4"><span id="userStatus"></span></label>
            <div class='col-lg-8'>
              <select name="userID" id="userID" class="validate[required] form-control">
                  <option value="all">Select all</option>

              </select>

            </div>
        </div>




        <div class="form-group">
            <label class="col-lg-12">Message</label>
            <div class="col-lg-12">

               <textarea class="validate[required] form-control" name="message" style="height:100px;" required id="message"></textarea>

                @if($errors->sms->first('message'))
                  <div class="text-danger">{!!$errors->sms->first('message')!!}</div>
               @endif
            </div>
        </div>


        <div class="form-group">
          <div class="col-lg-12 nopadding" align="right">
              <input id="reset" name="reset" value="Reset" class="btn btn-danger" type="reset">
              <input id="submit" name="submit" value="Send" class="btn btn-primary" type="submit">
              <input id="response" onclick="SubmitForm()" value="Reply" class="btn btn-success" style="display: none;">
          </div>


        </div>
      </div>
    </form>
</div>
<div class="col-lg-8" style="padding-left:5px; padding-right:0">
  <header>
    <div class="icons"><i class="fa fa-envelope"></i></div>
    <h5>Users</h5>
    </header>
  <div id="collapse4">

        <div id="a">
      <table class="table table-bordered table-condensed table-hover table-striped">
        <thead>
                    <tr>
                        <th>User</th>
                        <th>Sent Message(s)</th>
                        <th>Recevied Message(s)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
        </thead>
        <tbody>
              @foreach($smsUser as $smsUsers)
                    <tr>
                        <td>{{$smsUsers->fldUsersFullname}}</td>
                        <td align="center">{{\App\Models\SMS::countSMS($smsUsers->fldUserID)}}</td>
                        <td align="center">{{\App\Models\SMS::countReplySMS($smsUsers->fldUserID)}}</td>
                        <td>{{ucwords($smsUsers->fldUserLevel)}}</td>
                        <td id="userAction" align="center">
        	                   <a href="{{url('dashboard/reply/'.$smsUsers->fldSMSClientID)}}" class="smsCheckID" data-id="{{$smsUsers->fldSMSID}}" data-reply="{{$smsUsers->fldSMSPhone}}" username="{{$smsUsers->fldUsersFullname}}" title="View"><i class="fa fa-eye"></i></a> |
         	                   <a href="{{url('dashboard/reply/'.$smsUsers->fldSMSClientID)}}" class="smsCheckID" data-id="{{$smsUsers->fldSMSID}}" data-reply="{{$smsUsers->fldSMSPhone}}" username="{{$smsUsers->fldUsersFullname}}" title="Reply"><i class="fa fa-reply"></i></a>
                        </td>
                    </tr>
              @endforeach

              @if(count($smsUser) == 0)
                  <tr>
                      <td colspan="5" class="text-danger text-center">No Record Found</td>
                  </tr>
              @endif

        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
.form-group{margin-bottom:15px}
.tbl{border:2px solid #66FFFF; padding:10px;}
.brdr .col-lg-1, .brdr .col-lg-4, .brdr .col-lg-3{border:1px solid #990000}
.scroll{overflow-x:scroll; height:500px; border:1px solid #999999}
.failure{color:#F00}
.success{color:#093}
.center{text-align:center; width:100%}
.form-group{margin-bottom:5px; padding:0}
.form-horizontal .col-lg-4{margin:0}
.border{padding:10px; border:2px solid #990000; border-radius:5px;}
.form-horizontal{white-space: normal}
.red{color:#FF0000}
@media (min-width:0px) and (max-width:499px){
  /*#a{display:none}*/
  .table {
     margin-bottom: 50px;
  }
}
@media (min-width:320px) and (max-width:499px){
  /*#b{display:inherit}*/
}
@media (min-width:500px){
  /*#b{display:none}*/
  .table {
     margin-bottom: 50px;
  }
}




</style>

<script>

  $(document).ready(function(){
      $( "#userType" ).change(function() {

        var userType = $( "#userType" ).val();
        var type = userType == 0 ? "Transport" : "Agent";
        $( "#userStatus" ).html(type);
        $( "#userID" ).empty();

            $.ajax({
                  cache: false,
                  type:'POST',
                  url:'{{url('api/v1/getUser')}}',
                  headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
                  data:"userType="+userType+"&commanderID={{Session::get('users_id')}}",
                  success:function(response){
                    console.log(response);
                    if(response.message == "Invalid Token Authentication.") {
                        console.log("Invalid Token Authentication.");
                    }	 else {
                      var json = $.parseJSON(response);
                      console.log(response);
                       //
                        $( "#userID" ).append( $('<option></option>').val("all").html("Select all") );
                         $.each(json, function(key, value) {

                           $( "#userID" ).append( $('<option></option>').val(value.fldUserID).html(value.fldUsersFullname) );
                    });
                    } //if authentication
                  }
              });
      });
  });

</script>
@stop

@section('headercodes')

@stop
