@extends('layouts.dashboard.dashboard')
@section('content')

<div class="col-lg-4" style="padding-left:0; padding-right:5px">
  <header>
        <div class="icons"><i class="fa fa-user"></i></div>
        <h5>Update User</h5>
    </header>
    <form class="form-horizontal" id="popup-validation"  action="{{url('dashboard/users/edit/'.$currentUser->fldUserID)}}" method="post" enctype="multipart/form-data" name="f" style="margin-top:15px;">
      <div class="col-lg-12">

             @if (Session::has('success'))
                <div class="alert alert-success">User's Information was successfully updated</div>
             @endif


        <div class='form-group'>
            <label class="col-lg-4">User Type</label>
            <div class='col-lg-8'>
              <select name="userType" class="validate[required] form-control" required onchange="transportDisplay(this.value)">
                  <option value=""> Select </option>
                    <option value="1" {{$currentUser->fldUserStatus == 1 ? "selected='selected'" : ""}}> Agent </option>
                    <option value="0" {{$currentUser->fldUserStatus == 0 ? "selected='selected'" : ""}}> Transport </option>
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
                      <option value="{{$listAgents->fldUserID}}" {{$currentUser->fldUserID == $listAgents->fldUsersTransportID ? "selected='selected'" : ""}}>{{$listAgents->fldUsersFullname}} ({{$listAgents->fldUsersAccessCode}})</option>
                  @endforeach
              </select>

              @if(Session::has('agents'))
                <div class="text-danger">Please select your agent</div>
             @endif

            </div>
        </div>

        <div class='form-group' id="transport">
            <label class="col-lg-4">Transport</label>
            <div class='col-lg-8'>
              <select name="transportID" class="validate[required] form-control">
                  <option value="">Select one</option>
                  @foreach($listTransport as $listTransports)
                      <option value="{{$listTransports->fldUserID}}" {{$listTransports->fldUserID == $currentUser->fldUsersTransportID ? "selected='selected'" : ""}}>{{$listTransports->fldUsersFullname}} ({{$listTransports->fldUsersAccessCode}})</option>
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
               <input type="text" name="fullname" placeholder="Full Name" class="validate[required] form-control" value="{{$currentUser->fldUsersFullname}}" required>
                @if($errors->users->first('fullname'))
                  <div class="text-danger">{!!$errors->users->first('fullname')!!}</div>
               @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-12">Email</label>
              <div class="col-lg-12">

                <input type="email" name="email" placeholder="mail@domain.com" class="form-control" required value="{{$currentUser->fldUsersEmail}}">
                 @if($errors->users->first('email'))
                   <div class="text-danger">{!!$errors->users->first('email')!!}</div>
                @endif
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-12">Username</label>
              <div class="col-lg-12">

                <input type="text" name="username"   class="form-control" required value="{{$currentUser->fldUsersUserName}}">
                 @if($errors->users->first('username'))
                   <div class="text-danger">{!!$errors->users->first('username')!!}</div>
                @endif
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-12">Password</label>
              <div class="col-lg-12">

                <input type="password" name="password"  class="form-control"  value="{{Input::old('password')}}">
                 @if($errors->users->first('password'))
                   <div class="text-danger">{!!$errors->users->first('password')!!}</div>
                @endif
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-12">Mobile (no spaces and no symbols)</label>

            <div class="col-lg-5">
                <select name="country_code" id="country_code" class="form-control js-example-basic-single s">
                   @foreach($country as $countries)
                    <option value="{{$countries->id}}" {{$countries->id==$currentUser->fldUserCountryID ? "selected='selected'" : ""}}>{{$countries->nicename}} (+{{$countries->phonecode}})</option>
                   @endforeach
                </select>
            </div>

            <div class="col-lg-7">

                <input type="text" onKeyPress="return numbersOnly(this, event);" onpaste="return false;" name="mobile" placeholder="Enter only digits without any spaces or symbols." class="validate[required] form-control middle" maxlength="13" value="{{$currentUser->fldUsersMobile}}" required>

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
                         <th>Password</th>
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
                        <td>{{$listUserss->fldUsersPasswordTxt}}</td>
                        <td>{{$listUserss->fldUsersEmail}}</td>

                        @if($listUserss->fldUserCountryID == "")
                          <td align="center">{{$listUserss->fldUsersMobile}}</td>
                        @else
                          <td align="center">{{$listUserss->fldUserCountryCode.$listUserss->fldUsersMobile}}</td>
                        @endif

                        <td align="center">
                            <a href="{{url('dashboard/users/edit/'.$listUserss->fldUserID)}}" data-toggle="tooltip" data-original-title="Edit of {{$listUserss->fldUsersUserName}}" data-placement="top"><i class="glyphicon glyphicon-edit"></i></a>

                             |

                             <a href="{{url('dashboard/users/delete/'.$listUserss->fldUserID)}}" data-toggle="tooltip" data-original-title="Edit of {{$listUserss->fldUsersUserName}}" data-placement="top" onClick="return confirm(&quot;Are you sure you want to remove this Users?\n\nPress OK to delete.\nPress Cancel to go back without deleting the Users.\n&quot;)"><i class="glyphicon glyphicon-trash"></i></a>

                        </td>
                    </tr>
              @endforeach
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
@if($currentUser->fldUserStatus == 1)
   $("#transport").show();
   $("#agent").hide();
@else
   $("#transport").hide();
   $("#agent").show();
@endif

function transportDisplay(type) {

  if(type == "1") {
     $("#transport").show();
      $("#agent").hide();
  } else {
     $("#agent").show();
     $("#transport").hide();
  }
}

</script>
@stop

@section('headercodes')
  <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/select2/select2.min.css')}}">
@stop

@section('extracodes')
<script src="{{url('public/assets/select2/select2.min.js')}}"></script>
<script type="text/javascript">
       $(".agent-multiple").select2();
       $("#country_code").select2();
</script>
@stop
