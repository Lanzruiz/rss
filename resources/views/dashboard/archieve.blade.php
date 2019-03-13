@extends('layouts.dashboard.index')

@section('content')
<div id="text-overlay"></div>
<div id="text-frame"><h1></h1></div>
<!--<div id="overlay"></div>-->
<div id="frame"><div id="location_now"></div><img src="" alt="" id="mainImage" class="img-responsive" /></div>
<div id="trasportvideo">
    <div id="frame-video" class="frame-video">
      <div class="col-lg-12" align="right">
          <span class="btn btn-warning btn-sm">Live Streaming - Transport</span><span id="videoClose" class="btn btn-danger btn-sm">X</span>
        </div>
        <div class="col-lg-12" style="z-index:9999 !important">
             <?php /*<video src="" id="mainVideo"  controls style="z-index:9999 !important"></video>*/ ?>
             <div id="mainVideo"></div>
        </div>
    </div>
</div>

<div id="agentPopupVideo">
  <div id="aframe-video">
    <div class="col-lg-12" align="right">
        <span class="btn btn-success btn-sm">Live Streaming - Agent</span><span id="avideoClose" class="btn btn-danger btn-sm">X</span>
      </div>
      <div class="col-lg-12">
        <video src="" id="amainVideo"  controls></video>
      </div>
  </div>
</div>
<div id="transportEventIntelligence">
    <div id="tUserEventInt">
      <div class="col-lg-12" align="right">
          <span class="btn btn-warning btn-sm">Event Intelligence - Transport</span><span id="tuEvClose" class="btn btn-danger btn-sm">X</span>
        </div>
        <div class="col-lg-12">
          <div id="tuEvContent">
              &nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="tuser-location"></span><hr>
                &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="tuser-event"></span><hr>
                &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="tuser-tds"></span><hr>
                <?php /*&nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="tuser-speed"></span><hr>
                &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="tuser-elevation"></span><hr>*/ ?>
                &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="tuser-direction"></span><hr>
                &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="tuser-battery-level"></span><hr>
                &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="tuser-lat"></span><hr>
                &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="tuser-lng"></span><hr>
            </div>
        </div>
    </div>
</div>
<div id="agentEventIntelligence">
    <div id="bUserEventInt">
      <div class="col-lg-12" align="right">
          <span class="btn btn-success btn-sm">Event Intelligence - Agent</span><span id="buEvClose" class="btn btn-danger btn-sm">X</span>
        </div>
        <div class="col-lg-12">
          <div id="buEvContent">
              &nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="buser-location"></span><hr>
                &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="buser-event"></span><hr>
                &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="buser-tds"></span><hr>
                <?php /*&nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="buser-speed"></span><hr>
                &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="buser-elevation"></span><hr>*/ ?>
                &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="buser-direction"></span><hr>
                &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="buser-battery-level"></span><hr>
                &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="buser-lat"></span><hr>
                &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="buser-lng"></span><hr>
            </div>
        </div>
    </div>
