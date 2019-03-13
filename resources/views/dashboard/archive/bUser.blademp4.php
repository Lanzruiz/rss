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
var agentEventPopupID = 0;

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

            <div class="col-lg-3 select">
                <select class="form-control" id="buser" name="buser"><script>jf_busers();</script></select>
            </div>
            <div style="clear: both;"></div>
        </ul>
        <div class="col-lg-3 responsiveVersion-3">
        	<ul class="col-lg-12 tu-event" id="bu_event" ><script>//jf_bu_events();</script></ul>
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
                <div class="col-lg-12 video-player" >
                	<!--<span id="officer_video_feed"></span>-->
                    <video id="officer_video" controls></video>
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
        <?php /*&nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="buser-speed"></span><hr>
        &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="buser-elevation"></span><hr>*/ ?>
        &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="buser-direction"></span><hr>
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
<script>
$(document).on("change","#buser", function(e){
	buserChange = true;
	$("#officer_video").attr("src",'');
	//$("#bu_event").html("<p class='loading'>Loading....</p>");
	$("#officer_playback-button").removeClass("fa-pause").addClass("fa-play");
	GLOBAL_BUSER_ID = $(this).val();
	GLOBAL_BUSER_NAME = $("#buser option:selected").text();
	GLOBAL_BUSER_EVENT = $("#buser option:selected").attr("buser_sel_event");
	//$("#busermap").html(null);
	//$("#buserDataFrequency").hide();
	//$("#buserDataFrequencyMsg").show();
	//$("#busermap").hide();
	$("#bu_event").empty();
	//$("#officer_video_feed").empty();

	//$("#busermapmsg").show();
	$(".eventID").html(GLOBAL_BUSER_EVENT);
	$(".selectedbuserid").html(GLOBAL_BUSER_NAME);

	displayAllAgentEvents($(this).val());

	e.preventDefault();
});

