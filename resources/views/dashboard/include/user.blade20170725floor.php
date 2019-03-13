<style>
#tu_event{
	animation: blinker 2s linear infinite;
}
@keyframes blinker {
  50% { opacity: 0; }
}
</style>
<div class="col-lg-12 all-background-opacity">
    <div class="col-lg-5">
        <ul class="col-lg-12 nav nav-tabs headerText" role="tablist">
            <li class="col-lg-3 responsiveVersion-3"><p class="eventText" id="tu_event" style="color:#0F0">Live Transport</p></li>
            <?php /*<li id="tu_video_click" role="presentation" class="active"><a href="#tu_video" role="tab" aria-controls="tu_video" data-toggle="tab">Video</a></li>*/ ?>
						<?php /*<li class="col-lg-3"><a href="#" onclick="chrome.tabs.create({url:'chrome://settings/content/flash'});" class="btn btn-primary btn-sm" id="flashBtn" style="display: block;">Chrome Https</a></li>*/ ?>
            <div class="col-lg-3 select">
                <select class="form-control" id="tuser" name="tuser"></select>
            </div>
        </ul>
        <div style="clear: both;"></div>
        <div class="col-lg-12 responsiveVersion-9">
            <div role="tabpanel" class="col-lg-12 video-player border-right-10px tab-pane" id="tu_video" style="width:100% !important">
                <?php /*<video id="video"></video>
                <div onmousedown="displayPopupTransport()">*/ ?>
                	<div id="transportPlayer" style="width:100%; height: 100%"></div>
									<div class="popupLiveTransportClickable" onclick="displayPopupTransport()">&nbsp;</div>
                <?php /*</div>*/?>
                <div id="flashTransport" class="uk-container uk-container-center uk-margin-large-top" >
                        <div class="uk-alert uk-alert-danger">
                            <p><strong>You do not have Flash installed, or it is older than the required 10.0.0.</strong></p>
                            <p><strong>Click below to install the latest version and then try again.</strong></p>
                            <p><a target="_blank" href="https://www.adobe.com/go/getflashplayer">[ Download ]</a></p>
                        </div>
                    </div>
                <?php /*
                <div class="col-lg-12" id="tUserVideoStreamer">

                    {{-- <p style="color:#FFF; text-align:center">Streaming...</p>
                    <div class="progress progress-striped active">
                      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        <span class="sr-only"></span>
                      </div>
                    </div> --}}
                </div>
                */ ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <p>Transport Map:</p>
        <div id="tusermapDefault" class="top-btm-map"><div class="alert alert-danger" id="liveStreamTransport">Live streaming will be activated after Transport runs app</div></div>
        <div id="tusermap" class="top-btm-map"></div>
    </div>
    <div class="col-lg-2">
        <p>Event Intelligence - Transport <span id="ZoomIn" class="btn btn-primary btn-xs">+</span></p>
        <div class="tu-last-frequency" id="buserDataFrequency">
       	&nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="transport_location"></span><hr>
        &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="transport_event"></span><hr>
        &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="transport_tds"></span><hr>
        &nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="transport_speed"></span><hr>
        &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="transport_elevation"></span><hr>
        &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="transport_direction"></span><hr>
				&nbsp;&nbsp;Floor:&nbsp;&nbsp;<span class="transport_floor"></span><hr>
        &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="transport_battery_level"></span><hr>
        &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="transport_lat"></span><hr>
        &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="transport_lng"></span><hr>
        </div>
    </div>


<div id="frame"><div id="location_now"></div><img src="" alt="" id="mainImage" class="img-responsive" /></div>
 <div id="tUserEventInt" style="display: none;">
  <div class="col-lg-12" align="right">
      <span class="btn btn-success btn-sm">Event Intelligence - Transport</span><span id="tuEvClose" class="btn btn-danger btn-sm">X</span>
    </div>
    <div class="col-lg-12">
      <div id="tuEvContent">
           &nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="transport_popup_location"></span><hr>
            &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="transport_popup_event"></span><hr>
            &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="transport_popup_tds"></span><hr>
            &nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="transport_popup_speed"></span><hr>
            &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="transport_popup_elevation"></span><hr>
            &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="transport_popup_direction"></span><hr>
						&nbsp;&nbsp;Floor:&nbsp;&nbsp;<span class="transport_popup_floor"></span><hr>
            &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="transport_popup_battery_level"></span><hr>
            &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="transport_popup_lat"></span><hr>
            &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="transport_popup_lng"></span><hr>
        </div>
    </div>
</div>