</div>
@include('dashboard.include.menu')
<div class="console">

    @if($alertDetails < 1 && $alertInOff < 1)
      Error
    @else

      @if($alertDetails > 0)
          @include('dashboard.archive.tUser')
          @include('dashboard.archive.int_map')
          @include('dashboard.archive.int_tr_map')

      @else
          <div class="col-lg-12" style="background-color: #333; height:350px; text-align:center; color:#FFF; border-bottom:1px solid #FFF">
                <h1 id="first_pid">Hello Commander <span style='color:yellow'>{{ $users->fldUsersUserName }}</span>, <br>No feed(s) found yet under TRANSPORT.</h1>
                <script>
        function firstPIDCheck(){
          if(jQuery("#first_pid").trigger("click")){

            $.ajax({
     						 type: "post",
     						 headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
     						 url:  "{{url('api/v1/firstPIDCheck')}}",
     						 cache: false,
     						 success: function(data){

                   if(data.message == "Invalid Token Authentication.") {
                       console.log("Invalid Token Authentication.");
                   } else {
                     var ConsoleData = data;
                      if(ConsoleData == 'PidNoFound'){

                      } else if(ConsoleData == 'PidFound'){
                        $("#text-frame").fadeIn();
                        $("#text-overlay").fadeIn();
                        $("#text-frame h1").html('TRANSPORT found, please wait.....');

                        setTimeout(function(){
                          setTimeout(function(){
                              window.location = '{{url('dashboard/archived')}}';
                          },1000);
                        }, 3000);

                      }

                   }

     						 }
 					   });

            // $.post("{{url('api/v1/firstPIDCheck')}}", {},
            //   function(data){
            //     var ConsoleData = data;
            //     if(ConsoleData == 'PidNoFound'){
            //
            //     }else if(ConsoleData == 'PidFound'){
            //       $("#text-frame").fadeIn();
            //       $("#text-overlay").fadeIn();
            //       $("#text-frame h1").html('TRANSPORT found, please wait.....');
            //       setTimeout(function(){
            //         setTimeout(function(){
            //           window.location = '{{url('dashboard/archived')}}';
            //         },1000);
            //       }, 3000);
            //     }
            // });
          }
          setTimeout(function(){
            firstPIDCheck();
          }, 1000);
        }
        setTimeout(function(){
          firstPIDCheck();
        }, 1000);



        var client_id = <?php echo $client_id?>;
        var data_inserted = true;
        var data = firebase.database().ref().child('users');
        data.on("child_changed",function(snap){
          var tUST = snap.val();

          var tUser_id = tUST['user_id'];
          var tUserName = tUST['user_name'];
          //var tdata = firebase.database().ref().child('videos/'+tUST['user_access_code']);
          // tdata.on("child_added",function(snap){
          //   var SnapValue = snap.val();
          //   var fileName = SnapValue['filename'];
          //   var fileSrc = fileName.replace(/[/]/g,'%2F');
          //   var fileUrl = "https://firebasestorage.googleapis.com/v0/b/witnessone-6aa17.appspot.com/o/"+fileSrc+"?alt=media";
          //   // if(tUST['client_id'] == client_id){
          //   //   if(tUST['auth_level'] == 0 && data_inserted == true){

          //   //     DataStoreInServer(accel = SnapValue['accel'], btrLevel = SnapValue['alert_battery_level'], tds = decodeURI(SnapValue['alert_datetime']), speed = Math.abs(SnapValue['alert_speed']), authLevel = SnapValue['auth_level'], client_id = SnapValue['client_id'], course = SnapValue['course'], direction = SnapValue['direction'], elevation = SnapValue['elevation'], event_id = SnapValue['event_id'], mediaSrc = fileUrl, fileType = 'image', lat = parseFloat(SnapValue['lat']), lng = parseFloat(SnapValue['lng']),address = decodeURI(SnapValue['location_now']), level = SnapValue['level'], type = SnapValue['type'], ac = SnapValue['user_access_code'], user_id = tUser_id, user_name = tUserName);
          //   //     data_inserted = false;
          //   //   }
          //   // }
          // });
        });
        </script>
            </div>
      @endif


      @if($alertInOff > 0)
           @include('dashboard.archive.bUser')
      @else
          <div class="col-lg-12" style="background-color: #333; height:350px; text-align:center; color:#FFF">
                <h1 id="first_officer">Hello Commander <span style='color:yellow'>{{ $users->fldUsersUserName }}</span>, <br>No feed(s) found yet under AGENT.</h1>
                <script>
        function firstOfficerCheck(){
          if(jQuery("#first_officer").trigger("click")){

            $.ajax({
     						 type: "post",
     						 headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
     						 url:  "{{url('api/v1/firstOfficerCheck')}}",
     						 cache: false,
     						 success: function(data){

                   if(data.message == "Invalid Token Authentication.") {
                       console.log("Invalid Token Authentication.");
                   } else {

                     var ConsoleData = data;
                     if(ConsoleData == 'OfficerNoFound'){

                     }else if(ConsoleData == 'OfficerFound'){
                       $("#text-frame").fadeIn();
                       $("#text-overlay").fadeIn();
                       $("#text-frame h1").html('AGENT found, please wait.....');
                       setTimeout(function(){
                         setTimeout(function(){
                           window.location = '{{url('dashboard/archived')}}';
                         },1000);
                       }, 3000);
                     }

                   }

     						 }
 					   });

            // $.post("{{url('api/v1/firstOfficerCheck')}}", {},
            //   function(data){
            //     var ConsoleData = data;
            //     if(ConsoleData == 'OfficerNoFound'){
            //
            //     }else if(ConsoleData == 'OfficerFound'){
            //       $("#text-frame").fadeIn();
            //       $("#text-overlay").fadeIn();
            //       $("#text-frame h1").html('AGENT found, please wait.....');
            //       setTimeout(function(){
            //         setTimeout(function(){
            //           window.location = '{{url('dashboard/archived')}}';
            //         },1000);
            //       }, 3000);
            //     }
            // });
          }
          setTimeout(function(){
            firstOfficerCheck();
          }, 1000);
        }
        setTimeout(function(){
          firstOfficerCheck();
        }, 1000);
        var client_id = <?php echo $client_id?>;
        var data_inserted = true;
        var data = firebase.database().ref().child('users');
        data.on("child_changed",function(snap){
          var tUST = snap.val();
          var tUser_id = tUST['user_id'];
          var tUserName = tUST['user_name'];
          // var tdata = firebase.database().ref().child('videos/'+tUST['user_access_code']);
          // tdata.on("child_added",function(snap){
          //   //var SnapValue = snap.val();
          //   //var fileName = SnapValue['filename'];
          //   //var fileSrc = fileName.replace(/[/]/g,'%2F');
          //   //var fileUrl = "https://firebasestorage.googleapis.com/v0/b/witnessone-6aa17.appspot.com/o/"+fileSrc+"?alt=media";
          //   // if(tUST['client_id'] == client_id){
          //   //   // if(tUST['auth_level'] == 1 && data_inserted == true){

          //   //   //   DataStoreInServer(accel = SnapValue['accel'], btrLevel = SnapValue['alert_battery_level'], tds = decodeURI(SnapValue['alert_datetime']), speed = Math.abs(SnapValue['alert_speed']), authLevel = SnapValue['auth_level'], client_id = SnapValue['client_id'], course = SnapValue['course'], direction = SnapValue['direction'], elevation = SnapValue['elevation'], event_id = SnapValue['event_id'], mediaSrc = fileUrl, fileType = 'image', lat = parseFloat(SnapValue['lat']), lng = parseFloat(SnapValue['lng']),address = decodeURI(SnapValue['location_now']), level = SnapValue['level'], type = SnapValue['type'], ac = SnapValue['user_access_code'], user_id = tUser_id, user_name = tUserName);
          //   //   //   data_inserted = false;
          //   //   // }
          //   // }
          // });
        });
        </script>

            </div>
      @endif


    @endif
    @include('dashboard.include.audio')
  <script>
  //data sending to server
  // function DataStoreInServer(accel,btrLevel,tds,speed,authLevel,client_id,course,direction,elevation,event_id,mediaSrc,fileType,lat,lng,address,level,type,ac,user_id,user_name){
  //   var getData = {accel: accel, btrLevel: btrLevel, tds: tds, speed: speed, authLevel: authLevel, client_id: client_id, course: course, direction: direction, elevation: elevation, event_id: event_id, mediaSrc: mediaSrc, fileType: fileType, lat: lat, lng: lng, address: address, level: level, type: type, ac: ac, user_id: user_id, user_name:user_name};
  //   $.post("../_live/dataStore.php",getData,function(response){
  //   });
  // }


  </script>
    <!--<div class="col-lg-12 footers">&trade; &copy; 2008-< ?php echo date("Y");?> WitnessOne, LLC. All Rights Reserved.</div>-->
