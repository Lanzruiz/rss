<?php
//$InOffFtc = mysqli_fetch_object($InOff);
$userData = \App\Models\AlertDetails::checkClientData(1);

$GLOBAL_BUSER_ID = $userData->user_id;
//echo $GLOBAL_BUSER_ID;
$GLOBAL_BUSER_EVENT = $userData->events;
//echo $GLOBAL_BUSER_EVENT;
//exit();
if($GLOBAL_BUSER_EVENT == '' || $GLOBAL_BUSER_EVENT == NULL || $GLOBAL_BUSER_EVENT == 0){
	$GLOBAL_BUSER_EVENT = 1;
}
//echo $GLOBAL_BUSER_ID.', '.$InOffFtc->user_name.', '.$GLOBAL_BUSER_EVENT;
//include 'pages/bu_functions.php';
?>
<script>
var buserChange = false;
var buserEventChange = false;
var officer_video = null;
var officerMarker = [];
var jv_busers = <?php echo json_encode(\App\Models\AlertDetails::displayUsers($client_id,1));?>;
var jv_bu_event = <?php echo json_encode(\App\Models\AlertDetails::displayEvents($GLOBAL_BUSER_ID));?>;
var jv_bu_video = <?php echo json_encode(\App\Models\AlertDetails::displayVideos($GLOBAL_BUSER_ID));?>;
var jv_bu_allfeed = <?php echo json_encode(\App\Models\AlertDetails::displayAllFeeds($GLOBAL_BUSER_ID,$GLOBAL_BUSER_EVENT));?>;
var GLOBAL_BUSER_LAT = jv_bu_allfeed[0]['lat'];
var GLOBAL_BUSER_LNG = jv_bu_allfeed[0]['lng'];
var GLOBAL_BUSER_ID = jv_busers[0]['user_id'];
var GLOBAL_BUSER_NAME = jv_busers[0]['user_name'];
var GLOBAL_BUSER_EVENT = jv_bu_event[0]['events'];
var GLOBAL_BUSER_ACCESSCODE = jv_bu_event[0]['user_code'];
var GLOBAL_AGENT_REFRESH = false;
var agentEventPopupID = 0;
var agentActiveEvents = [];
var agentSelectedEvents = '<?php echo $selectAgent; ?>';
//console.log("agentSelectedEvents: " + agentSelectedEvents);
//var GLOBAL_TUSER_EVENT = '';
var bImgLoad = true;
</script>
<script src="{{url('public/assets/archive/bu_functions.js')}}"></script>
<div class="col-lg-12 all-background-opacity">
    <div class="col-lg-5">
        <ul class="nav nav-tabs headerText" role="tablist">
            <li class="col-lg-3 responsiveVersion-3"><p class="eventText">Archived Event</p></li>
            <?php /*
            <li id="bu_video_click" role="presentation" class="active"><a href="#bu_video" role="tab" aria-controls="bu_video" data-toggle="tab">Video</a></li>
            */ ?>

						<div class="col-lg-5">
            	<form method="post" action="{{url('dashboard/archived-agent')}}">
            		<input type="text" name="eventAgent" value="" class="eventAgent" style="color: #000">
            		<input type="hidden" name="eventAgentID" class="eventAgentID">
            		<input type="submit" name="Update" value="Update" class="btn btn-sm btn-danger">
            	</form>
            </div>

            <div class="col-lg-3 select">
                <select class="form-control" id="buser" name="buser"><script>jf_busers();</script></select>
            </div>
            <div style="clear: both;"></div>
        </ul>
        <div class="col-lg-3 responsiveVersion-3">
        	<ul class="col-lg-12 tu-event" id="bu_event" ><script>//jf_bu_events();</script></ul>


						 <div class="col-lg-12 loadMoreButton" lastid=""><a class="btn btn-danger btn-sm" href="javascript:void(0)" id="deleteSelectedEvent" data-accesscode="" data-events="" onClick="deleteEventAgent()">Delete selected event</a></div>
            <div class="col-lg-12 loadMoreButton" id="loadMoreBuserEvent" lastid=""><p>Add Events</p></div>
       	</div>
        <div class="col-lg-9 tab-content responsiveVersion-9">
        	<div role="tabpanel" class="col-lg-12 border-right-10px tab-pane active" id="bu_video">
        		<?php /*
            	<div class="col-lg-3">
                	<ul class="col-lg-12 tu-event" id="officer_video_feed" ><script>//jf_bu_videos();</script></ul>
                	<div class="col-lg-12 loadMoreButton" id="loadMoreBuserVideo" lastid=""><p>Load More Video</p></div>
               	</div>
               	*/ ?>
                <div class="col-lg-12" >
                	<!--<span id="officer_video_feed"></span>-->
							<?php /*<div onmousedown="agentPopUp()">*/ ?>
								<video id="officer_video" width='100%' controls></video>
								<div class="popupAgentClickable" onclick="agentPopUp()">&nbsp;</div>
							<?php /*</div>*/ ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <p>Agent Map</p>
        <div id="busermap" class="top-btm-map" ></div>
        <div id="busermapmsg" align="center">
        	<p style="color:#000">Loading map data: Event-<span class="eventID"></span><br />of <br />
            Agent-<span class="selectedbuserid" style="color:#F00"></span></p>
      	</div>
    </div>

    <div class="col-lg-2">
        <p>Event Intelligence - Agent <span id="aZoomIn" class="btn btn-primary btn-xs">+</span></p>
        <div class="tu-last-frequency" id="buserDataFrequency">
       	&nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="buser-location"></span><hr>
        &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="buser-event"></span><hr>
        &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="buser-tds"></span><hr>
        &nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="buser-speed"></span><hr>
        &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="buser-elevation"></span><hr>
        &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="buser-direction"></span><hr>
				&nbsp;&nbsp;Distance:&nbsp;&nbsp;<span class="buser-distance"></span><hr>
				<?php /*&nbsp;&nbsp;Floor:&nbsp;&nbsp;<span class="buser-floor"></span><hr>*/ ?>
        &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="buser-battery-level"></span><hr>
        &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="buser-lat"></span><hr>
        &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="buser-lng"></span><hr>
        </div>
    </div>
</div>