</div>
<?php /*<script src="{{url('public/assets/jquery.min.js')}}"></script>
<script src="{{url('public/assets/uikit/js/uikit.min.js')}}"></script>*/ ?>
<script src="{{url('public/assets/swfobject.min.js')}}"></script>

<script>


$("transportEventInt").hide();

var transportCounter = 0;
var jv_tUserMap;
var transportMarker = [];
var transportAccessCode=0;
var transportEventID = 1;
var selectedTransport = "";
var activeTransport = [];

var locationRef = firebase.database().ref('users/{{Session::get('users_id')}}/transport');



locationRef.on('value', function(snapshot) {

	var accesscode="";


	$("#tuser").empty();
	$("#transportPopupVideo").html("");

	if (snapshot.val() == null) {
		$("#tusermapDefault").hide();
		$("#liveStreamTransport").hide();
		$("#tusermap").show();
		$("#transportPlayer").hide();
		//$("#tuser").html("<option value=''></option>");

	     var myCenter = new google.maps.LatLng(38.907192, -77.036871);
			var mapOptions = {
			      center:myCenter,
						mapTypeId: 'hybrid',
			      zoom:18
			};
			 jv_tUserMap = new google.maps.Map(document.getElementById("tusermap"), mapOptions);
			 jv_tUserMap.setTilt(45);

			clearTransportFeeds();

			transportAccessCode = 0;
			int_map_load = true;
			intLiveMap();

	} else {
		$("#tusermapDefault").hide();
		$("#liveStreamTransport").hide();
		$("#tusermap").show();
		$("#transportPlayer").show();
		$("#video-player").show();

		// var snapDict = snapshot.val();
		// var accesscode = snapDict["accesscode"];
		// $("#tuser").html("<option value=''>"+snapDict["name"]+"</option>");

		var nctr=0;
		activeTransport = [];
		snapshot.forEach(function(childSnapshot) {
			var snapDict = childSnapshot.val();
			nctr = nctr + 1;

			activeTransport.push(snapDict["accesscode"]);
			console.log("selectedTransport: " + selectedTransport);
			console.log("active Transport" + activeTransport);

			//if(nctr == 1) {
			if(selectedTransport != "") {
					//if(!activeTransport.has(selectedTransport)) {
					if(!isInArray(selectedTransport,activeTransport)) {
						 selectedTransport = "";
						 clearTransportFeeds();
					}
			}

			if(nctr == 1 && selectedTransport == "") {
				accesscode = snapDict["accesscode"];
				transportEventID = snapDict["eventID"];

				selectedTransport = accesscode;

				if(transportCounter > 1) {
					callTransportMapStreaming(accesscode);
				}
			} else if(selectedTransport != "") {

				 if(selectedTransport == snapDict["accesscode"]) {
						 accesscode = snapDict["accesscode"];
						 transportEventID = snapDict["eventID"];


						 if(transportCounter > 1) {
							 callTransportMapStreaming(accesscode);
						 }
				 }
			}

			$('#tuser').append("<option data-event='"+snapDict["eventID"]+"' value='"+snapDict["accesscode"]+"'>"+snapDict["name"]+"</option>");

			multiplePopupTransport(snapDict["accesscode"],snapDict["name"]);

		});


		transportCounter = transportCounter + 1;

		if(transportCounter == 1) {
			var myCenter = new google.maps.LatLng(38.907192, -77.036871);
			var mapOptions = {
			      center:myCenter,
						mapTypeId: 'hybrid',
			      zoom:18
			};
			 jv_tUserMap = new google.maps.Map(document.getElementById("tusermap"), mapOptions);
			 jv_tUserMap.setTilt(45);


			 getLocationTransport(accesscode);
			 transportAccessCode = accesscode
			 	int_map_load = true;
			 intLiveMap();
		}

		streamingLiveTransport("rtmp://54.214.201.246/live/"+accesscode+ "-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}");
	}
});


function isInArray(value, array) {
  return array.indexOf(value) > -1;
}

// //locationRef.onDisconnect().set("I disconnected!");
// 	locationRef.onDisconnect().remove(function(){
//           console.log('remove callback firing');
//           //locationRef.set(true);
//   });


// locationRef.onDisconnect().set("Offline!");
// // locationRef.child("userStatus").on("value", function(snapshot) {
// //   if (snapshot.val() === true) {
// //     locationRef.child("userStatus").set("Online");
// //   }
// // });