function displayAllAgentEvents(userID) {
	$.ajax({
	type: "POST",
	url:'{{url('api/v1/display_events_user')}}',
	//url: "eventVideo.php",
	data:"user_id="+userID,
	success: function(response){

			if(response == 'NoMoreEvent'){
				$('#bu_event').html("<p>No events found</p>");
			}else{
					var fixturesData=JSON.parse(response);
					var thedata='';
					var LastAlertDetailId = '';
					var userAgentID = '';
					var eventAgentID = '';
					actr = 0;

					$.each(fixturesData,function(key,item){
						actr = actr + 1;
						LastAlertDetailId = item.alert_detail_id;
						//"<li type='buevent' buevent_id='"+ item.events +"'>Event-"+item.events+"</li>";

						userAgentID = item.user_id;

						if(actr == 1) {
							eventAgentID = item.events;

							thedata += "<li class='activeClass' type='buevent' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+"Event - "+item.events+"</li>";

								//play the video
								if(item.filePath != "") {
									<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + item.user_code + "/" + item.events + "/" + item.filePath);*/ ?>

									$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
									$("#officer_video").attr("autoplay",true);
									agentEventPopupID = item.alert_detail_id + item.events;
									popupAgentData(agentEventPopupID);
									//buserAllFeed(buvideo_id);
									Officer_Select_Media(item);


								}

								multipleLocation(item.user_code,item.events,"agent");



								buserAllFeed(item);


						} else {
							thedata += "<li type='buevent' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+"Event - "+item.events+"</li>";
						}
					});
					$('#bu_event').append(thedata);
					$("#loadMoreBuserEvent").attr("lastid",LastAlertDetailId);
					$('#loadMoreBuserEvent').html("<p>Add Events</p>");

					//displayAllAgentVideo(userAgentID,eventAgentID);
			}
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
	$("#officer_video").attr("src",'');
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
		data: "status=getVideo&user_id="+GLOBAL_BUSER_ID+"&bEvent="+GLOBAL_BUSER_EVENT,
		success: function(response) {

			var data=JSON.parse(response);

			if(data.filePath != "") {
				<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + data.user_code + "/" + data.events + "/" + data.filePath);*/ ?>

				$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.filePath);
				agentEventPopupID = data.alert_detail_id + data.events;
				popupAgentData(agentEventPopupID);

				//$("#officer_video").attr("controls",true);
				$("#officer_video").attr("autoplay",true);
				//buserAllFeed(buvideo_id);
				multipleLocation(data.user_code,data.events,"agent");


				//Officer_Select_Media(data);




			} else if(data.lat != "") {


			}


			buserAllFeed(data);
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
	$(jv_bu_video).each(function(){
		if(buvideo_id == this.alert_detail_id){// && this.video != null){

			//$("#officer_video").attr("src", "");
			//$("#officer_video").attr("src", this.filePath);//media_path+this.user_id+"/video/"+this.video);
			if(this.filePath != "") {
				<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + this.user_code + "/" + this.events + "/" + this.filePath); */ ?>
				$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.filePath);
				agentEventPopupID = this.alert_detail_id + this.events;
				popupAgentData(agentEventPopupID);

				//$("#officer_video").attr("controls",true);
				$("#officer_video").attr("autoplay",true);
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
	//$(".buser-speed").html(data.alert_speed);
	//$(".buser-elevation").html(data.elevation+"ft");
	$(".buser-direction").html(data.direction);
	$(".buser-level").html(data.level);
	$(".buser-battery-level").html(data.alert_battery_level);
	$(".buser-event").html(data.events);
	$(".buser-ip").html(data.ip_address);
	$(".buser-lat").html(data.lat);
	$(".buser-lng").html(data.lng);
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
	var officer_myCenter=new google.maps.LatLng(GLOBAL_BUSER_LAT,GLOBAL_BUSER_LNG);
	var officer_mapProp = {
	  center:officer_myCenter,
	  zoom:18,
	 // mapTypeId:google.maps.MapTypeId.SATELLITE,//SATELLITE,
	  fullscreenControl: true
	  };
	officer_map=new google.maps.Map(document.getElementById("busermap"),officer_mapProp);
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
						officer_selectedMarker.setMap(null);
						//set as selected officer_marker
						var latLang124 = new google.maps.LatLng(this.lat, this.lng);
						var marker3 = new google.maps.Marker({
							position:latLang124,
							map: officer_map,
							title: this.location_now,
							icon: '{{url('public/assets/images/agent-o.png')}}'//selectedMarkerIcon
						  });
						officer_selectedMarker = marker3;
						if(this.fileType == 'audio'){
							$('a[href="#bu_audio"]').tab("show");
							$("#officer_audio").show();
							$("#OfficerPlayPauseButton").show();
							//$("#officer_video").hide();
							//$("#officer_audio_feed").html("");
							//$("#officer_video_feed").html("<p>selected point's media is audio, please hear audio on audio tab</p>");
							if(this.alert_detail_id == jv_bu_allfeed[w]["alert_detail_id"]){
								$("#officer_audio").attr("src", "");
								$("#officer_audio").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/audio/'+jv_bu_allfeed[w]["audio"]);
								//$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_allfeed[w]["user_code"] + "/" + jv_bu_allfeed[w]["events"] + "/" + jv_bu_allfeed[w]["filePath"]);

								$("#officer_audio").trigger("play");
								$("#officer_audio").on("ended", function(){
									//alert("Hello");
									$("#officer_audio").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/audio/'+jv_bu_allfeed[w]["audio"]);
									//$("#officer_audio").trigger("pause");
								});
								//$("#officer_video").attr("src", "");
								return false;
							}
						}else if(this.fileType == 'video'){
							$("#officer_video").show();
							//$("#OfficerPlayPauseButton").hide();
							//$("#officer_video_feed").html("");
							//$("#officer_audio_feed").html("<p>selected point's media is video, please see video on video tab</p>");
							$('a[href="#bu_video"]').tab("show");
							if(this.alert_detail_id = jv_bu_allfeed[w]["alert_detail_id"]){
								//$("#officer_video").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/video/'+jv_bu_allfeed[w]["video"]);

								//$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_allfeed[w]["user_code"] + "/" + jv_bu_allfeed[w]["events"] + "/" + jv_bu_allfeed[w]["filePath"]);

								$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_allfeed[w]["filePath"]);
								agentEventPopupID = jv_bu_allfeed[w]["alert_detail_id"] + jv_bu_allfeed[w]["events"];
								popupAgentData(agentEventPopupID);
								$("#officer_video").trigger("play");
								$("#officer_video").on("ended", function(){
									//alert("Hello");
									//$("#officer_video").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/video/'+jv_bu_allfeed[w]["video"]);
									<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_allfeed[w]["user_code"] + "/" + jv_bu_allfeed[w]["events"] + "/" + jv_bu_allfeed[w]["filePath"]);*/ ?>
									$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_allfeed[w]["filePath"]);
									//$("#audio").trigger("pause");
								});
								//$("#officer_audio").attr("src", "");
								return false;
							}
						}else if(this.fileType == 'image'){
							$('a[href="#buserPhoto"]').tab("show");
							//$("#officer_audio").attr("src", "");
							//$("#officer_video").attr("src", "");
							//$("#OfficerPlayPauseButton").hide();
							//$("#officer_video").hide();
							//$("#officer_audio_feed").html("<p>selected media is image, please see image on photo tab</p>");
							//$("#officer_video_feed").html("<p>selected media is image, please see image on photo tab</p>");
							$("#mainImage").attr("src", jv_bu_allfeed[w]["filePath"]);//media_path+jv_bu_allfeed[w]["user_id"]+'/image/'+jv_bu_allfeed[w]["image"]);
							$("#frame").fadeIn();
							/*$("#overlay").fadeIn();
							$("#overlay").click(function(){
								$(this).fadeOut();
								$("#frame").fadeOut();
							});*/
							$("#frame").click(function(){
								$(this).fadeOut();
								//$("#overlay").fadeOut();
							});
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
	officer_selectedMarker.setMap(null);
	var latLang = new google.maps.LatLng(media_data.lat, media_data.lng);
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
	$("#officer_video").on("ended", function(){
		//alert("Hello");
		var next_play_indexOfficerVideo = current_play_indexOfficerVideo + 1;
		if(next_play_indexOfficerVideo >= jv_bu_video.length)
			return;
		$("#officer_video").attr("src", jv_bu_video[next_play_indexOfficerVideo].filePath);//media_path+GLOBAL_BUSER_ID+'/video/'+jv_bu_video[next_play_indexOfficerVideo].video);
		$("#officer_video").trigger("play");
		current_play_indexOfficerVideo = next_play_indexOfficerVideo;
		/*if(jv_bu_video[next_play_indexOfficerVideo].events != GLOBAL_BUSER_EVENT){
			$("#video").attr("src","");
		}*/
	});
	if(jv_bu_video == null || jv_bu_video == ''){
		$("#officer_video").hide();
		//$("#officer_video_feed").html("<p>No video found</p>");

	}else{

		$("#officer_video").show();
		<?php /*$("#officer_video").attr("src", "{{url('public/uploads/video')}}/" + jv_bu_video[0]["user_code"] + "/" + jv_bu_video[0]["events"] + "/" + jv_bu_video[0]["filePath"]); */ ?>
		$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_bu_video[0]["filePath"]);
		agentEventPopupID = jv_bu_video[0]["alert_detail_id"] + jv_bu_video[0]["events"];
		popupAgentData(agentEventPopupID);


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
            data:"status=video&user_id="+GLOBAL_BUSER_ID+"&last_id="+ID+"&bEvent="+GLOBAL_BUSER_EVENT,
            success:function(response){
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
            data:"status=events&user_id="+GLOBAL_BUSER_ID+"&last_id="+ID,
            success:function(response){
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

						thedata += "<li class='activeClass' type='buevent' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+"Event - "+item.events+"</li>";


						$("#officer_video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
						agentEventPopupID = item.alert_detail_id + item.events;
						popupAgentData(agentEventPopupID);

						//$("#officer_video").attr("controls",true);
						//$("#officer_video").attr("autoplay",true);
						multipleLocation(item.user_code,item.events,"agent");

						buserAllFeed(item);

					} else {

						thedata += "<li type='buevent' buadt_id='"+ item.alert_detail_id +"' buevent_id='"+ item.events +"'>"+"Event - "+item.events+"</li>";
					}
//"<li type='buevent' buevent_id='"+ item.events +"'>Event-"+item.events+"</li>";

					});
					$('#bu_event').append(thedata);
					$("#loadMoreBuserEvent").attr("lastid",LastAlertDetailId);
					$('#loadMoreBuserEvent').html("<p>Add Events</p>");
					//$('#loadMoreBuserEvent').html("<p>&nbsp</p>");
				}
            }
        });
    });
	setTimeout(function(){
		$("#loadMoreBuserVideo").trigger('click');
		$("#loadMoreBuserEvent").trigger('click');
	},1000);
});

