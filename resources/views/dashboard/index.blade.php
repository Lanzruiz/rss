@extends('layouts.dashboard.index')

@section('content')
<div id="text-overlay"></div>
<div id="text-frame"><h1></h1></div>
<!--<div id="overlay"></div>-->
<!--<div id="frame"><div id="location_now"></div><img src="" alt="" id="mainImage" class="img-responsive" /></div>-->
<div id="transportPopupVideo">
  <div id="frame-video" style="width:400px !important; height: 400px !important;">
    <div class="col-lg-12" align="right">
        <span class="btn btn-warning btn-sm">Live Streaming - TR </span><span id="videoClose" class="btn btn-danger btn-sm">X</span>
      </div>
      <div class="col-lg-12" style="width:400px !important; height: 400px !important;">
        <div id="transportPlayerPopup"  style="z-index: 99999; height: 400px; width: 400px;"></div>
      </div>
  </div>
</div>


<div id="agentPopupVideo">
  <div id="aframe-video" style="width:400px !important; height: 400px !important;">
    <div class="col-lg-12" align="right">
        <span class="btn btn-success btn-sm">Live Streaming - Agent</span><span id="avideoClose" class="btn btn-danger btn-sm">X</span>
      </div>
    <div class="col-lg-12" style="width:400px !important; height: 400px !important;">
        <div id="agentPlayerPopup" style="z-index: 99999; height: 400px; width: 400px;"></div>
      </div>
  </div>
</div>
@include('dashboard.include.menu')
<div class="console">

   @include('dashboard.include.user')
   @include('dashboard.include.intMap')
   @include('dashboard.include.inttrMap')
   @include('dashboard.include.buser')
   @include('dashboard.include.audio_live')
</div>
@stop

@section('headercodes')
<style>

div#flashTransport {
margin-top: -199px;
/* z-index: 10000; */
}

.introjs-overlay {
  background-color: blue;
}

</style>

<link href="{{url('public/assets/introjs/introjs.css')}}" rel="stylesheet">


<link href="{{url('public/assets/introjs/intro-dark.css')}}" rel="stylesheet">


<link href="{{url('public/assets/introjs/intro-dark.css')}}" rel="stylesheet">


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript" src="{{url('public/assets/introjs/intro.js')}}"></script>

<script type="text/javascript" src="{{url('public/assets/intro_dashboard.js')}}"></script>

  <script>

     $(function() {

      // @if(Input::old('userType')==1) -> should put here condition for new login

      // @endif

      $("#first-login-notif").click(function(){

         swal("Congratulations for your first login! ", "Please go in dashboard and create mobile app user accounts to receive an activation code and/or username.", "success");

      });


        $('.navbar-toggle').on('click', function(){
            $( '.popupLiveTransportClickable' ).hide();
            //console.log($('.navbar-collapse').attr('aria-expanded'));
            if($('.navbar-collapse').attr('aria-expanded') == 'false' || $('.navbar-collapse').attr('aria-expanded') == undefined) {

              console.log("open");
              $( '.popupLiveTransportClickable' ).hide();

            } else {
              $( '.popupLiveTransportClickable' ).show();
              console.log("close");

            }

          });

         var activeTransport =  firebase.database().ref('threat/{{Session::get('users_id')}}');
          activeTransport.on('value', function(snapshot) {
          if (snapshot.val() != null) {
            var data = snapshot.val();



            var userThreat = firebase.database().ref('threat/{{Session::get('users_id')}}');
            userThreat.remove();

            swal({
              title: "Warning!",
              text: data.name + " ("+data.access_code+") is under threat",
              icon: "warning",
              button: "Ok",
            });


           }
         });

         @if(Session::has('success'))
             swal({
               title: "Success!",
               text: "{{Session::get('success')}}",
               icon: "success",
               button: "Ok",
             });
         @endif


      });


  </script>
@stop