<?php
//include 'include/syncAgAllFeeds.php';
?>
@include('dashboard.archive.syncAgAllFeeds')
@if($alertDetails <= 0)
<script src="{{url('public/assets/swfobject.min.js')}}"></script>
<script src="{{url('public/assets/archive/functions.js')}}"></script>
@endif
<script>
$(document).on("change","#buser", function(e){
	buserChange = true;
	//$("#officer_video").attr("src",'');
	//$("#bu_event").html("<p class='loading'>Loading....</p>");
	$("#officer_playback-button").removeClass("fa-pause").addClass("fa-play");
	GLOBAL_BUSER_ID = $(this).val();
	GLOBAL_BUSER_NAME = $("#buser option:selected").text();
	GLOBAL_BUSER_EVENT = $("#buser option:selected").attr("buser_sel_event");
	GLOBAL_BUSER_ACCESSCODE = $("#buser option:selected").data("accesscode");
	GLOBAL_AGENT_REFRESH = true;

	console.log("Access code new: "+ GLOBAL_BUSER_ACCESSCODE);

	//$("#busermap").html(null);
	//$("#buserDataFrequency").hide();
	//$("#buserDataFrequencyMsg").show();
	//$("#busermap").hide();
	$("#bu_event").empty();
	//$("#agentEventIntelligence").empty();
	//$("#officer_video_feed").empty();

	//$("#busermapmsg").show();
	$(".eventID").html(GLOBAL_BUSER_EVENT);
	$(".selectedbuserid").html(GLOBAL_BUSER_NAME);

	displayAllAgentEvents($(this).val());

	checkNewAgentEvent();

	e.preventDefault();
});




function displayAllAgentEvents(userID) {
	agentActiveEvents = [];
	$.ajax({
	type: "POST",
	url:'{{url('api/v1/display_events_user')}}',
	headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
	//url: "eventVideo.php",
	data:"user_id="+userID,
	success: function(response){

		if(response.message == "Invalid Token Authentication.") {
				console.log("Invalid Token Authentication.");
		}	 else {

			if(response == 'NoMoreEvent'){
				$('#bu_event').html("<p>No events found</p>");

				@if($alertDetails <= 0)
						location.href="https://raptorsecuritysoftware.com/dashboard/archived";
				@endif
				if($('#bu_event').html() == "<p>No events found</p>") {
						location.href="https://raptorsecuritysoftware.com/dashboard/archived";
				}

			}else{
					var fixturesData=JSON.parse(response);
					var thedata='';
					var LastAlertDetailId = '';
					var userAgentID = '';
					var eventAgentID = '';
					actr = 0;
					$('#bu_event').empty();
					//console.log("Empty event user");
					$.each(fixturesData,function(key,item){
						actr = actr + 1;
						LastAlertDetailId = item.alert_detail_id;
						//"<li type='buevent' buevent_id='"+ item.events +"'>Event-"+item.events+"</li>";

						userAgentID = item.user_id;
						agentActiveEvents.push(userAgentID);

						if(actr == 1) {
							eventAgentID = item.events;

							var event_name = "";
							if (item.event_name != " ") {
								event_name = item.event_name;
							} else {
								event_name = "Event - " + item.events;
							}


							thedata += "<li class='activeClass' type='buevent' buaccess_code='"+item.user_code+"' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+event_name+" </li>";

							$(".eventAgent").val(event_name);
							$(".eventAgentID").val(item.alert_detail_id);


							//$("#deleteSelectedEvent").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+item.user_code+'/'+item.events);
							$("#deleteSelectedEvent").data('accesscode',item.user_code);
							$("#deleteSelectedEvent").data('events',item.events);
							GLOBAL_BUSER_ACCESSCODE = item.user_code;
								//play the video
								if(item.filePath != "") {
									<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + item.user_code + "/" + item.events + "/" + item.filePath);*/ ?>

									//$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
									///$("#officer_video").attr("autoplay",true);
									//streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);

									streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.user_code + "-"+item.events+".flv");
									agentEventPopupID = item.alert_detail_id + item.events;
									popupAgentData(agentEventPopupID,item,true);
									//buserAllFeed(buvideo_id);
									Officer_Select_Media(item);

									//GLOBAL_BUSER_EVENT = item.events;


								}

								multipleLocation(item.user_code,item.events,"agent");



								buserAllFeed(item);


						} else {
							var event_name = "";
							if (item.event_name != " ") {
								event_name = item.event_name;
							} else {
								event_name = "Event - " + item.events;
							}

							thedata += "<li type='buevent' buadt_id='"+ item.alert_detail_id +"' buaccess_code='"+item.user_code+"' buevent_id='"+ item.events +"'>"+event_name+" </li>";


						}
					});
					$('#bu_event').append(thedata);
					$("#loadMoreBuserEvent").attr("lastid",LastAlertDetailId);
					$('#loadMoreBuserEvent').html("<p>Add Events</p>");

					//displayAllAgentVideo(userAgentID,eventAgentID);
			}
			} //if authentication
		}
	});
}

// function displayAllAgentVideo(userID,eventID) {


// 	$.ajax({
// 		type: "POST",
// 		url:'{{url('api/v1/display_events_user_video')}}',
// 		//url: "eventVideo.php",
// 		data:"user_id="+userID+"&event_id="+eventID,
// 		success: function(response){

// 				if(response == 'NoVideoFound'){

// 					$('#officer_video_feed').html("<p>No video found</p>");
// 				}else{
// 					var fixturesData=JSON.parse(response);
// 					jv_bu_video = fixturesData;
// 					//jv_bu_video.push(fixturesData);

// 					var thedata='';
// 					var LastAlertDetailId = '';
// 					$.each(jv_bu_video,function(){
// 						LastAlertDetailId = this.alert_detail_id;
// 						thedata += "<li type='buvideo' buvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";

// 					});
// 					$('#officer_video_feed').html(thedata);
// 					$("#loadMoreBuserVideo").attr("lastid",LastAlertDetailId);
// 				}
// 		}

// 	});
// }