function popupAgentData(agentEventPopupID) {
	var frameAgentVideoClassCounter = $('.aframe-video'+agentEventPopupID).length;
	if(frameAgentVideoClassCounter == 0) {
		var agentName = $('#buser').find(":selected").text();
		$("#agentPopupVideo").append("<div id='aframe-video' class='aframe-video"+agentEventPopupID+"'><div class='col-lg-12' align='right'><span class='btn btn-success btn-sm'>Agent - "+agentName+"</span><span onclick='agentClose("+agentEventPopupID+")' id='avideoClose'"+agentEventPopupID+" class='btn btn-danger btn-sm'>X</span></div><div class='col-lg-12'><video src='' id='amainVideo' class='amainVideo"+agentEventPopupID+"'  controls></video></div></div>");
		$( ".aframe-video"+agentEventPopupID ).draggable().resizable();
	}
}

function agentClose(eventData) {

	$(".aframe-video"+eventData).fadeOut();
}

$(document).on("click","#officer_video",function(e){
	//$("#mainImage").hide();
	var src = $(this).attr("src");

	$(".amainVideo"+agentEventPopupID).attr("src", src);
	$(".amainVideo"+agentEventPopupID).attr("autoplay", true);
	$(".amainVideo"+agentEventPopupID).attr("style","width:100%");
	$(".aframe-video"+agentEventPopupID).fadeIn();

	//$("#text-overlay").fadeIn();
	/*$("#text-overlay").click(function(){
		$(this).fadeOut();
		$("#frame-video").fadeOut();
	});*/

	/*$("#frame-video").click(function(){
		$("#mainImage").show();
		$(this).fadeOut();
		//$("#text-overlay").fadeOut();
	});*/
	//$("#avideoClose").click(function(){
		//$("#amainImage").show();
		//$("#aframe-video").fadeOut();
		//$("#text-overlay").fadeOut();
	//});

	e.preventDefault();
});
$( "#aframe-video" ).draggable().resizable();
$(document).on("click","#aZoomIn",function(e){
	$("#bUserEventInt").fadeIn();
	//$("#text-overlay").fadeIn();
	$( "#bUserEventInt" ).draggable();
	$("#buEvClose").click(function(){
		$("#mainImage").show();
		$("#bUserEventInt").fadeOut();
		//$("#text-overlay").fadeOut();
	});
	e.preventDefault();
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
            data:"eventID="+events+"&accesscode="+accesscode,
            success:function(response){
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



            }
        });
}
</script>
