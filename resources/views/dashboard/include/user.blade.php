<style>
#tu_event{
	animation: blinker 2s linear infinite;
}
@keyframes blinker {
  50% { opacity: 0; }
}

.transPaddingTop {
	 padding-top: 10px;
}
</style>
<div class="col-lg-12 all-background-opacity">
    <div class="col-lg-5">
        <ul class="col-lg-12 nav nav-tabs headerText" role="tablist">
            <li class="col-lg-2 responsiveVersion-3"><p class="eventText" id="tu_event" style="color:#0F0">Live Transport

            </p></li>

						<li class="transPaddingTop">
							<input type="button" style="display:none; margin:2px;" id="remoteon_button" class="btn btn-default btn-sm" value="Remote On">
							<input type="button" style="display:none; margin:2px;" id="logout_button" class="btn btn-default btn-sm" value="Logout">
							<input type="button" style="display:none;margin:1px;" id="trackcancel_button" class="btn btn-default btn-sm" value="Remote Cancel">
							<input type="button" style="display:none;margin:1px;" id="trackon_button" class="btn btn-default btn-sm" value="Remote Off">
							<input type="button" style="display:none;margin:1px;" id="trackon_button_video" class="btn btn-default btn-sm" value="Video Restart">
							<input type="button" style="display:none;margin:1px;" id="trackoff_button_video" class="btn btn-default btn-sm" value="Video Pause">
							<input type="button" style="display:none;margin:1px;" id="track_button_camera_front" class="btn btn-default btn-sm" value= "Front Camera">
							<input type="button" style="display:none;margin:1px;" id="track_button_camera_back" class="btn btn-default btn-sm" value="Back Camera">
							<input type="button" style="display:none;margin:1px;" id="track_button_flash_on" class="btn btn-default btn-sm" value= "Flash On">
							<input type="button" style="display:none;margin:1px;" id="track_button_flash_off" class="btn btn-default btn-sm" value="Flash Off">
							<div id="trans_loadingfeed" style="display:none;" style="color:#fff">Connecting to server...</div>
<div id="app_in_background" style="display:none;color:#fff; font-size: 11px;">You cannot remote control this device. Please instruct the user to keep the app open in the foreground.</div>
						</li>

            <?php /*<li id="tu_video_click" role="presentation" class="active"><a href="#tu_video" role="tab" aria-controls="tu_video" data-toggle="tab">Video</a></li>*/ ?>
						<?php /*<li class="col-lg-3"><a href="#" onclick="chrome.tabs.create({url:'chrome://settings/content/flash'});" class="btn btn-primary btn-sm" id="flashBtn" style="display: block;">Chrome Https</a></li>*/ ?>
            <div class="col-lg-2 select transPaddingTop">
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
                <!-- <div id="flashTransport" class="uk-container uk-container-center uk-margin-large-top" >
                        <div class="uk-alert uk-alert-danger">
                            <p><strong>You do not have Flash installed, or it is older than the required 10.0.0.</strong></p>
                            <p><strong>Click below to install the latest version and then try again.</strong></p>
                            <p><a target="_blank" href="https://www.adobe.com/go/getflashplayer">[ Download ]</a></p>
                        </div>
                    </div> -->
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
        <p style="padding: 18px 15px;">Transport Map:</p>
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
				<?php /*&nbsp;&nbsp;Floor:&nbsp;&nbsp;<span class="transport_floor"></span><hr>*/ ?>
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
						<?php /*&nbsp;&nbsp;Floor:&nbsp;&nbsp;<span class="transport_popup_floor"></span><hr>*/ ?>
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

var transportAccessCodeActive = [];
var transportAccessCode = 0;
var transportEventID = 0;
var transportLastUpdatedDate = "";
var transportNewUpdatedDate = "1";
var jv_tUserMap;
var transportMarker = [];
var transportCounter=0;
var latestEventBasedonLocation = 0;
var trans_popup = false;

$( "#frame-video" ).draggable();
$( "#aframe-video" ).draggable().resizable();
$( "#frame" ).draggable().resizable();
$("#tusermap").hide();



