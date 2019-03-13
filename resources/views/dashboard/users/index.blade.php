@extends('layouts.dashboard.dashboard')
@section('content')


<div class="col-lg-4" style="padding-left:0; padding-right:5px">
  <header>
        <div class="icons"><i class="fa fa-user"></i></div>
        <h5>Add new User</h5>
    </header>
    <form class="form-horizontal" id="popup-validation" method="post" enctype="multipart/form-data" name="f" style="margin-top:15px;">
      <div class="col-lg-12">


             @if (Session::has('success'))
                <div class="alert alert-success">User's Information was successfully added</div>
             @endif

             @if (Session::has('success_clean_ptt'))
                <div class="alert alert-success">{{Session::get('success_clean_ptt')}}</div>
             @endif

               @if (Session::has('clean_success'))
                  <div class="alert alert-success">User's Feeds was successfully cleaned</div>
               @endif

        <div class='form-group'>
            <label class="col-lg-4">User Type</label>
            <div class='col-lg-8'>
              <select name="userType"  id="userType" class="validate[required] form-control" required onchange="transportDisplay(this.value)">
                  <option value=""> Select </option>
 
                     <option value="1" selected='selected'> Agent </option>
                    <option value="0" > Transport / Asset </option>

                </select>
                @if($errors->users->first('userType'))
                  <div class="text-danger">{!!$errors->users->first('userType')!!}</div>
               @endif

            </div>
        </div>


        <div class='form-group' id="agent">
            <label class="col-lg-4">Agent</label>
            <div class='col-lg-8'>
              <select name="agentID[]" class="form-control agent-multiple"  multiple="multiple">
                  <option value="">Select one</option>
                  @foreach($listAgent as $listAgents)
                      <option value="{{$listAgents->fldUserID}}">{{$listAgents->fldUsersFullname}} ({{$listAgents->fldUsersAccessCode}})</option>
                  @endforeach
              </select>

              @if(Session::has('agents'))
                <div class="text-danger">Please select your agent</div>
             @endif

            </div>
        </div>


        <div class='form-group' id="transport">
            <label class="col-lg-4">Transport / Asset </label>
            <div class='col-lg-8'>
              <select name="transportID" class="validate[required] form-control">
                  <option value="">Select one</option>
                  @foreach($listTransport as $listTransports)
                      <option value="{{$listTransports->fldUserID}}">{{$listTransports->fldUsersFullname}} ({{$listTransports->fldUsersAccessCode}})</option>
                  @endforeach
              </select>
              @if($errors->users->first('transportID'))
                <div class="text-danger">Please select your transport</div>
             @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-12">Name</label>
            <div class="col-lg-12">
               <input type="text" name="fullname" placeholder="Full Name" class="validate[required] form-control" value="{{Input::old('fullname')}}" required>
                @if($errors->users->first('fullname'))
                  <div class="text-danger">{!!$errors->users->first('fullname')!!}</div>
               @endif
            </div>
        </div>

        <div class="form-group">
                  <label class="col-lg-12">Password</label>
                    <div class="col-lg-12">

                      <input type="password" name="password"  class="form-control" required value="{{Input::old('password')}}">
                       @if($errors->users->first('password'))
                         <div class="text-danger">{!!$errors->users->first('password')!!}</div>
                      @endif
                    </div>
        </div>
  
        <div class="form-group">
            <label class="col-lg-12">Email</label>
              <div class="col-lg-12">

                <input type="email" name="email" placeholder="mail@domain.com" class="form-control" required value="{{Input::old('email')}}">
                 @if($errors->users->first('email'))
                   <div class="text-danger">{!!$errors->users->first('email')!!}</div>
                @endif
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-12">Username</label>
              <div class="col-lg-12">

                <input type="text" name="username"  class="form-control" required value="{{Input::old('username')}}">
                 @if($errors->users->first('username'))
                   <div class="text-danger">{!!$errors->users->first('username')!!}</div>
                @endif
              </div>
        </div>

        <div class="form-group">
            <label class="col-lg-12">Mobile (no spaces and no symbols)</label>
            <div class="col-lg-5">
                <select name="country_code" id="country_code" class="form-control js-example-basic-single s">
                   @foreach($country as $countries)
                    <option value="{{$countries->id}}" {{$countries->iso=="US" ? "selected='selected'" : ""}}>{{$countries->nicename}} (+{{$countries->phonecode}})</option>
                   @endforeach
                </select>
            </div>
            <div class="col-lg-7">

                <!-- 10-01-2018 Removed maxlength="13" attr to remove mobile number digit limit by Michael Reyes -->
                <input type="text" onKeyPress="return numbersOnly(this, event);" onpaste="return false;" name="mobile" placeholder="Enter only digits without any spaces or symbols." class="validate[required] form-control middle" value="{{Input::old('mobile')}}" required>

                @if($errors->users->first('mobile'))
                   <div class="text-danger">{!!$errors->users->first('mobile')!!}</div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12" align="right">

                 <input type="submit" name="submit" class="btn btn-success btn-sm" value="Submit">

             </div>
        </div>
      </div>
    </form>