$(document).on("click","li[type='buevent']", function(e){
	jv_bu_video = '';
	buserEventChange = true;
	var ActiveItem = $(this);
	$("li[type='buevent']").removeClass("activeClass");
	ActiveItem.addClass("activeClass");
	//$("#officer_video").attr("src",'');
	//$("#officer_video_feed").html("<p class='loading'>Loading....</p>");

	GLOBAL_BUSER_ID = GLOBAL_BUSER_ID;
	GLOBAL_BUSER_EVENT = $(this).attr("buevent_id");
	$("#busermap").html(null);
	//$("#buserDataFrequency").hide();
	//$("#buserDataFrequencyMsg").show();
	$("#busermap").hide();
	$("#busermapmsg").show();
	$(".eventID").html(GLOBAL_BUSER_EVENT);
	$(".selectedbuserid").html(GLOBAL_BUSER_NAME);

	var buaccess_code = $(this).attr("buaccess_code");

	//$("#deleteSelectedEvent").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+buaccess_code+'/'+GLOBAL_BUSER_EVENT);
	$("#deleteSelectedEvent").data('accesscode',buaccess_code);
	$("#deleteSelectedEvent").data('events',GLOBAL_BUSER_EVENT);
	GLOBAL_BUSER_ACCESSCODE = buaccess_code;
	//var bueventphotodata = {buevent_id: GLOBAL_BUSER_EVENT, buser_id: GLOBAL_BUSER_ID};
	/*$.ajax({
	  type: "POST",
	 url: "OfficerEventPhoto.php",
	 data: bueventphotodata,
	 success: function(response){
			setTimeout(function(){
				$("#bu_photo").html(response);

			},500);
		}
	});	*/


	$.ajax({
		type: "POST",
		url: '{{url('api/v1/bRecords')}}',
		headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
		data: "status=getVideo&user_id="+GLOBAL_BUSER_ID+"&bEvent="+GLOBAL_BUSER_EVENT,
		success: function(response) {
			if(response.message == "Invalid Token Authentication.") {
					console.log("Invalid Token Authentication.");
			}	 else {

						var data=JSON.parse(response);

						var event_name = "";
						if (data.event_name != " ") {
							event_name = data.event_name;
						} else {
							event_name = "Event - "+data.events;
						}

						$(".eventAgent").val(event_name);
						$(".eventAgentID").val(data.alert_detail_id);

						if(data.filePath != "") {
							<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + data.user_code + "/" + data.events + "/" + data.filePath);*/ ?>

							//$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.filePath);
							//streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.filePath);
							streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.user_code + "-"+data.events+".flv");
							agentEventPopupID = data.alert_detail_id + data.events;
							popupAgentData(agentEventPopupID,data,true);

							//$("#officer_video").attr("controls",true);
							//$("#officer_video").attr("autoplay",true);
							//buserAllFeed(buvideo_id);
							multipleLocation(data.user_code,data.events,"agent");


							//Officer_Select_Media(data);




						} else if(data.lat != "") {


						}


						buserAllFeed(data);
			 } //if authentication
		}
	});

	// $.ajax({
	// type: "POST",
	// url:'{{url('api/v1/bRecords')}}',
	// //url: "eventVideo.php",
	// data:"status=eventVideo&user_id="+GLOBAL_BUSER_ID+"&bEvent="+GLOBAL_BUSER_EVENT,
	// success: function(response){
	// 		if(response == 'NoVideoFound'){

	// 			$('#officer_video_feed').html("<p>No video found</p>");
	// 		}else{
	// 			var fixturesData=JSON.parse(response);
	// 			jv_bu_video = fixturesData;
	// 			//jv_bu_video.push(fixturesData);

	// 			var thedata='';
	// 			var LastAlertDetailId = '';
	// 			$.each(jv_bu_video,function(){
	// 				LastAlertDetailId = this.alert_detail_id;
	// 				thedata += "<li type='buvideo' buvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";

	// 			});
	// 			$('#officer_video_feed').html(thedata);
	// 			$("#loadMoreBuserVideo").attr("lastid",LastAlertDetailId);
	// 		}
	// 	}
	// });

	e.preventDefault();
});

$(document).on("click","li[type='buvideo']", function(e){
	//selected Item highlight section
	var ActiveItem = $(this);
	$("li[type='buvideo']").removeClass("activeClass");
	ActiveItem.addClass("activeClass");
	var buvideo_id = $(this).attr("buvideo_id");
  var buaccess_code = $(this).attr("buaccess_code");
	//$("#deleteSelectedEvent").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+buaccess_code+'/'+GLOBAL_BUSER_EVENT);
	$("#deleteSelectedEvent").data('accesscode',buaccess_code);
	$("#deleteSelectedEvent").data('events',GLOBAL_BUSER_EVENT);
	GLOBAL_BUSER_ACCESSCODE = buaccess_code;
	$(jv_bu_video).each(function(){
		if(buvideo_id == this.alert_detail_id){// && this.video != null){

			//$("#officer_video").attr("src", "");
			//$("#officer_video").attr("src", this.filePath);//media_path+this.user_id+"/video/"+this.video);
			if(this.filePath != "") {
				<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + this.user_code + "/" + this.events + "/" + this.filePath); */ ?>
				//$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.filePath);
				//streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.filePath);
				streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.user_code + "-"+this.events+".flv");
				agentEventPopupID = this.alert_detail_id + this.events;
				popupAgentData(agentEventPopupID,this,true);

				//$("#officer_video").attr("controls",true);
				//$("#officer_video").attr("autoplay",true);
				//buserAllFeed(buvideo_id);
				Officer_Select_Media(this);
			}


			buserAllFeed(this);
		}
	});

	e.preventDefault();
});

function buserAllFeed(data){

	$(".buser-location").html(data.location_now);
	$(".buser-tds").html(data.alert_datetime);
	$(".buser-speed").html(data.alert_speed+ " mph");
	$(".buser-elevation").html(data.elevation+" ft");
	$(".buser-direction").html(data.direction);
	$(".buser-level").html(data.level);
	$(".buser-battery-level").html(data.alert_battery_level);
	$(".buser-event").html(data.events);
	$(".buser-ip").html(data.ip_address);
	$(".buser-lat").html(data.lat);
	$(".buser-lng").html(data.lng);
	if(data.distanceType) {
		$(".buser-distance").html(data.distance + " " + data.distanceType);
  } else {
		$(".buser-distance").html(data.distance + " miles");
	}
	//$(".buser-floor").html(data.floor);
	$("#location_now").html("Address: <span>"+data.location_now+"</span>, TDS: <span>"+data.alert_datetime+"</span>, Speed: <span>"+data.alert_speed+"</span>, Elevation: <span>"+data.elevation+"ft</span>, Direction: <span>"+data.direction+"</span>");

}