/***********THIS CODE IS USED TO ADD TRANSPORT TO THE DROPDOWN SELECT AND DISPLAY THE REMOTE ON BUTTON******************/
var transportRemoteControlRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport')
transportRemoteControlRef.on('value', function(snapshot) {
  //console.log(snapshot.val());
	 if (snapshot.val() != null) {
		 //$("#tuser").empty();
		 var activeTransport = [];
		 snapshot.forEach(function(childSnapshot) {
				 var snapDict = childSnapshot.val();

				 if(snapDict != null) {
					 //console.log(snapDict["accesscode"]);
					 //console.log($.inArray(snapDict["accesscode"], transportAccessCodeActive ));
					 		if(($.inArray(snapDict["accesscode"], transportAccessCodeActive ) == -1) || transportAccessCodeActive.length == 0 ) {

									transportAccessCodeActive.push(snapDict["accesscode"]);
								  $('#tuser').append("<option data-event='"+snapDict["eventID"]+"' value='"+snapDict["accesscode"]+"'>"+snapDict["name"]+"</option>");
									activeTransport.push(snapDict["accesscode"]);
									if(transportAccessCodeActive.length == 1) {
										 CheckTransRemoteControl();
										 int_map_load = true;
										 intLiveMap();
									}

							} else {
								//console.log("Call #1");
								activeTransport.push(snapDict["accesscode"]);

							}
				 }

		 });
		 //console.log(transportAccessCodeActive);
		 //console.log(activeTransport);
		 if(activeTransport.length > 0) {
			 		var isRemove = false;
					 for(var i=0; i<=transportAccessCodeActive.length-1; i++) {
		 					//console.log(transportAccessCodeActive[i] + " " + snapDict["accesscode"]);
		 					var result = jQuery.inArray( transportAccessCodeActive[i], activeTransport );
							if(result == -1) {
								 //remove the transport user to DROPDOWN
								 $("#tuser option[value='"+transportAccessCodeActive[i]+"']").remove();
								 //remove the accesscode from the transportAccessCodeActive array
								 var index = transportAccessCodeActive.indexOf(transportAccessCodeActive[i]);
								 transportAccessCodeActive.splice(index, 1);
								 isRemove = true;
							}
		 					//console.log(result + " " + transportAccessCodeActive[i]);
		 		 }

				 //check if there is any user remove from the dropdown (active user)
				 //if true then call checktransremotecontrol function to refresh the content of the transport
				 if(isRemove == true) {
					   transportCounter=0;
					   CheckTransRemoteControl();
						 isRemove = false;
				 }
		 }



		 console.log(transportAccessCodeActive);
	 } else {
		 //reset the remote control button
		 //console.log("Call #2");
		 transportAccessCodeActive = [];
		 activeTransport = [];
			$("#remoteon_button").hide();
			$("#logout_button").hide();
			HideRemoteControl();
			$("#tuser").empty();

	 }
});