</div>
<div class="col-lg-8" style="padding-left:5px; padding-right:0">
 

      <div class="checkbox">
      
       Password: <input type="checkbox" id= "password-toggle" data-toggle="toggle" checked="">
      
      </div> 

  <header>
    <div class="icons"><i class="fa fa-users"></i></div>
    <h5>Users</h5>
    </header>


  <div id="collapse4">

    <div id="a">

      <table class="table table-bordered table-condensed table-hover table-striped">
        <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Username</th>
                        <th class="users-password-field">Password</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Info</th>
                    </tr>
        </thead>
        <tbody>
              @foreach($listUsers as $listUserss)
                    <tr>
                        <td>{{$listUserss->fldUsersFullname}}</td>
                        <td align="center">{{$listUserss->fldUsersAccessCode}}</td>
                        <td align="center">
                            @if($listUserss->fldUserStatus == 1)
                              <span style="color:green">Agent</span>
                            @elseif($listUserss->fldUserStatus == 0)
                              <span style="color:red">Transport</span>
                            @elseif($listUserss->fldUserStatus == -1)
                              <span style="color:blue">User Guide</span>
                            @endif
                        </td>
                        <td>{{$listUserss->fldUsersUserName}}</td>
                        <td class="users-password-field">{{$listUserss->fldUsersPasswordTxt}}</td>
                        <td>{{$listUserss->fldUsersEmail}}</td>
                        @if($listUserss->fldUserCountryID == "")
                          <td align="center">{{$listUserss->fldUsersMobile}}</td>
                        @else
                          <td align="center">{{$listUserss->fldUserCountryCode.$listUserss->fldUsersMobile}}</td>
                        @endif
                        <td align="center">
                            <a href="{{url('dashboard/users/edit/'.$listUserss->fldUserID)}}" data-toggle="tooltip" data-original-title="Edit of {{$listUserss->fldUsersUserName}}" data-placement="top"><i class="glyphicon glyphicon-edit"></i></a>

                             |

                             <a href="{{url('dashboard/users/delete/'.$listUserss->fldUserID)}}" data-toggle="tooltip" data-original-title="Edit of {{$listUserss->fldUsersUserName}}" data-placement="top" onClick="return confirm(&quot;Are you sure you want to remove this user?\n\nPress OK to delete.\nPress Cancel to go back without deleting the user.\n&quot;)"><i class="glyphicon glyphicon-trash"></i></a>

                           |

                           <a href="{{url('dashboard/users/clean_feeds/'.$listUserss->fldUserID)}}" data-toggle="tooltip" data-original-title="Clean feeds of {{$listUserss->fldUsersUserName}}" data-placement="top" onClick="return confirm(&quot;Are you sure you want to clean the feeds of this user?\n\nPress OK to delete.\nPress Cancel to go back without cleaning the user feeds.\n&quot;)"><i class="glyphicon glyphicon-refresh"></i></a>

                        </td>
                    </tr>
              @endforeach
        </tbody>
      </table>

      <div class='form-group pull-right' id="agent">
          <?php //{{url('dashboard/commander/clear_audio/'.Session::get('users_id'))}} ?>
          <label class="col-lg-6"><a class="btn btn-danger" href="{{url('dashboard/commander-ptt/clear_audio')}}" data-toggle="tooltip" data-original-title="" data-placement="top" onClick="return confirm('Are you sure you want to clean the PTT feeds of this commander?\n\nPress OK to clean.\nPress Cancel to go back without cleaning the commander PTT feeds.\n');">Clean PTT Feeds</a></label>
          <label class="col-lg-6"><a class="btn btn-danger" href="{{url('dashboard/clean-all-feeds')}}" data-toggle="tooltip" data-original-title="" data-placement="top" onClick="return confirm('Are you sure you want to clean feeds from this commander?\n\nPress OK to clean.\nPress Cancel to go back without cleaning feeds. \n');">Clean All Feeds</a></label>


      </div>


    </div>
                 

  </div>

  <br><br><br>

  <!-- Download Asset buttons -->
  <div class="row" id = "app_store_link">
      <!--div class="col-md-6" style="margin-top: 2%;"> 
          <center>
            <fieldset><legend> Asset / Transport </legend>
              <a href="https://itunes.apple.com/us/app/raptor-security-software-asset/id1433225550?mt=8" target="_blank">
                  <img src="{{ url('public/assets/images/apple.png') }}" alt="Apple app download link" class="download-buttons"> 
              </a> 
              <a href="https://play.google.com/store/apps/details?id=com.tbltechnerds.rss.trans" target="_blank">
                  <img src="{{ url('public/assets/images/google_play.png') }}" alt="Google play download link" class="download-buttons">
              </a>
              <a href="https://www.amazon.com/gp/product/B07J4ZBH2S" target="_blank">
                  <img src="{{ url('public/assets/images/amazon_2.png') }}" alt="Amazon download link" class="download-buttons">
              </a>
          </center>
      </div--> 

  <!-- Download Agent buttons -->
      <!--div class="col-md-6" style="margin-top: 2%;"> 
          <center>
            <fieldset><legend> Agent </legend>
              <a href="https://itunes.apple.com/us/app/raptor-security-software-agent/id1433225070?mt=8" target="_blank">
                  <img src="{{ url('public/assets/images/apple.png') }}" alt="Apple app download link" class="download-buttons"> 
              </a> 
              <a href="https://play.google.com/store/apps/details?id=com.tbltechnerds.rss.agent" target="_blank">
                  <img src="{{ url('public/assets/images/google_play.png') }}" alt="Google play download link" class="download-buttons">
              </a>
              <a href="https://www.amazon.com/gp/product/B07J4R6VN6" target="_blank">
                  <img src="{{ url('public/assets/images/amazon_2.png') }}" alt="Amazon download link" class="download-buttons">
              </a>
          </center>
      </div--> 
  
    </div>
 
  </div>


  <!-- Download Asset buttons -->
  <div class="row" id = "app_store_link">
      <!--div class="col-md-6" style="margin-top: 2%;"> 
          <center>
            <fieldset><legend> Asset / Transport </legend>
              <a href="https://itunes.apple.com/us/app/raptor-security-software-asset/id1433225550?mt=8" target="_blank">
                  <img src="{{ url('public/assets/images/apple.png') }}" alt="Apple app download link" class="download-buttons"> 
              </a> 
              <a href="https://play.google.com/store/apps/details?id=com.tbltechnerds.rss.trans" target="_blank">
                  <img src="{{ url('public/assets/images/google_play.png') }}" alt="Google play download link" class="download-buttons">
              </a>
              <a href="https://www.amazon.com/gp/product/B07J4ZBH2S" target="_blank">
                  <img src="{{ url('public/assets/images/amazon_2.png') }}" alt="Amazon download link" class="download-buttons">
              </a>
          </center>
      </div--> 

  <!-- Download Agent buttons -->
      <!--div class="col-md-6" style="margin-top: 2%;"> 
          <center>
            <fieldset><legend> Agent </legend>
              <a href="https://itunes.apple.com/us/app/raptor-security-software-agent/id1433225070?mt=8" target="_blank">
                  <img src="{{ url('public/assets/images/apple.png') }}" alt="Apple app download link" class="download-buttons"> 
              </a> 
              <a href="https://play.google.com/store/apps/details?id=com.tbltechnerds.rss.agent" target="_blank">
                  <img src="{{ url('public/assets/images/google_play.png') }}" alt="Google play download link" class="download-buttons">
              </a>
              <a href="https://www.amazon.com/gp/product/B07J4R6VN6" target="_blank">
                  <img src="{{ url('public/assets/images/amazon_2.png') }}" alt="Amazon download link" class="download-buttons">
              </a>
          </center>
      </div--> 
  </div>
 