/*function buserAllFeed(custom_id){
	$(jv_bu_allfeed).each(function(){
		if(this.alert_detail_id == custom_id){
			var media_status = "";
			$(".buser-location").html(this.location_now);
			$(".buser-tds").html(this.alert_datetime);
			$(".buser-speed").html(this.alert_speed);
			$(".buser-elevation").html(this.elevation+"ft");
			$(".buser-direction").html(this.direction);
			$(".buser-level").html(this.level);
			$(".buser-battery-level").html(this.alert_battery_level);
			$(".buser-event").html(this.events);
			$(".buser-ip").html(this.ip_address);
			$(".buser-lat").html(this.lat);
			$(".buser-lng").html(this.lng);
			$("#location_now").html("Address: <span>"+this.location_now+"</span>, TDS: <span>"+this.alert_datetime+"</span>, Speed: <span>"+this.alert_speed+"</span>, Elevation: <span>"+this.elevation+"ft</span>, Direction: <span>"+this.direction+"</span>");
		}
	});
}*/

$(document).on("click", "#bu_photo img", function(e) {
	var src = $(this).attr("src");
	$("#mainImage").attr("src", src);
	$("#frame").fadeIn();
	//$("#overlay").fadeIn();
	/*$("#overlay").click(function(){
		$(this).fadeOut();
		$("#frame").fadeOut();
	});*/
	$("#frame").click(function(){
		$(this).fadeOut();
		//$("#overlay").fadeOut();
	});
	e.preventDefault();
});

</script>
<!--<script src="pages/buserfeedsync.js"></script>-->
<script>
//buser map
var officer_map = null;
var officer_selectedMarker = null;
//var officer_infoWindow = new google.maps.InfoWindow();
function officer_initialize(){
	if(GLOBAL_BUSER_LAT == 0 && GLOBAL_BUSER_LNG == 0) {
			var officer_myCenter = new google.maps.LatLng(38.907192, -77.036871);
	} else {
			var officer_myCenter=new google.maps.LatLng(GLOBAL_BUSER_LAT,GLOBAL_BUSER_LNG);
	}


	var officer_mapProp = {
	  center:officer_myCenter,
	  zoom:18,
		mapTypeId: 'hybrid',
	 // mapTypeId:google.maps.MapTypeId.SATELLITE,//SATELLITE,
	  fullscreenControl: true
	  };
	officer_map=new google.maps.Map(document.getElementById("busermap"),officer_mapProp);
	officer_map.setTilt(45);

	if(GLOBAL_BUSER_LAT != 0 && GLOBAL_BUSER_LNG != 0) {
		officer_marker=new google.maps.Marker({
	  	position:officer_myCenter,
	  	icon: '{{url('public/assets/images/agent-o.png')}}'
		});
		officer_marker.setMap(officer_map);
		officer_selectedMarker = officer_marker;
		//officer_infoWindow.setContent("<span class='infoWindow'><strong>Address:</strong> "+jv_bu_allfeed[0]['location_now']+"<br><strong>TDS:</strong> "+jv_bu_allfeed[0]['alert_datetime']+" || <strong>Speed:</strong> "+jv_bu_allfeed[0]['alert_speed']+"<br><strong>Elevation:</strong> "+jv_bu_allfeed[0]['elevation']+"ft || <strong>Direction:</strong> "+jv_bu_allfeed[0]['direction']);
		//officer_infoWindow.open(officer_map,officer_marker);
		google.maps.event.addListener(officer_marker, 'click', function() {
  		//officer_infoWindow.open(officer_map,officer_marker);
  		});
	}

	var bmusumarker, w;
	for (w = 1; w < jv_bu_allfeed.length; w++) {
		bmusumarker = new google.maps.Marker({
			position: new google.maps.LatLng(jv_bu_allfeed[w]["lat"], jv_bu_allfeed[w]["lng"]),
			icon: uns_2,
			map: officer_map
		});
		google.maps.event.addListener(bmusumarker, 'click', (function(bmusumarker, w) {
		return function() {
		var alert_detail_id = jv_bu_allfeed[w]["alert_detail_id"];
		var location_now = jv_bu_allfeed[w]["location_now"];
		var alert_datetime = jv_bu_allfeed[w]["alert_datetime"];
		//officer_infoWindow.open(officer_map, bmusumarker);
				$(jv_bu_allfeed).each(function(){
					if(this.alert_detail_id == alert_detail_id){

						//buserAllFeed(alert_detail_id);
						//remove all selected officer_marker
						if(officer_selectedMarker != null) {
							officer_selectedMarker.setMap(null);
					  }
						//set as selected officer_marker
						var latLang124 = new google.maps.LatLng(this.lat, this.lng);
						var marker3 = new google.maps.Marker({
							position:latLang124,
							map: officer_map,
							title: this.location_now,
							icon: '{{url('public/assets/images/agent-o.png')}}'//selectedMarkerIcon
						  });
						officer_selectedMarker = marker3;
						if(this.fileType == 'video'){
							$("#officer_video").show();
							//$("#OfficerPlayPauseButton").hide();
							//$("#officer_video_feed").html("");
							//$("#officer_audio_feed").html("<p>selected point's media is video, please see video on video tab</p>");
							$('a[href="#bu_video"]').tab("show");
							if(this.alert_detail_id = jv_bu_allfeed[w]["alert_detail_id"]){
								//$("#officer_video").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/video/'+jv_bu_allfeed[w]["video"]);

								//$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_allfeed[w]["user_code"] + "/" + jv_bu_allfeed[w]["events"] + "/" + jv_bu_allfeed[w]["filePath"]);

								//$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_allfeed[w]["filePath"]);
								//streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_allfeed[w]["filePath"]);
								streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_allfeed[w]["user_code"] + "-"+jv_bu_allfeed[w]["events"]+".flv");
								agentEventPopupID = jv_bu_allfeed[w]["alert_detail_id"] + jv_bu_allfeed[w]["events"];
								popupAgentData(agentEventPopupID,jv_bu_allfeed[w],false);
								//$("#officer_video").trigger("play");
								// $("#officer_video").on("ended", function(){
								// 	//alert("Hello");
								// 	//$("#officer_video").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/video/'+jv_bu_allfeed[w]["video"]);
								// 	<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_allfeed[w]["user_code"] + "/" + jv_bu_allfeed[w]["events"] + "/" + jv_bu_allfeed[w]["filePath"]);*/ ?>
								// 	$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_allfeed[w]["filePath"]);
								// 	//$("#audio").trigger("pause");
								// });
								//$("#officer_audio").attr("src", "");
								return false;
							}
						}
					}
				});
			}
		})(bmusumarker, w));
	}
	var flightPlanCoordinatesBuser = jv_bu_allfeed;
	var flightPathBuser = new google.maps.Polyline({
	  path: flightPlanCoordinatesBuser,
	  geodesic: true,
	  strokeColor: '#FFF',
	  strokeOpacity: 1.0,
	  strokeWeight: 5
	});
	flightPathBuser.setMap(officer_map);
}
google.maps.event.addDomListener(window, 'load', officer_initialize);