function CheckTransRemoteControl() {
	   var currentTransport = $('#tuser').val();
		 transportAccessCode = currentTransport;
		// console.log("Current Transport: " + currentTransport);
     //console.log(transportAccessCode);
		 var transRemoteRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+currentTransport);
		 transRemoteRef.on('value', function(snapshot) {
        //console.log(snapshot.val())
			 	if (snapshot.exists()) {
					//console.log(snapshot.val());
					var user_camera_trans = snapshot.val().user_remote_activate_camera;
					var user_video_trans = snapshot.val().user_remote_activate_video;
					var user_remote_activate_trans = snapshot.val().user_remote_activate;
					var user_remote_manual_start_trans = snapshot.val().user_remote_manual_start;
                    var is_app_in_background = snapshot.val().apib; //check if app in background if true hide the remote control button and display the notification else vice versa

					//if feeds already started check the value of remote control to display the proper button
					if(user_remote_activate_trans == false) {
						//display the remote off button and hide the remote on button
						$("#remoteon_button").hide();
						$("#logout_button").hide();
						if(trans_popup == false) {
							$("#trackon_button").show();
						}
						$("#trans_loadingfeed").hide();

						transportCounter = transportCounter + 1;
						//console.log("transportCounter" + transportCounter);
						if(transportCounter == 1) {
							//setTimeout(function(){
								CheckCurrentUser();
							//},2000);

						}

						transportEventID = snapshot.val().eventID;
						//console.log("Remote Control: " + transportEventID);

						if(user_video_trans == true) {
							$("#trackoff_button_video").show();
							$("#trackon_button_video").hide();
						} else {
							$("#trackon_button_video").show();
							$("#trackoff_button_video").hide();
						}

						if (user_camera_trans == true && user_video_trans == true) {
								$("#track_button_camera_front").show();
								$("#track_button_camera_back").hide();
						} else if(user_camera_trans == false && user_video_trans == true) {
							 $("#track_button_camera_back").show();
							 $("#track_button_camera_front").hide();
						} else {
							$("#track_button_camera_back").hide();
							$("#track_button_camera_front").hide();
						}

						var user_flash_trans = snapshot.val().user_remote_activate_flash;
						if (user_flash_trans == true && user_video_trans == true && user_camera_trans == true) {
							 $("#track_button_flash_off").show();
							 $("#track_button_flash_on").hide();
						} else if (user_flash_trans == false && user_video_trans == true && user_camera_trans == true) {
							$("#track_button_flash_on").show();
							$("#track_button_flash_off").hide();
						} else {
							$("#track_button_flash_on").hide();
							$("#track_button_flash_off").hide();
						}


					} else {
						// console.log("Remote Call #1");
						// console.log("Select value: "+ $('#tuser').val());
						// console.log("currentTransport : "+ currentTransport);
						// console.log("Remote Control access code"+ snapshot.val().accesscode);
						if($('#tuser').val() == snapshot.val().accesscode) {
							 //if feeds is not yet started display the remote on button
							 HideFeedsAndMap();
							 transportCounter = 0;
							 TransportDefaultMap();
							 HideRemoteControl();
							 $("#remoteon_button").show();
							 $("#logout_button").show();
							 //$("#trans_loadingfeed").html("Connecting to server....");
							 $("#trans_loadingfeed").hide();
						}

					}

				} else {
					//console.log("Remote Call #2");
					transportCounter = 0;
					TransportDefaultMap();
					HideRemoteControl();
					$("#remoteon_button").show();
					$("#logout_button").show();
					$("#trans_loadingfeed").hide();
				}




                           //check if app is in background
                           console.log("CheckTransRemoteControl");
                           console.log(is_app_in_background);

                           if (is_app_in_background == true) {
                                   HideRemoteControl();
                                   $("#app_in_background").show();
                                   $("#remoteon_button").hide();
                                   $("#logout_button").hide();

                           } else {
                                $("#app_in_background").hide();

                           }

		 });

}

$('#tuser').change(function() {
	  transportCounter = 0;
	  HideFeedsAndMap();
	  HideRemoteControl();
		CheckTransRemoteControl();
		CheckCurrentUser();
		int_map_load = false;
		intLiveMap();

});

function HideRemoteControl() {
	$("#trackoff_button_video").hide();
  $("#trackon_button_video").hide();
  $("#trackon_button").hide();
  $("#track_button_camera_front").hide();
  $("#track_button_camera_back").hide();
  $("#track_button_flash_off").hide();
  $("#track_button_flash_on").hide();
}


function HideFeedsAndMap() {
	$("#tusermapDefault").hide();
	$("#liveStreamTransport").hide();
	$("#tusermap").show();
	$("#transportPlayer").hide();
	//$('#transportPlayer').css('display', 'none');
	TransportDefaultMap();
	ClearTransportFeeds();
	transportAccessCode = 0;
	int_map_load = true;
	intLiveMap();
}

//This function is used to check if the user exists on firebase
function CheckCurrentUser() {
	   var currentTransport = $('#tuser').val();
		 //console.log("Current TRansport: " + currentTransport);
	   var currentUserRef = firebase.database().ref('users/{{Session::get('users_id')}}/transport/');
		 currentUserRef.orderByChild('accesscode').equalTo(currentTransport).once('child_added', function(snapshot) {

			 //console.log(snapshot.val());
			 //console.log("hello world");
				 $("#transportPopupVideo").html("");
				 $("#trans_loadingfeed").hide();

				 if (snapshot.val() == null) {
				 	//console.log("Current User: "+ currentTransport);
					  HideFeedsAndMap();
						HideRemoteControl();

				 } else {
					  //console.log("CheckCurrentUser");
					  //console.log("Number of Children: " + snapshot.numChildren());
					  $("#tusermapDefault").hide();
				 		$("#liveStreamTransport").hide();
				 		$("#tusermap").show();
				 		$("#transportPlayer").show();
						//$('#transportPlayer').css('display', 'block');
				 		$("#video-player").show();

						var snapDict = snapshot.val();
						transportEventID = snapDict["eventID"];
						//console.log("Orig Transport ID: " + transportEventID);
						if(transportEventID < $("#tuser").find(':selected').data('event')) {
							transportEventID = $("#tuser").find(':selected').data('event');
							//console.log("New Transport ID: " + transportEventID);
						}

						TransportDefaultMap();
						CallTransportMapStreaming(currentTransport);
						MultiplePopupTransport(currentTransport,snapDict["name"]);



				 }
		 });
}