</div>


<div class="row" style="margin-bottom: 40px;">
    <div class="col-md-12" >
        @include('dashboard.subscription.subscription')
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

$(function() {

  $(".users-password-field").hide();

$('#password-toggle').bootstrapToggle({
      on: 'Unhide',
      off: 'Hide'
    });

$("#password-toggle").change(function(){


      if(this.checked) {

        $(".users-password-field").hide();

      }else {

        $(".users-password-field").show();

      }

});


$("#transport").hide();
$("#agent").hide();
$("userType").hide();




// @if(Input::old('userType')==1)
//   $("#transport").show();
//   $("#agent").hide();

// @elseif(Input::old('userType')==0)
//     $("#agent").show();
//     $("#transport").hide();
// @endif

// function transportDisplay(type) {
//     $("#transport").hide();
//     $("#agent").hide();
//   if(type == "1") {
//      $("#transport").show();
//   } else {
//     $("#agent").show();
//   }
// }

});

</script>
@stop

@section('headercodes')

  <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/subscription.css')}}?<?=date('Ymdhis')?>">

  <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/select2/select2.min.css')}}">

  <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/toggle/bootstrap-toggle.min.css')}}">
  
  <style type="text/css">

      .download-buttons{
            width: 30%;
       }
      @media (max-width:480px){
          .download-buttons{
              width: 70%;
          }
         }
  </style>

@stop

@section('extracodes')
<script src="{{url('public/assets/select2/select2.min.js')}}"></script>
<script type="text/javascript">
       $(".agent-multiple").select2();
       $('#country_code').select2();
</script>

<script src="{{url('public/assets/toggle/bootstrap-toggle.min.js')}}"></script>
  
@stop