function officer_addMarkerToTuserMap(officer_map, officer_new_points){
	var bmusumarker, w;
	for (w = 0; w < officer_new_points.length; w++) {
		bmusumarker = new google.maps.Marker({
			position: new google.maps.LatLng(officer_new_points[w]["lat"], officer_new_points[w]["lng"]),
			icon: uns_2,//unSelectedMarkerIcon,
			map: officer_map
		});
		google.maps.event.addListener(bmusumarker, 'click', (function(bmusumarker, w) {
			return function() {
				//officer_infoWindow.setContent("<span class='infoWindow'><strong>Address:</strong> "+officer_new_points[w]['location_now']+"<br><strong>TDS:</strong> "+officer_new_points[w]['alert_datetime']+" || <strong>Speed:</strong> "+officer_new_points[w]['alert_speed']+"<br><strong>Elevation:</strong> "+officer_new_points[w]['elevation']+"ft || <strong>Direction:</strong> "+officer_new_points[w]['direction']);
				//officer_infoWindow.open(officer_map, bmusumarker);
			}
		})(bmusumarker, w));
	}
}


function newOfficer_addMarkerToTuserMap(officer_map, officer_new_points){
	var bmusumarker, w;


		bmusumarker = new google.maps.Marker({
			position: new google.maps.LatLng(officer_new_points.lat, officer_new_points.lng),
			icon: uns_2,//unSelectedMarkerIcon,
			map: officer_map
		});
		google.maps.event.addListener(bmusumarker, 'click', (function(bmusumarker, w) {
			return function() {
				//officer_infoWindow.setContent("<span class='infoWindow'><strong>Address:</strong> "+officer_new_points[w]['location_now']+"<br><strong>TDS:</strong> "+officer_new_points[w]['alert_datetime']+" || <strong>Speed:</strong> "+officer_new_points[w]['alert_speed']+"<br><strong>Elevation:</strong> "+officer_new_points[w]['elevation']+"ft || <strong>Direction:</strong> "+officer_new_points[w]['direction']);
				//officer_infoWindow.open(officer_map, bmusumarker);
			}
		})(bmusumarker, w));

}

function Officer_Select_Media(media_data){
	//buserAllFeed(media_data.alert_detail_id);
	if(officer_selectedMarker != null) {
		officer_selectedMarker.setMap(null);
	}

	if(media_data.lat == 0 && media_data.lng == 0) {
		var latLang = new google.maps.LatLng(38.907192, -77.036871);
	} else {
	 var latLang = new google.maps.LatLng(media_data.lat, media_data.lng);
  }

if(media_data.lat != 0 && media_data.lng != 0) {
		var officer_marker=new google.maps.Marker({
		position:latLang,
		map: officer_map,
		title: media_data.location_now,
		icon: '{{url('public/assets/images/agent-o.png')}}'//selectedMarkerIcon
	  });
	 officer_selectedMarker = officer_marker;
	 //officer_infoWindow.setContent("<span class='infoWindow'><strong>Address:</strong> "+media_data.location_now+"<br><strong>TDS:</strong> "+media_data.alert_datetime+" || <strong>Speed:</strong> "+media_data.alert_speed+"<br><strong>Elevation:</strong> "+media_data.elevation+"ft || <strong>Direction:</strong> "+media_data.direction);
	 //officer_infoWindow.open(officer_map, officer_marker);
	google.maps.event.addListener(officer_marker, 'click', function() {
		//officer_infoWindow.open(officer_map, officer_marker);
	});
}

	officer_map.panTo(latLang);
}