function TransportDefaultMap() {

	$("#tusermapDefault").hide();
	$("#tusermap").show();

	var myCenter = new google.maps.LatLng(38.907192, -77.036871);
	var mapOptions = {
				center:myCenter,
				mapTypeId: 'hybrid',
				zoom:18
	};
	 jv_tUserMap = new google.maps.Map(document.getElementById("tusermap"), mapOptions);
	 jv_tUserMap.setTilt(45);
}

//Clear all content of transport feeds
function ClearTransportFeeds() {
	$(".transport_location").html("");
	$(".transport_tds").html("");
	$(".transport_speed").html("");
	$(".transport_elevation").html("");
	$(".transport_direction").html("");
	$(".transport_battery_level").html("");
	$(".transport_event").html("");
	$(".transport_lat").html("");
	$(".transport_lng").html("");


	$(".transport_popup_location").html("");
	$(".transport_popup_tds").html("");
	$(".transport_popup_speed").html("");
	$(".transport_popup_elevation").html("");
	$(".transport_popup_direction").html("");
	$(".transport_popup_battery_level").html("");
	$(".transport_popup_event").html("");
	$(".transport_popup_lat").html("");
	$(".transport_popup_lng").html("");
}

//for parsing current location to map and streaming of live feeds
function CallTransportMapStreaming(accesscode) {

	//setTimeout(function(){ $('#transportPlayer').css('display', 'block'); }, 2000);

  $('#transportPlayer').show();

	//console.log("map : " + transportEventID);
	//console.log("EVENT101: " + $("#tuser").find(':selected').data('event'));

    GetLocationTransport(accesscode);

   StreamingLiveTransport("rtmp://{{STREAMINGIPADDRESS}}/live/"+accesscode+"-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}");



}

//For Multiple transport Popup functionality
function MultiplePopupTransport(accesscode, name) {
		var frameTransportVideoClassCounter = $('.frame-video'+accesscode).length;

		if(frameTransportVideoClassCounter == 0) {
			$("#transportPopupVideo").append("<div id='frame-video' class='frame-video"+accesscode+"' style='width:400px !important; height: 400px !important;'><div class='col-lg-12 header' align='right'><span class='btn btn-warning btn-sm'>Live Streaming - Transport ("+name+") </span><span id='videoClose' class='btn btn-danger btn-sm' onClick='transportClose("+accesscode+")'>X</span></div><div class='col-lg-12' style='width:100% !important; height: 83% !important;'><div id='transportPlayerPopup"+accesscode+"' class='transportPlayerPopup"+accesscode+"' class='col-lg-12' style='z-index: 99999; height: 100%; width: 82%;'></div></div><div class='col-lg-12 header' align='right'><span id='videoClose' class='btn btn-danger btn-sm' onClick='transportClose("+accesscode+")'>X</span></div></div>");
			$( ".frame-video"+accesscode ).draggable({ handle:'.header'}).resizable();
		}

}


//parse the current location of user to the map and to the event intelligence
function GetLocationTransport(accesscode) {
	var transCurrentLocationRef = firebase.database().ref('user_location/'+accesscode);
   transCurrentLocationRef.on('value', function(snapshot) {

			 var snapDict = snapshot.val();

			 if(snapDict == null) {

			 	//console.log("Location call");
				   //HideFeedsAndMap();
			 } else {

				 var lat = parseFloat(snapDict["lat"]);
				 var lon = parseFloat(snapDict["lon"]);

				 $("#transport_location").html()

				 transportLastUpdatedDate = snapDict["lastUpdatedDate"];
				 transportEventID = snapDict["event_id"];
				 //console.log("Location: " + transportEventID);
				 		/*
               if(latestEventBasedonLocation != transportEventID) {
                   latestEventBasedonLocation = transportEventID;
                   StreamingLiveTransport("rtmp://{{STREAMINGIPADDRESS}}/live/"+accesscode+"-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}");
               }
							 */

				 var currentTransport = $('#tuser').val();
				 if(currentTransport == accesscode) {
					 TransportFeed(snapDict);
					 InitMapTransport(lat,lon);
				 }

			 }

		 });
}