</div>

@stop

@section('headercodes')
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA46DKC6GhBb46BpIj1GMSGtQyfaiX6HIc&libraries=geometry"></script>

 <script>
  var media_path = "../media/";
  var DATA_REFRESH_ON = false;
  var DATA_REFRESH_FREQUENCY = 1000;
  var s;
  var selectedMarkerIcon = new google.maps.MarkerImage(
    '{{url('public/assets/images/selectedRedMarker.png')}}', // 'images/gmap/marker.gif',
    // This marker is 20 pixels wide by 32 pixels tall.
    new google.maps.Size(46,36),
    // The origin for this image is 0,0.
    new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    new google.maps.Point(24,12)
  );
  /*var fb_icon = new google.maps.MarkerImage(
    '../transport_icon/Pulse_32x37.gif', // 'images/gmap/marker.gif',
    // This marker is 20 pixels wide by 32 pixels tall.
    new google.maps.Size(46,36),
    // The origin for this image is 0,0.
    new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    new google.maps.Point(16,40)
  );*/
  var unSelectedMarkerIcon = new google.maps.MarkerImage(
    "{{url('public/assets/images/unSelectedMarker.png')}}", // 'images/gmap/marker.gif',
    // This marker is 20 pixels wide by 32 pixels tall.
    new google.maps.Size(16,16 ),
    // The origin for this image is 0,0.
    new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    new google.maps.Point(8,8)
  );
  //var uns_2 = "../images/unSelectedMarker.png";//"../images/uns_2.png";
  var uns_2 = new google.maps.MarkerImage(
    "{{url('public/assets/images/uns_2.png')}}", // 'images/gmap/marker.gif',
    // This marker is 20 pixels wide by 32 pixels tall.
    new google.maps.Size(16,16),
    // The origin for this image is 0,0.
    new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    new google.maps.Point(8,8)
  );
  </script>

@stop