function getLocationTransport(accesscode) {
	transportAccessCode = accesscode
	var locationRef = firebase.database().ref('user_location/'+accesscode);



	locationRef.on('value', function(snapshot) {
		var snapDict = snapshot.val();
		if(snapDict == null) {
			transportCounter = 0;
			//transportFeed(snapDict);
			if (transportAccessCode != 0) {
				$(".transport_event").html(transportEventID);
				$(".transport_tds").html("<?php echo date('Y-m-d h:i'); ?>");
			}
		} else {

			var lat = parseFloat(snapDict["lat"]);
			var lon = parseFloat(snapDict["lon"]);
			//"event_id"=>$event_id, "tds"=>$tds, "speed" => $speed, "elevation" => $elevation, "direction" => $direction, "battery_level"=>$battery_level




			$("#transport_location").html()

			var tUserSelected = $('#tuser').find(":selected").val();



			if(accesscode == tUserSelected) {

				transportFeed(snapDict);
				initMapTransport(lat,lon);
				//int_map_load = true
				//intLiveMap();

			}

		}

	});


	//var ref = firebase.database().ref("user_location/"+accesscode+"/status");
  //locationRef.onDisconnect().set("I disconnected!");



}

function transportFeed(data){



		$(".transport_location").html(data["location_now"]);
		$(".transport_tds").html(data["tds"]);
		$(".transport_speed").html(data["speed"]+ " mph");

		$(".transport_direction").html(data["direction"]);
		$(".transport_battery_level").html(data["battery_level"]);
		$(".transport_event").html(data["event_id"]);
		$(".transport_lat").html(data["lat"]);
		$(".transport_lng").html(data["lon"]);
		$(".transport_floor").html(data["floor"]);

		if(data["elevation"] === undefined) {
			$(".transport_elevation").html("0.0 ft");
		} else {
			$(".transport_elevation").html(data["elevation"]+" ft");
		}

		$(".transport_popup_location").html(data["location_now"]);
		$(".transport_popup_tds").html(data["tds"]);
		$(".transport_popup_speed").html(data["speed"] + " mph");

		$(".transport_popup_direction").html(data["direction"]);
		$(".transport_popup_battery_level").html(data["battery_level"]);
		$(".transport_popup_event").html(data["event_id"]);
		$(".transport_popup_lat").html(data["lat"]);
		$(".transport_popup_lng").html(data["lon"]);
		$(".transport_popup_floor").html(data["floor"]);

		if(data["elevation"] === undefined) {
			$(".transport_popup_elevation").html("0.0 ft");
		} else {
			$(".transport_popup_elevation").html(data["elevation"]+" ft");
		}




	//$("#location_now").html("Address: <span>"+data["location_now"]+"</span>, TDS: <span>"+data["tds"]+"</span>, Speed: <span>"+data["speed"]+"</span>, Elevation: <span>"+data["elevation"]+"ft</span>, Direction: <span>"+data["direction"]+"</span>");

}

function clearTransportFeeds() {
	$(".transport_location").html("");
	$(".transport_tds").html("");
	$(".transport_speed").html("");
	$(".transport_elevation").html("");
	$(".transport_direction").html("");
	$(".transport_battery_level").html("");
	$(".transport_event").html("");
	$(".transport_lat").html("");
	$(".transport_lng").html("");
	$(".transport_floor").html("");

	$(".transport_popup_location").html("");
	$(".transport_popup_tds").html("");
	$(".transport_popup_speed").html("");
	$(".transport_popup_elevation").html("");
	$(".transport_popup_direction").html("");
	$(".transport_popup_battery_level").html("");
	$(".transport_popup_event").html("");
	$(".transport_popup_lat").html("");
	$(".transport_popup_lng").html("");
	$(".transport_popup_floor").html("");
}

function initMapTransport(lat,lon){


	var coordinate = {lat: lat, lng: lon};



	//$("#tusermap").show();



	// var jv_tUserMap = new google.maps.Map(document.getElementById('tusermap'), {
	// 	zoom: 15,
	// 	center: coordinate
	// });
	// var marker = new google.maps.Marker({
	// 	position: coordinate,
	// 	map: jv_tUserMap
	// });

	clearTransportMarker();

	var marker = new google.maps.Marker({
		position: coordinate,
		map: jv_tUserMap,
		optimized: false,
		icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
	});

	transportMarker.push(marker);

	jv_tUserMap.setCenter(new google.maps.LatLng(lat,lon));
	//jv_tUserMap.setCenter(lat,lon);

}

function clearTransportMarker() {
	for(i=0; i<transportMarker.length; i++){
        transportMarker[i].setMap(null);
    }
}

function streamingLiveTransport(src){
	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'transparent'};
	var attributes={id:'transportPlayer'};
	swfobject.embedSWF('https://livewitnessapp.net/public/assets/player.swf','transportPlayer','100%','200','10.2',null,flashvars,params,attributes);
}