//parse the current location of transport to map
function InitMapTransport(lat,lon) {
	var coordinate = {lat: lat, lng: lon};

	ClearTransportMarker();

	var marker = new google.maps.Marker({
		position: coordinate,
		map: jv_tUserMap,
		optimized: false,
		icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
	});

	transportMarker.push(marker);
	jv_tUserMap.setCenter(new google.maps.LatLng(lat,lon));

}

//clear the traport marker on map
function ClearTransportMarker() {
	  for(i=0; i<transportMarker.length; i++){
				transportMarker[i].setMap(null);
		}
}

//populate location data to event intelligence
function TransportFeed(data) {
			$(".transport_location").html(data["location_now"]);
			$(".transport_tds").html(data["tds"]);
			$(".transport_speed").html(data["speed"]+ " mph");

			$(".transport_direction").html(data["direction"]);
			$(".transport_battery_level").html(data["battery_level"]);
			$(".transport_event").html(data["event_id"]);
			$(".transport_lat").html(data["lat"]);
			$(".transport_lng").html(data["lon"]);
			//$(".transport_floor").html(data["floor"]);

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
			//$(".transport_popup_floor").html(data["floor"]);

			if(data["elevation"] === undefined) {
				$(".transport_popup_elevation").html("0.0 ft");
			} else {
				$(".transport_popup_elevation").html(data["elevation"]+" ft");
			}
}


function StreamingLiveTransport(src) {
	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'transparent'};
	var attributes={id:'transportPlayer'};
	swfobject.embedSWF('https://raptorsecuritysoftware.com/public/assets/player.swf','transportPlayer','100%','300','10.2',null,flashvars,params,attributes);
}


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


//This function is use to display the trnsport popup live feeds
function displayPopupTransport() {

	//alert("To remote off user, close the pop up.");
	trans_popup = true;
	$("#trackon_button").hide();
	accesscode = $("#tuser").val();
	StreamingLiveTransportPopup("rtmp://{{STREAMINGIPADDRESS}}/live/"+accesscode+"-"+transportEventID+"?accesscode={{Session::get('securityCode')}}&token={{Session::get('securityToken')}}",accesscode);


	$(".frame-video"+accesscode).fadeIn();
	 $('#transportPlayer').hide();
	 //$('#transportPlayer').css('display', 'none');

}

function StreamingLiveTransportPopup(src,accesscode) {

	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
	var attributes={id:'transportPlayerPopup'+accesscode};
	swfobject.embedSWF('https://raptorsecuritysoftware.com/public/assets/player.swf','transportPlayerPopup'+accesscode,'100%','100%','10.2',null,flashvars,params,attributes);
}

function transportClose(accesscode) {

	$(".frame-video"+accesscode).fadeOut();
	$('#transportPlayer').show();
	$("#trackon_button").show();
	trans_popup = false;
}


//This funtion is used if transport is active. If there is no activity within 30mins
//Transport will automatically log off to console
/*
setInterval(function(){ CheckTransStatus(); },300000);
function CheckTransStatus() {



		if(transportNewUpdatedDate == "") {
			  transportNewUpdatedDate = transportLastUpdatedDate;
		} else {

			  if(transportNewUpdatedDate == transportLastUpdatedDate) {
						StopTransport();
				} else {
						transportNewUpdatedDate = transportLastUpdatedDate;
				}
		}
}

function StopTransport() {
	var activeAccesscode  = $("$tuser").val();

	$.ajax({
						cache: false,
						type:'POST',
						url:'{{url('api/v1/stop/streaming_web')}}',
						headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
						data:"accesscode="+activeAccesscode,
						success:function(response) {
								transportNewUpdatedDate = "";
								transportLastUpdatedDate = "";
						}
	});
}
 */


var user_activity_date;

setInterval(function(){ CheckUserActivity(); CheckUserAgentActivity(); },120000);
function CheckUserActivity() {
    var currentTransport = $('#tuser').val();
    console.log("CheckUserActivity");
    var check_user_activity = firebase.database().ref('cua/{{Session::get('users_id')}}/transport/'+currentTransport);
    check_user_activity.once('value', function(snapshot) {
                             if (snapshot.exists()) {
                             if(snapshot.val().dt == user_activity_date) {
                             StopTransportActivity();
                             check_user_activity.remove();
                             } else {
                             user_activity_date = snapshot.val().dt;
                             console.log(user_activity_date);
                             }

                             }


                             });
}