//buser audio player
var officer_current_play_index = 0;
var current_play_indexOfficerVideo = 0;
$(function(){
	//buserAllFeed(jv_bu_allfeed[0]['alert_detail_id']);
	//$("#buserDataFrequencyMsg").hide();
	$("#busermapmsg").hide();

	//video player section start
	// $("#officer_video").on("ended", function(){
	// 	//alert("Hello");
	// 	var next_play_indexOfficerVideo = current_play_indexOfficerVideo + 1;
	// 	if(next_play_indexOfficerVideo >= jv_bu_video.length)
	// 		return;
	// 	$("#officer_video").attr("src", jv_bu_video[next_play_indexOfficerVideo].filePath);//media_path+GLOBAL_BUSER_ID+'/video/'+jv_bu_video[next_play_indexOfficerVideo].video);
	// 	$("#officer_video").trigger("play");
	// 	current_play_indexOfficerVideo = next_play_indexOfficerVideo;
	// 	/*if(jv_bu_video[next_play_indexOfficerVideo].events != GLOBAL_BUSER_EVENT){
	// 		$("#video").attr("src","");
	// 	}*/
	// });
	if(jv_bu_video == null || jv_bu_video == ''){
		console.log('no tUser video found');
		$("#officer_video").hide();
		//$("#officer_video_feed").html("<p>No video found</p>");
	}else{
		$("#officer_video").show();
		<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_video[0]["user_code"] + "/" + jv_bu_video[0]["events"] + "/" + jv_bu_video[0]["filePath"]); */ ?>
		//$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_video[0]["filePath"]);
		//streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_video[0]["filePath"]);
		streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_video[0]["user_code"] + "-"+jv_bu_video[0]["events"]+".flv");
		agentEventPopupID = jv_bu_video[0]["alert_detail_id"] + jv_bu_video[0]["events"];
		popupAgentData(agentEventPopupID,jv_bu_video[0],false);


		//$("#officer_video").attr("src", jv_bu_video[0]["filePath"]);//media_path+GLOBAL_BUSER_ID+'/video/'+jv_bu_video[0]["video"]);

	}
});
$(document).ready(function(){
	$(document).on('click','#loadMoreBuserVideo',function(){
        var ID = $(this).attr('lastid');
        $('#loadMoreBuserVideo').html("<p>Loading video...</p>");
        $.ajax({
            cache: false,
            type:'POST',
            url:'{{url('api/v1/bRecords')}}',
						headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
            data:"status=video&user_id="+GLOBAL_BUSER_ID+"&last_id="+ID+"&bEvent="+GLOBAL_BUSER_EVENT,
            success:function(response){
							if(response.message == "Invalid Token Authentication.") {
									console.log("Invalid Token Authentication.");
							}	 else {

											if(response == 'NoMoreVideo'){
												$('#loadMoreBuserVideo').html("<p>Load More Video</p>");
												//alert("No more video found.");
												//alert('No more image found on Event - '+GLOBAL_BUSER_EVENT);
											}else if(response == 'NoVideoFound'){
												$('#officer_video_feed').html("<p>No video found</p>");
												$('#loadMoreBuserVideo').html("<p>Load More Video</p>");
											}else{
												var fixturesData=JSON.parse(response);
												jv_bu_video = fixturesData;
												var thedata='';
												var LastAlertDetailId = '';

												$.each(jv_bu_video,function(){
													LastAlertDetailId = this.alert_detail_id;
													thedata += "<li type='buvideo' buvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";

												});

												$('#officer_video_feed').append(thedata);
												$("#loadMoreBuserVideo").attr("lastid",LastAlertDetailId);
												$('#loadMoreBuserVideo').html("<p>Load More Video</p>");
											}
								} // if authentication
            }
        });
    });
	//event
	$(document).on('click','#loadMoreBuserEvent',function(){
        var ID = $(this).attr('lastid');

        $('#loadMoreBuserEvent').html("<p>Loading event...</p>");
        $.ajax({
            cache: false,
            type:'POST',
            url:'{{url('api/v1/bRecords')}}',
						headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
            data:"status=events&user_id="+GLOBAL_BUSER_ID+"&last_id="+ID,
            success:function(response){
							if(response.message == "Invalid Token Authentication.") {
							console.log("Invalid Token Authentication.");
					}	 else {

									if(response == 'NoMoreEvent'){
										$('#loadMoreBuserEvent').html("<p>Add Events</p>");
										//$('#loadMoreBuserEvent').html("<p>&nbsp</p>");
										//alert("No more event found.");
										//alert('No more image found on Event - '+GLOBAL_BUSER_EVENT);
									}else if(response == 'NoImageFound'){
										$('#bu_event').html("<p>No event found</p>");
										$('#loadMoreBuserEvent').html("<p>Add Events</p>");
										//$('#loadMoreBuserEvent').html("<p>&nbsp</p>");
									}else{
										/*if(response == 'NoEventFound'){
										$('#tu_event').append("<p>No event found</p>");
										$('#loadMoreBuserEvent').html("<p>Add Events</p>");
										$('#loadMoreBuserEvent').html("<p>&nbsp</p>");
									}else{*/
										var fixturesData=JSON.parse(response);
										var thedata='';
										var LastAlertDetailId = '';
										var uctr = 0;
										$.each(fixturesData,function(key,item){
											uctr = uctr + 1;
											LastAlertDetailId = item.alert_detail_id;

										if(uctr == 1) {
											var event_name = "";
												if (item.event_name != " ") {
													event_name = item.event_name;
												} else {
													event_name = "Event - "+item.events;
												}

											if($('#bu_event li').hasClass('activeClass')) {
													thedata += "<li type='buevent' buaccess_code='"+ item.user_code +"' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+event_name+"</li>";
											} else {
												  thedata += "<li class='activeClass' type='buevent' buaccess_code='"+ item.user_code +"' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+event_name+"</li>";
											}

											$(".eventAgent").val(event_name);
											$(".eventAgentID").val(item.alert_detail_id);

											//$("#deleteSelectedEvent").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+item.user_code+'/'+item.events);
											$("#deleteSelectedEvent").data('accesscode',item.user_code);
											$("#deleteSelectedEvent").data('events',item.events);
											//$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
											//streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
											streamingArchiveAgent("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.user_code + "-"+item.events+".flv");
											agentEventPopupID = item.alert_detail_id + item.events;
											popupAgentData(agentEventPopupID,item,true);

											//$("#officer_video").attr("controls",true);
											//$("#officer_video").attr("autoplay",true);
											multipleLocation(item.user_code,item.events,"agent");
											GLOBAL_BUSER_EVENT = item.events;

											//console.log("GLOBAL_BUSER_EVENT" + GLOBAL_BUSER_EVENT);
											//console.log("agentEventPopupID" + agentEventPopupID);

											buserAllFeed(item);

										} else {
											var event_name = "";
												if (item.event_name != " ") {
													event_name = item.event_name;
												} else {
													event_name = "Event - "+item.events;
												}
											thedata += "<li type='buevent' buadt_id='"+ item.alert_detail_id +"' buaccess_code='"+ item.user_code +"' buevent_id='"+ item.events +"'>"+event_name+"</li>";
										}
					//"<li type='buevent' buevent_id='"+ item.events +"'>Event-"+item.events+"</li>";

										});
										$('#bu_event').append(thedata);
										$("#loadMoreBuserEvent").attr("lastid",LastAlertDetailId);
										$('#loadMoreBuserEvent').html("<p>Add Events</p>");
										//$('#loadMoreBuserEvent').html("<p>&nbsp</p>");
									}
            } //if authentication
					}
        });
    });
	setTimeout(function(){
		$("#loadMoreBuserVideo").trigger('click');
		$("#loadMoreBuserEvent").trigger('click');
	},1000);
});

function popupAgentData(agentEventPopupID,eventRec,typeData) {
	var frameAgentVideoClassCounter = $('.aframe-video'+agentEventPopupID).length;

	if(frameAgentVideoClassCounter == 0) {
		var agentName = $('#buser').find(":selected").text();

		var event_name = "";
			if (eventRec.event_name != " ") {
				event_name = eventRec.event_name;
			} else {
				event_name = "Event - "+eventRec.events;
			}

		$("#agentPopupVideo").append("<div id='aframe-video' class='aframe-video"+agentEventPopupID+"' style='width:400px !important; height: 400px !important;'><div class='col-lg-12 header' align='right'><span class='btn btn-success btn-sm'>Agent: "+agentName+" <span style='color: #CC0000 !important'><strong>"+event_name+"</strong></span></span><span onclick='agentClose("+agentEventPopupID+")' id='avideoClose'"+agentEventPopupID+" class='btn btn-danger btn-sm'>X</span></div><div class='col-lg-12' style='z-index:9999 !important; width:100% !important; height: 82% !important;'><div class='amainVideo"+agentEventPopupID+"' id='amainVideo"+agentEventPopupID+"' class='col-lg-12' style='z-index: 99999; height: 100%; width: 100%;'></div></div><div class='col-lg-12 header'  align='right'><span onclick='agentClose("+agentEventPopupID+")' id='avideoClose"+agentEventPopupID+"' class='btn btn-danger btn-sm'>X</span></div></div>");
		$( ".aframe-video"+agentEventPopupID).draggable({ handle:'.header'}).resizable();
	}


	var frameAgentEventIntClassCounter = $('.bUserEventInt'+agentEventPopupID).length;


	if(frameAgentEventIntClassCounter == 0) {

		 if (typeData == true) {
			 var distanceType = "";
			 if (eventRec.distanceType) {
				  	distanceType = eventRec.distanceType;
			 } else {
				 	distanceType = "miles";
			 }

			 var event_name = "";
	 			if (eventRec.event_name != " ") {
	 				event_name = eventRec.event_name;
	 			} else {
	 				event_name = "Event - "+eventRec.events;
	 			}

				$("#agentEventIntelligence").append("<div id='bUserEventInt' class='bUserEventInt"+agentEventPopupID+"'><div class='col-lg-12 header' align='right'><span class='btn btn-success btn-sm'>Event Intelligence - Agent: "+eventRec.user_name+" <span style='color: #CC0000 !important'><strong>"+event_name+"</strong></span></span><span id='tuEvClose"+agentEventPopupID+"' onclick='agentEventClose("+agentEventPopupID+")' class='btn btn-danger btn-sm'>X</span></div><div class='col-lg-12'><div id='buEvContent"+agentEventPopupID+"'>&nbsp;&nbsp;Location:&nbsp;&nbsp;<span class='buser-location"+agentEventPopupID+"'>"+eventRec.location_now+"</span><hr>&nbsp;&nbsp;Event:&nbsp;&nbsp;<span class='buser-event"+agentEventPopupID+"'>"+eventRec.events+"</span><hr>&nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class='buser-tds"+agentEventPopupID+"'>"+eventRec.alert_datetime+"</span><hr>&nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class='buser-speed"+agentEventPopupID+"'>"+eventRec.alert_speed+" mph</span><hr>&nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class='buser-elevation"+agentEventPopupID+"'>"+eventRec.elevation+" ft</span><hr>&nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class='buser-direction"+agentEventPopupID+"'>"+eventRec.direction+"</span><hr>&nbsp;&nbsp;Distance:&nbsp;&nbsp;<span class='buser-distance"+agentEventPopupID+"'>"+eventRec.distance+" " +distanceType+"</span><hr>&nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class='buser-battery-level"+agentEventPopupID+"'>"+eventRec.alert_battery_level+"</span><hr>&nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class='buser-lat"+agentEventPopupID+"'>"+eventRec.lat+"</span><hr>&nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class='buser-lng"+agentEventPopupID+"'>"+eventRec.lng+"</span><hr></div></div></div>");


				$( ".bUserEventInt"+agentEventPopupID).draggable({ handle:'.header'}).resizable();
		 } else {
			  console.log(eventRec['location_now']);
		 }
	}


}


function agentPopUp(){
	accesscode = $("#buser").find(':selected').data('accesscode');
	console.log('accesscode bUser: '+accesscode);
	console.log('eventPopupID bUser: '+agentEventPopupID);
	//console.log("{{url('public/videos/')}}/"+accesscode+"-"+GLOBAL_BUSER_EVENT+".flv");

	//streamingArchiveAgentPopup("{{url('public/videos/')}}/"+accesscode+"-"+GLOBAL_BUSER_EVENT+".flv", accesscode,agentEventPopupID);

	streamingArchiveAgentPopup("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + accesscode + "-"+GLOBAL_BUSER_EVENT+".flv",accesscode,agentEventPopupID);

	$(".aframe-video"+agentEventPopupID).fadeIn();
	$("#officer_video").hide();
}


function streamingArchiveAgent(src){
	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',type:'video'};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
	var attributes={id:'officer_video'};
	swfobject.embedSWF('https://raptorsecuritysoftware.com/public/assets/player.swf','officer_video','100%','300','10.2',null,flashvars,params,attributes);

}


function streamingArchiveAgentPopup(src,accesscode,eventPopupID) {
	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',type:'video'};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
	var attributes={id:'amainVideo'+eventPopupID};
	swfobject.embedSWF('https://raptorsecuritysoftware.com/public/assets/player.swf','amainVideo'+eventPopupID,'100%','100%','10.2',null,flashvars,params,attributes);
}


function agentClose(eventData) {

	$(".aframe-video"+eventData).fadeOut();
	$("#officer_video").show();
}

function agentEventClose(eventData) {
	$(".bUserEventInt"+eventData).fadeOut();
}

// $(document).on("click","#officer_video",function(e){
// 	//$("#mainImage").hide();
// 	var src = $(this).attr("src");
//
// 	$(".amainVideo"+agentEventPopupID).attr("src", src);
// 	$(".amainVideo"+agentEventPopupID).attr("autoplay", true);
// 	$(".amainVideo"+agentEventPopupID).attr("style","width:100%");
// 	$(".aframe-video"+agentEventPopupID).fadeIn();
//
// 	//$("#text-overlay").fadeIn();
// 	/*$("#text-overlay").click(function(){
// 		$(this).fadeOut();
// 		$("#frame-video").fadeOut();
// 	});*/
//
// 	/*$("#frame-video").click(function(){
// 		$("#mainImage").show();
// 		$(this).fadeOut();
// 		//$("#text-overlay").fadeOut();
// 	});*/
// 	//$("#avideoClose").click(function(){
// 		//$("#amainImage").show();
// 		//$("#aframe-video").fadeOut();
// 		//$("#text-overlay").fadeOut();
// 	//});
//
// 	e.preventDefault();
// });
$( "#aframe-video" ).draggable().resizable();
$(document).on("click","#aZoomIn",function(e){

	$(".bUserEventInt"+agentEventPopupID).fadeIn();

	// $("#bUserEventInt").fadeIn();
	// //$("#text-overlay").fadeIn();
	// $( "#bUserEventInt" ).draggable();
	// $("#buEvClose").click(function(){
	// 	$("#mainImage").show();
	// 	$("#bUserEventInt").fadeOut();
	// 	//$("#text-overlay").fadeOut();
	// });
	// e.preventDefault();
});


function updateAgentEventIntelligence(data) {
	$(".buser-location").html(data["location_now"]);
	$(".buser-tds").html(data["tds"]);
	//$(".buser-speed").html(data.alert_speed);
	//$(".buser-elevation").html(data.elevation+"ft");
	$(".buser-direction").html(data["direction"]);
	//$(".buser-level").html(data.level);
	$(".buser-battery-level").html(data["battery_level"]);
	$(".buser-event").html(data["event_id"]);
	//$(".buser-ip").html(data.ip_address);
	$(".buser-lat").html(data["lat"]);
	$(".buser-lng").html(data["lon"]);
	//$("#location_now").html("Address: <span>"+data.location_now+"</span>, TDS: <span>"+data.alert_datetime+"</span>, Speed: <span>"+data.alert_speed+"</span>, Elevation: <span>"+data.elevation+"ft</span>, Direction: <span>"+data.direction+"</span>");

}


function multipleLocation(accesscode,events,type) {
  var lineCoordinates = [];

	//var locationRef = firebase.database().ref('multiple_location/'+accesscode);
	$.ajax({
            cache: false,
            type:'POST',
            url:'{{url('api/v1/multiple-location')}}',
						headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
            data:"eventID="+events+"&accesscode="+accesscode,
            success:function(response){
							if(response.message == "Invalid Token Authentication.") {
									console.log("Invalid Token Authentication.");
							}	 else {

				            	if (response == 'NoVideoFound') {

				            	} else {


				            		var locationRef = firebase.database().ref('multiple_location/'+accesscode+'/'+response);
				            		locationRef.once('value', function(snapshot){
				            			if (snapshot.val() != null){
				            				snapshot.forEach(function(childSnapshot) {
												var snapDict = childSnapshot.val();
												var lat = snapDict['lat'];
												var lon = snapDict['lon'];

												//marker goes here
												var latLang124 = new google.maps.LatLng(lat, lon);
												lineCoordinates.push(latLang124);

												var marker3 = new google.maps.Marker({
													position: latLang124,
													map: officer_map,
													icon: uns_2
												 });

												marker3.addListener('click', function() {
										            updateAgentEventIntelligence(snapDict);
										        });




											});
				            			}


				            		});

				           //  		var linePath = new google.maps.Polyline({
							        //   path: lineCoordinates,
							        //   geodesic: true,
							        //   strokeColor: '#FF0000',
							        //   strokeOpacity: 1.0,
							        //   strokeWeight: 2
							        // });

							        // linePath.setMap(mapvalue);

				            	}

							} // if authentication

            }
        });
}



//list to firebase video if there is incoming changes by access code the page

checkNewAgentEvent();
function checkNewAgentEvent() {
	console.log("Agent Load New Events");

		var agentVideoRef = firebase.database().ref('video/'+GLOBAL_BUSER_ACCESSCODE);
		//console.log("Access Code" + GLOBAL_BUSER_ACCESSCODE);
		var refresh = false;
		agentVideoRef.on('value', function(snapshot){

			if(GLOBAL_AGENT_REFRESH == true) {
					 GLOBAL_AGENT_REFRESH = false;
			} else {


					snapshot.forEach(function(childSnapshot) {
						var snapDict = childSnapshot.val();
						var key = childSnapshot.key;

							if(snapDict["refresh_status"] == "true") {
								 agentVideoRef.child(key).update({ refresh_status : "false" });

								 if(refresh==false) {
										$('#bu_event').empty();
										displayAllAgentEvents(GLOBAL_BUSER_ID);
										refresh = true;
								 }
							}
					});
			}

				// var refresh = false;
				// //console.log("snapshot.count" + snapshot.numChildren());
				// var feedcounter = 0;
				// snapshot.forEach(function(childSnapshot) {
				// 	var snapDict = childSnapshot.val();
				// 	var key = childSnapshot.key;
				//
				// 	// console.log("feedcounter " + feedcounter)
				// 	//console.log("refresh_status" + snapDict["refresh_status"]);
				// 	if(snapDict["refresh_status"] == "true") {
				// 			//console.log("Auto Refresh the event");
				// 		 	agentVideoRef.child(key).update({ refresh_status : "false" });
				// 			refresh = true;
				//
				// 	}
				// 	feedcounter = feedcounter + 1;
				// });
				//
				//
				// if(refresh == true) {
				//
				// 	if(feedcounter == snapshot.numChildren()) {
				//
				// 			$("#bu_event").empty();
				// 			if(GLOBAL_AGENT_REFRESH == false) {
				// 					displayAllAgentEvents(GLOBAL_BUSER_ID);
				// 			} else {
				// 					GLOBAL_AGENT_REFRESH = false;
				// 			}
				// 			refresh = false;
				// 		}
				// }



		});
}


function deleteEventAgent() {
	var c = confirm("Are you sure you want to completely remove this Event from this user?\n\nPress 'OK' to delete.\nPress 'Cancel' to go back without deleting the Event.");
 if(c==true) {
		var accesscode = $("#deleteSelectedEvent").data("accesscode");
		var events = $("#deleteSelectedEvent").data("events");

					 $.ajax({
						 type: "GET",
						 url:  "https://raptorsecuritysoftware.com/dashboard/delete-selected-event/"+accesscode+"/"+events,
						 headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
						 cache: false,
						 success: function(){
							 $("#bu_event").empty();
							 displayAllAgentEvents(GLOBAL_BUSER_ID);
						 }
					 });

 }
}


//autoselect users

//agentSelectedEvents
if(agentSelectedEvents != "") {
	$('#buser option').removeAttr('selected').filter('[value=' + agentSelectedEvents + ']').attr('selected', true);
	GLOBAL_BUSER_ID = agentSelectedEvents;
	displayAllAgentEvents(GLOBAL_BUSER_ID);

}



</script>