$('#tuser').on('change', function() {
	clearTransportFeeds();

   accesscode =  this.value;
   //transportEventID = $(this).data("event");

   transportEventID = $(this).find(':selected').data('event');

   var tUserSelected = $('#tuser').find(":selected").val();
   var name = $('#tuser').find(":selected").text();

	 selectedTransport = tUserSelected;
	 console.log("selectedTransport change: " + selectedTransport);

   if(accesscode == tUserSelected) {
   	 callTransportMapStreaming(accesscode);
	   multiplePopupTransport(accesscode,name);

   	 transportAccessCode = accesscode;
   	 int_map_load = false;
   	 intLiveMap();
   }

})

function callTransportMapStreaming(accesscode) {

	 getLocationTransport(accesscode);
	 //transportEventID = 1;
   	 streamingLiveTransport("rtmp://54.214.201.246/live/"+accesscode+"-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}");
}

//displayMap();

//function displayMap() {

//}
$( "#frame-video" ).draggable();
$( "#aframe-video" ).draggable().resizable();
$( "#frame" ).draggable().resizable();
$(document).on("click","#ZoomIn",function(e){
    $("#tUserEventInt").show();
	$("#tUserEventInt").fadeIn();
	//$("#text-overlay").fadeIn();
	$( "#tUserEventInt" ).draggable();
	$("#tuEvClose").click(function(){
		$("#mainImage").show();
		$("#tUserEventInt").fadeOut();
		//$("#text-overlay").fadeOut();
	});
	e.preventDefault();
});

<?php /*
$(document).on("click","#transportPlayer",function(e){




	$("#mainImage").hide();
	//var src = $(this).attr("src");
	//$("#mainVideo").attr("src", src);
	//$("#mainVideo").attr("autoplay", true);
	//$("#mainVideo").attr("style","width:100%");
	accesscode = $(this).find(':selected').val();
	streamingLiveTransport("rtmp://54.214.201.246/live/"+accesscode+"-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}");

	$("#frame-video").fadeIn();

	$("#videoClose").click(function(){
		$("#mainImage").show();
		$("#frame-video").fadeOut();
		//$("#text-overlay").fadeOut();
	});
	e.preventDefault();
});
*/ ?>

function displayPopupTransport() {
	//$("#tbUserVideoStreamer").hide();


	//swfobject.getObjectById('#transportPlayer').StopPlay();
	//swfobject.getObjectById('transportPlayer').stopVideo();
	//swfobject.getObjectById('transportPlayer')

	accesscode = $("#tuser").find(':selected').val();
	streamingLiveTransportPopup("rtmp://54.214.201.246/live/"+accesscode+"-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}",accesscode);



	$(".frame-video"+accesscode).fadeIn();

	 $('#transportPlayer').hide();
	// $("#videoClose").click(function(){
	// 	$("#frame-video").fadeOut();
	// });
	//e.preventDefault();
}

function streamingLiveTransportPopup(src,accesscode) {

	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
	var attributes={id:'transportPlayerPopup'+accesscode};
	swfobject.embedSWF('https://livewitnessapp.net/public/assets/player.swf','transportPlayerPopup'+accesscode,'100%','100%','10.2',null,flashvars,params,attributes);
}

function transportClose(accesscode) {

	$(".frame-video"+accesscode).fadeOut();
	$('#transportPlayer').show();
}


function multiplePopupTransport(accesscode,name) {



	var frameTransportVideoClassCounter = $('.frame-video'+accesscode).length;

	if(frameTransportVideoClassCounter == 0) {



		$("#transportPopupVideo").append("<div id='frame-video' class='frame-video"+accesscode+"' style='width:400px !important; height: 400px !important;'><div class='col-lg-12 header' align='right'><span class='btn btn-warning btn-sm'>Live Streaming - Transport ("+name+") </span><span id='videoClose' class='btn btn-danger btn-sm' onClick='transportClose("+accesscode+")'>X</span></div><div class='col-lg-12' style='width:100% !important; height: 83% !important;'><div id='transportPlayerPopup"+accesscode+"' class='transportPlayerPopup"+accesscode+"' class='col-lg-12' style='z-index: 99999; height: 100%; width: 82%;'></div></div><div class='col-lg-12 header' align='right'><span id='videoClose' class='btn btn-danger btn-sm' onClick='transportClose("+accesscode+")'>X</span></div></div>");

		$( ".frame-video"+accesscode ).draggable({ handle:'.header'}).resizable();
	}

}


 </script>