function StopTransportActivity() {
    var activeAccesscode  = $("#tuser").val();
    console.log("StopTransportActivity");
    console.log(activeAccesscode);
    $.ajax({
           cache: false,
           type:'POST',
           url:'{{url('api/v1/stop/streaming_web')}}',
           headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
           data:"accesscode="+activeAccesscode,
           success:function(response) {
           user_activity_date = "";
           HideFeedsAndMap();
           HideRemoteControl();
           }
           });
}



//remote control button functionality
$( "#trackoff_button_video" ).click(function() {
		$("#trackoff_button_video").hide();

		$("#trackon_button_video").show();
		$("#track_button_camera_front").hide();
		$("#track_button_camera_back").hide();
		$("#track_button_flash_off").hide();
		$("#track_button_flash_on").hide();

		UpdateRemoteControlVideo(false);

});

$( "#trackon_button_video" ).click(function() {
		$("#trackoff_button_video").show();
		$("#trackon_button_video").hide();
		$("#track_button_camera_back").show();
		$("#track_button_flash_on").show();
		UpdateRemoteControlVideo(true);
});



function UpdateRemoteControlVideo(status) {
	var transportAccessCode = $("#tuser").val();
	var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
	userTransRef.update({user_remote_activate_video: status});
}


$("#track_button_camera_back").click(function() {
		$("#track_button_camera_back").hide();
		$("#track_button_camera_front").show();
		$("#track_button_flash_on").show();
		$("#track_button_flash_off").hide();
		UpdateRemoteControlCamera(true);
});


$("#track_button_camera_front").click(function() {
		$("#track_button_camera_back").show();
		$("#track_button_camera_front").hide();
		$("#track_button_flash_on").hide();
		$("#track_button_flash_off").hide();
		UpdateRemoteControlCamera(false);
});


function UpdateRemoteControlCamera(status) {
	 var transportAccessCode = $("#tuser").val();
	 var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
	 userTransRef.update({user_remote_activate_camera: status});
}

$("#track_button_flash_on").click(function() {
	$("#track_button_flash_off").show();
	$("#track_button_flash_on").hide();

	UpdateRemoteControlFlash(true);
	$("#track_button_camera_front").hide();
});

$("#track_button_flash_off").click(function() {
	$("#track_button_flash_off").hide();
 $("#track_button_flash_on").show();

 UpdateRemoteControlFlash(false);
 $("#track_button_camera_front").show();
});

function UpdateRemoteControlFlash(status) {
	var transportAccessCode = $("#tuser").val();
	var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
	userTransRef.update({user_remote_activate_flash: status});
}


$("#trackon_button").click(function() {
	 var transportAccessCode = $("#tuser").val();
	 var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
   userTransRef.update({user_remote_system_off: true});

	 $("#trans_loadingfeed").html("Disconnecting from server...");
	 $("#trans_loadingfeed").show();
	 transportCounter = 0;
	 HideRemoteControl();

});


$("#remoteon_button").click(function () {
	 var transportAccessCode = $("#tuser").val();
	 var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
    userTransRef.update({user_remote_activate: false});

	 $("#trans_loadingfeed").html("Connecting to server...");
	 $("#trans_loadingfeed").show();
	 $("#remoteon_button").hide();
	 $("#logout_button").hide();

	 HideRemoteControl();

	 setTimeout(function(){
		 CheckTransRemoteControl();
		 CheckCurrentUser();
	 },7000);
	 //CheckCurrentUser();

	 //check the transport if there is an active users_id
	//  setTimeout(function() {
  //     CheckActiveUserTransport();
  //  }, 20000);
});


function CheckActiveUserTransport() {
	var transportAccessCode = $("#tuser").val();
	var activeTransport =  firebase.database().ref('users/{{Session::get('users_id')}}/transport');
	activeTransport.once('value', function(snapshot) {
			if (snapshot.val() == null) {
					// $("#trans_loadingfeed").html("No Live Transport...");
					 $("#trans_loadingfeed").hide();

					 //remove from remote control
					 var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
					 userTransRef.remove();

			}
	});
}



$("#logout_button").click(function() {
	   var transportAccessCode = $("#tuser").val();
		 var userTransRef = firebase.database().ref('remote_control/{{Session::get('users_id')}}/transport/'+transportAccessCode);
		 userTransRef.remove();
});


</script>