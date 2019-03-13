<?php
$GLOBAL_TUSER_ID = $checkClientData->user_id;
//echo $GLOBAL_TUSER_ID;
$GLOBAL_TUSER_EVENT = $checkClientData->events;
if($GLOBAL_TUSER_EVENT == '' || $GLOBAL_TUSER_EVENT == NULL || $GLOBAL_TUSER_EVENT == 0){
	$GLOBAL_TUSER_EVENT = 1;
}
//include 'pages/functions.php';
?>
<script>
var tuserChange = false;
var tuserEventChange = false;
var video = null;
var jv_tusers = <?php echo json_encode($usersAlert);?>;
var jv_tu_event = <?php echo json_encode($events);?>;
var jv_tu_video = <?php echo json_encode($videos);?>;
var mapLoad = true;
var intMapLoad = true;
var jv_tu_allfeed = <?php echo json_encode($displayAllFeeds);?>;
var GLOBAL_TUSER_LAT = jv_tu_allfeed[0]['lat'];
var GLOBAL_TUSER_LNG = jv_tu_allfeed[0]['lng'];
var GLOBAL_TUSER_ID = jv_tusers[0]['user_id'];
var GLOBAL_TUSER_EVENT = jv_tu_event[0]['events'];
var GLOBAL_TUSER_NAME = jv_tusers[0]['user_name'];
var GLOBAL_TUSERACCESSCODE = jv_tusers[0]['user_code'];
var GLOBAL_REFRESH = false;
var eventPopupID = 0;
var transSelectedEvents = '<?php echo $selectTrans; ?>';

</script>
<script src="{{url('public/assets/swfobject.min.js')}}"></script>
<script src="{{url('public/assets/archive/functions.js')}}"></script>

<?php /*<script src="pages/functions.js"></script> */ ?>
<!--<script src="pages/tuserfeedsync.js"></script>-->
<?php
//include 'include/syncTrAllFeed_AlertStatus.php';
?>
@include('dashboard.archive.syncTrAllFeed_AlertStatus')
<script>





$(document).on("change","#tuser", function(e){
	//$("#tusermap").html("<p class='loading' style='color:#000'>Please Wait....</p>");
	//$("#map_integ_threat").html("<p class='loading' style='color:#000'>Please Wait....</p>");
	tuserChange = true;
	GLOBAL_REFRESH = true;
	//$("#video").attr("src",'');


	//transportEventID = $(this).find(':selected').data('event');


	//$("#tu_event").html("<p class='loading'>Loading....</p>");
	//$("#video_feed").html("<p class='loading'>Loading....</p>");

	$("#tu_event").empty();
	$("#video_feed").empty();
	//$("#transportEventIntelligence").empty();
	//$("#trasportvideo").empty();

	GLOBAL_TUSER_ID = $(this).val();
	GLOBAL_TUSER_EVENT = $("#tuser option:selected").attr("tuser_sel_event");
	GLOBAL_TUSER_NAME = $("#tuser option:selected").text();
	GLOBAL_TUSERACCESSCODE = $("#tuser option:selected").data("accesscode");



	// $("#loadMoreTuserVideo").trigger('click');
	// $("#loadMoreTuserEvent").trigger('click');

	displayAllEvents(GLOBAL_TUSER_ID);
	checkNewTransportEvent();


               initialize();
               intLiveMap();

	e.preventDefault();
});

function displayAllEvents(userID) {
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
						$('#tu_event').html("<p>No events found</p>");
						  @if($alertInOff <= 0)
									location.href="https://raptorsecuritysoftware.com/dashboard/archived";
							@endif
							if($('#tu_event').html() == "<p>No events found</p>") {
								  location.href="https://raptorsecuritysoftware.com/dashboard/archived";
							}
					}else{
							var fixturesData=JSON.parse(response);
							var thedata='';
							var LastAlertDetailId = '';
							var userID = '';
							var eventID = '';
							ectr = 0;
							$('#tu_event').empty();
							//console.log("Event list cleared");
							$.each(fixturesData,function(key,item){
								//LastAlertDetailId = item.alert_detail_id;
								ectr=ectr+1;
								LastAlertDetailId = item.alert_detail_id;

								userID = item.user_id;
								if(ectr == 1) {
									eventID = item.events;

									var event_name = "";
									if (item.event_name != " ") {
										event_name = item.event_name;
									} else {
										event_name = "Event - " + item.events;
									}

									thedata += "<li class='activeClass' tuuser_code='"+item.user_code+"' type='uevent' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+event_name+"</li>";


									$(".eventTrans").val(event_name);
									$(".eventTransID").val(item.alert_detail_id);



									//thedata += "<li class='activeClass' tuuser_code='"+item.user_code+"' type='uevent' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+"Event - "+item.events+"&nbsp;&nbsp;<a href='javascript:void(0)' onClick='updateEvent("+item.alert_detail_id+")'><i class='glyphicon glyphicon-edit'></i></a></li>";
									//$("#deleteSelectedEventTransport").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+item.user_code+'/'+item.events);
									$("#deleteSelectedEventTransport").data('accesscode',item.user_code);
									$("#deleteSelectedEventTransport").data('events',item.events);
									GLOBAL_TUSERACCESSCODE = item.user_code;

									//play the video
									<?php /*$("#video").attr("src", "{{url('public/uploads/video')}}/" + item.user_code + "/" + item.events + "/" + item.filePath);*/ ?>
									streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.user_code + "-"+item.events+".flv");

									//$("#video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
									eventPopupID = item.alert_detail_id + item.events;
									popupData(eventPopupID,item);

									//$("#officer_video").attr("controls",true);
									//$("#video").attr("autoplay",true);
									//buserAllFeed(buvideo_id);
									tranportMultipleLocation(item.user_code,item.events,"transport");
									selectMedia(item);
									GLOBAL_TUSER_EVENT = item.events;

									tuserAllFeed(item);

                                   //$("#tu_event li").first().click();
//                                   $("li[type='uevent']").click(function(){
//                                    });

								} else {

									var event_name = "";
									if (item.event_name != " ") {
										event_name = item.event_name;
									} else {
										event_name = "Event - " + item.events;
									}

									thedata += "<li type='uevent' tuuser_code='"+item.user_code+"' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+event_name+"</li>";



								}


							});
							$('#tu_event').append(thedata);
							$("#loadMoreTuserEvent").attr("lastid",LastAlertDetailId);
                            $("#tu_event li").first().click();
							//displayAllVideo(userID,eventID);
					}
			} //if authentication
		}
	});
}

// function displayAllVideo(userID,eventID) {

// 	$.ajax({
// 	type: "POST",
// 	url:'{{url('api/v1/display_events_user_video')}}',
// 	data:"user_id="+userID+"&event_id="+eventID,
// 	success: function(response){


// 			if(response == 'NoVideoFound'){
// 				$('#video_feed').html("<p>No video found</p>");
// 			}else{
// 				var fixturesData=JSON.parse(response);
// 				jv_tu_video = fixturesData;
// 				var thedata='';
// 				var LastAlertDetailId = '';
// 				$.each(jv_tu_video,function(){
// 					LastAlertDetailId = this.alert_detail_id;
// 					thedata += "<li type='tuvideo' tuvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";
//
// 				});
// 				$('#video_feed').html(thedata);
// 				$("#loadMoreTuserVideo").attr("lastid",LastAlertDetailId);
// 			}
// 		}

// 	});
// }




//TRANSPORT section
$(document).on("click","li[type='uevent']", function(e){
               console.log("Event was click");
	jv_tu_video = '';
	tuserEventChange = true;
	var ActiveItem = $(this);
	$("li[type='uevent']").removeClass("activeClass");
	ActiveItem.addClass("activeClass");
	//$("#video").attr("src",'');
	$("#video_feed").html("<p class='loading'>Loading....</p>");
	//$("#tusermap").html(null);
	GLOBAL_TUSER_ID = GLOBAL_TUSER_ID;
	GLOBAL_TUSER_EVENT = $(this).attr("tuevent_id");

	var tusercode = $(this).attr("tuuser_code");
	GLOBAL_TUSERACCESSCODE = tusercode;
	//$("#deleteSelectedEventTransport").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+tusercode+'/'+GLOBAL_TUSER_EVENT);
	$("#deleteSelectedEventTransport").data('accesscode',tusercode);
	$("#deleteSelectedEventTransport").data('events',GLOBAL_TUSER_EVENT);
	//event video after click on event


	$.ajax({
		type: "POST",
		url: '{{url('api/v1/tRecords')}}',
		headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
		data: "status=getVideo&user_id="+GLOBAL_TUSER_ID+"&tEvent="+GLOBAL_TUSER_EVENT,
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

						$(".eventTrans").val(event_name);
						$(".eventTransID").val(data.alert_detail_id);
						//console.log(data);
						<?php /*$("#video").attr("src", "{{url('public/uploads/video')}}/" + data.user_code + "/" + data.events + "/" + data.filePath);*/ ?>
						// $("#video").attr("data-event",data.alert_detail_id);
						// $("#video").attr("data-eventid",data.events);
						//streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.filePath);
						streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.user_code + "-"+data.events+".flv");
						//$("#video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + data.filePath);
						//$("#officer_video").attr("controls",true);
						//$("#video").attr("autoplay",true);
						eventPopupID = data.alert_detail_id + data.events;
						popupData(eventPopupID,data);
						//buserAllFeed(buvideo_id);
						tranportMultipleLocation(data.user_code,data.events,"transport");
						selectMedia(data);


						tuserAllFeed(data);



			} //if authentication
		}
	});



	// $.ajax({
	// type: "POST",
	// url:'{{url('api/v1/tRecords')}}',
	// //url: "eventVideo.php",
	// data:"status=eventVideo&user_id="+GLOBAL_TUSER_ID+"&tEvent="+GLOBAL_TUSER_EVENT,
	// success: function(response){
	// 		/*setTimeout(function(){
	// 			$("#video_feed").html(response);
	// 		},500);*/
	// 		if(response == 'NoVideoFound'){
	// 			$('#video_feed').html("<p>No video found</p>");
	// 		}else{
	// 			var fixturesData=JSON.parse(response);
	// 			jv_tu_video = fixturesData;
	// 			var thedata='';
	// 			var LastAlertDetailId = '';
	// 			$.each(jv_tu_video,function(){
	// 				LastAlertDetailId = this.alert_detail_id;
	// 				thedata += "<li type='tuvideo' tuvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";

	// 			});
	// 			$('#video_feed').html(thedata);
	// 			$("#loadMoreTuserVideo").attr("lastid",LastAlertDetailId);
	// 		}
	// 	}
	// });
	e.preventDefault();
});


function displayConfirmationMessage(alert_id) {
		 console.log("hello world");
}

$(document).on("click","li[type='tuvideo']", function(e){
	//selected Item highlight section
	var ActiveItem = $(this);
	$("li[type='tuvideo']").removeClass("activeClass");
	ActiveItem.addClass("activeClass");

	var tuvideo_id = $(this).attr("tuvideo_id");
	$(jv_tu_video).each(function(){
		if(tuvideo_id == this.alert_detail_id){

			//$("#video").attr("src", "");

			//$("#video").attr("src", this.filePath);//media_path+this.user_id+"/video/"+this.video);

			<?php /*$("#video").attr("src", "{{url('public/uploads/video')}}/" + this.user_code + "/" + this.events + "/" + this.filePath);*/ ?>
			//streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.filePath);
				streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.user_code + "-"+this.events+".flv");
			//$("#video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + this.filePath);

			eventPopupID = this.alert_detail_id + this.events;
			popupData(eventPopupID,this);

			//$("#video").attr("autoplay",true);
			selectMedia(this);


			tuserAllFeed(this);
		}
	});

	e.preventDefault();
});
function tuserAllFeed(data){


			$(".tuser-location").html(data.location_now);
			$(".tuser-tds").html(data.alert_datetime);
			$(".tuser-speed").html(data.alert_speed+" mph");
			$(".tuser-elevation").html(data.elevation+" ft");
			$(".tuser-direction").html(data.direction);
			$(".tuser-level").html(data.level);
			$(".tuser-battery-level").html(data.alert_battery_level);
			$(".tuser-event").html(data.events);
			$(".tuser-ip").html(data.ip_address);
			$(".tuser-lat").html(data.lat);
			$(".tuser-lng").html(data.lng);
			$("#location_now").html("Address: <span>"+data.location_now+"</span>TDS: <span>"+data.alert_datetime+"</span>Speed: <span>"+data.alert_speed+"</span>Elevation: <span>"+data.elevation+"ft</span>Direction: <span>"+data.direction+"</span>");

}

var map, marker, flightPlanCoordinates, flightPath;
var selectedMarker = null;
//var infoWindow = new google.maps.InfoWindow();
function initialize(){
	if(GLOBAL_TUSER_LAT == 0 && GLOBAL_TUSER_LNG == 0) {
		   var myCenter = new google.maps.LatLng(38.907192, -77.036871);
	} else {
			var myCenter=new google.maps.LatLng(GLOBAL_TUSER_LAT,GLOBAL_TUSER_LNG);
	}
	var mapProp = {
	  center:myCenter,
	  zoom:18,
		mapTypeId: 'hybrid',
	  //mapTypeId: google.maps.MapTypeId.SATELLITE,//SATELLITE,//HYBRID//TERRAIN//ROADMAP
	  fullscreenControl: true
	  };
	map=new google.maps.Map(document.getElementById("tusermap"),mapProp);
	map.setTilt(45);

	if(GLOBAL_TUSER_LAT != 0 && GLOBAL_TUSER_LNG != 0) {
		marker=new google.maps.Marker({
	  		position:myCenter,
				optimized: false,
				icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
	  	});
			marker.setMap(map);
			selectedMarker = marker;
			google.maps.event.addListener(marker, 'click', function() {
	  });
	}
	var tmusumarker, w;
	for (w = 0; w < jv_tu_allfeed.length; w++) {
		tmusumarker = new google.maps.Marker({
			position: new google.maps.LatLng(jv_tu_allfeed[w]["lat"], jv_tu_allfeed[w]["lng"]),
			icon: unSelectedMarkerIcon,
			map: map
		});
		google.maps.event.addListener(tmusumarker, 'click', (function(tmusumarker, w) {
		return function() {
		var alert_detail_id = jv_tu_allfeed[w]["alert_detail_id"];
		var location_now = jv_tu_allfeed[w]["location_now"];
		var alert_datetime = jv_tu_allfeed[w]["alert_datetime"];
		//infoWindow.setContent("<strong>Address:</strong> "+jv_tu_allfeed[w]['location_now']);
		//infoWindow.open(map, tmusumarker);
				$(jv_tu_allfeed).each(function(){
					if(this.alert_detail_id == alert_detail_id){

						//tuserAllFeed(alert_detail_id);
						//remove all selected marker
						selectedMarker.setMap(null);
						//set as selected marker
						var latLang123 = new google.maps.LatLng(this.lat, this.lng);
						var marker2 = new google.maps.Marker({
							position:latLang123,
							map: map,
		optimized: false,
		icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
						  });
						selectedMarker = marker2;
						//if(this.audio != null || (this.audio != null && this.image != null)){
						if(this.fileType == 'video'){
							$("#video").show();
							$('a[href="#tu_video"]').tab("show");
							if(this.alert_detail_id = jv_tu_allfeed[w]["alert_detail_id"]){


								streamingArchiveTransport(jv_tu_allfeed[w]["filePath"]);
								//$("#video").attr("src", jv_tu_allfeed[w]["filePath"]);
								//$("#video").trigger("play");
								//$("#video").on("ended", function(){
									//alert("Hello");
									//$("#video").attr("src", jv_tu_allfeed[w]["filePath"]);
									//$("#audio").trigger("pause");
								//});
								//$("#audio").attr("src", "");
								return false;
							}
						}
					}
				});
			}
		})(tmusumarker, w));
	}


	//polyline
	flightPlanCoordinates = jv_tu_allfeed;
	flightPath = new google.maps.Polyline({
		path: flightPlanCoordinates,
		geodesic: true,
		strokeColor: '#FF0000',
		strokeOpacity: 1.0,
		strokeWeight: 2
	});
	flightPath.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initialize);

//TRANSPORT section
function addMarkerToTuserMap(map, new_points){
	var tmusumarker, w;
	for (w = 0; w < new_points.length; w++) {
		tmusumarker = new google.maps.Marker({
			position: new google.maps.LatLng(new_points[w]["lat"], new_points[w]["lng"]),
			icon: unSelectedMarkerIcon,
			map: map
		});
		google.maps.event.addListener(tmusumarker, 'click', (function(tmusumarker, w) {
			return function() {
				//infoWindow.setContent("<strong>Address:</strong> "+new_points[w]['location_now']);
				//infoWindow.open(map, tmusumarker);
			}
		})(tmusumarker, w));
	}
}

//TRANSPORT section
function selectMedia(media_data){
	//tuserAllFeed(media_data.alert_detail_id);
	if (selectedMarker != null) {
	   selectedMarker.setMap(null);
  }

//console.log(media_data);
if(media_data.lat == 0 && media_data.lng == 0) {
		 var latLang = new google.maps.LatLng(38.907192, -77.036871);
} else {
		var latLang = new google.maps.LatLng(media_data.lat, media_data.lng);

		var marker=new google.maps.Marker({
		position:latLang,
		map: map,
		title: media_data.location_now,
		optimized: false,
		icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
	  });
	selectedMarker = marker;
	//infoWindow.setContent("<strong>Address:</strong> "+media_data.location_now);
	//infoWindow.open(map, marker);
	google.maps.event.addListener(marker, 'click', function() {
		//infoWindow.open(map, marker);
		tuserAllFeed(media_data);
	});

}

  //if(typeof map != 'undefined') {
  	map.panTo(latLang);
  //}

}
//tuser audio player
var current_play_indexVideo = 0;
$(function(){
	//video player section start
	// $("#video").on("ended", function(){
	// 	//alert("Hello");
	// 	var next_play_indexVideo = current_play_indexVideo + 1;
	// 	if(next_play_indexVideo >= jv_tu_video.length)
	// 		return;
	//
	//
	// 	$("#video").attr("src", jv_tu_video[next_play_indexVideo].filePath);
	//
	//
	//
	//
	// 	$("#video").trigger("play");
	// 	current_play_indexVideo = next_play_indexVideo;
	// 	/*if(jv_tu_video[next_play_indexVideo].events != GLOBAL_TUSER_EVENT){
	// 		$("#video").attr("src","");
	// 	}*/
	// });
	if(jv_tu_video == null || jv_tu_video == ''){
		$("#video").hide();
		$("#video_feed").html("<p>No video found</p>");

	}else{
		$("#video").show();
		//streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/"+jv_tu_video[0]["filePath"]);
		streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_tu_video[0]["user_code"] + "-"+jv_tu_video[0]["events"]+".flv");
		<?php /*$("#video").attr("src", "{{url('public/uploads/video')}}/" + jv_tu_video[0]["user_code"] + "/" + jv_tu_video[0]["events"] + "/" + jv_tu_video[0]["filePath"]);*/ ?>
		//$("#video").attr("data-event",jv_tu_video[0]["alert_detail_id"]);
		//$("#video").attr("data-eventid",jv_tu_video[0]["events"]);
		//$("#video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + jv_tu_video[0]["filePath"]);
		eventPopupID = jv_tu_video[0]["alert_detail_id"] + jv_tu_video[0]["events"];
		popupData(eventPopupID,jv_tu_video[0]);




	}
	//data frequency
	//tuserAllFeed(jv_tu_allfeed[0]['alert_detail_id']);
});
//transport's load more option
$(document).ready(function(){
	//video
	$(document).on('click','#loadMoreTuserVideo',function(){
        var ID = $(this).attr('lastid');
        $('#loadMoreTuserVideo').html("<p>Loading video...</p>");
        $.ajax({
            cache: false,
            type:'POST',
            url:'{{url('api/v1/tRecords')}}',
						headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
            data:"status=video&user_id="+GLOBAL_TUSER_ID+"&last_id="+ID+"&tEvent="+GLOBAL_TUSER_EVENT,
            success:function(response){
							if(response.message == "Invalid Token Authentication.") {
									console.log("Invalid Token Authentication.");
							}	 else {

										if(response == 'NoMoreVideo'){
											$('#loadMoreTuserVideo').html("<p>Load More Video</p>");
											//alert("No more video found.");
											//alert('No more image found on Event - '+GLOBAL_BUSER_EVENT);
										}else if(response == 'NoVideoFound'){
											$('#video_feed').html("<p>No video found</p>");
											$('#loadMoreTuserVideo').html("<p>Load More Video</p>");
										}else{

											var fixturesData=JSON.parse(response);
											jv_tu_video = fixturesData;
											var thedata='';
											var LastAlertDetailId = '';

											$.each(jv_tu_video,function(){

												LastAlertDetailId = this.alert_detail_id;
												//jv_tu_video.push(this.filePath);
												thedata += "<li type='tuvideo' tuvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";

											});
											$('#video_feed').append(thedata);
											$("#loadMoreTuserVideo").attr("lastid",LastAlertDetailId);
											$('#loadMoreTuserVideo').html("<p>Load More Video</p>");
										}
							} //if authentication
            }
        });
    });
	//event
	$(document).on('click','#loadMoreTuserEvent',function(){
		//e.stopPropagation();
        var ID = $(this).attr('lastid');

        $('#loadMoreTuserEvent').html("<p>Loading event...</p>");
        $.ajax({
            cache: false,
            type:'POST',
            url:'{{url('api/v1/tRecords')}}',
						headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
            data:"status=events&user_id="+GLOBAL_TUSER_ID+"&last_id="+ID,
            success:function(response){
							if(response.message == "Invalid Token Authentication.") {
									console.log("Invalid Token Authentication.");
							}	 else {

										if(response == 'NoMoreEvent'){

											$('#loadMoreTuserEvent').html("<p>Add Events</p>");
											//alert("No more event found.");
											//alert('No more image found on Event - '+GLOBAL_BUSER_EVENT);
										}else if(response == 'NoImageFound'){
											$('#tu_event').html("<p>No event found</p>");
											$('#loadMoreTuserEvent').html("<p>Add Events</p>");
										}else{
											var fixturesData=JSON.parse(response);
											var thedata='';
											var LastAlertDetailId = '';
											var ectr = 0;
											$.each(fixturesData,function(key,item){
												//LastAlertDetailId = item.alert_detail_id;
												LastAlertDetailId = item.alert_detail_id;


												ectr = ectr + 1;
												if(ectr == 1) {

													var event_name = "";
														if (item.event_name != " ") {
															event_name = item.event_name;
														} else {
															event_name = "Event - "+item.events;
														}

													if($('#tu_event li').hasClass('activeClass')) {
															thedata += "<li tuuser_code='"+item.user_code+"' type='uevent' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+event_name+"</li>";
													} else {


														  //thedata += "<li class='activeClass' tuuser_code='"+item.user_code+"' type='uevent' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+"Event - "+item.events+"</li>";

														  thedata += "<li class='activeClass' tuuser_code='"+item.user_code+"' type='uevent' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+event_name+"</li>";


													}

													 $(".eventTrans").val(event_name);
														  $(".eventTransID").val(item.alert_detail_id);


													//$("#deleteSelectedEventTransport").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+item.user_code+'/'+item.events);
													$("#deleteSelectedEventTransport").data('accesscode',item.user_code);
													$("#deleteSelectedEventTransport").data('events',item.events);
													GLOBAL_TUSERACCESSCODE = item.user_code;
													//$("#video").attr("data-event",item.alert_detail_id);
													//$("#video").attr("data-eventid",item.events);
													$("#video").attr("src", "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.filePath);
													eventPopupID = item.alert_detail_id + item.events;
													popupData(eventPopupID,item);

													tranportMultipleLocation(item.user_code,item.events,"transport");
													tuserAllFeed(item);
													streamingArchiveTransport("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + item.user_code + "-"+item.events+".flv");
													GLOBAL_TUSER_EVENT = item.events;
												} else {

													var event_name = "";
													if (item.event_name != " ") {
														event_name = item.event_name;
													} else {
														event_name = "Event - " + item.events;
													}


													thedata += "<li type='uevent' tuuser_code='"+item.user_code+"' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+event_name+"</li>";
													//$("#deleteSelectedEventTransport").attr('href','http://raptorsecuritysoftware.com/dashboard/delete-selected-event/'+item.user_code+'/'+item.events);
												}

											});
											$('#tu_event').append(thedata);
											$("#loadMoreTuserEvent").attr("lastid",LastAlertDetailId);
											$('#loadMoreTuserEvent').html("<p>Add Events</p>");
										}
							} //if authentication
            }
        });
    });
	setTimeout(function(){
		$("#loadMoreTuserVideo").trigger('click');
		$("#loadMoreTuserEvent").trigger('click');
	},1000);
});



function popupData(eventPopupID,eventRec) {


	var frameVideoClassCounter = $('.frame-video'+eventPopupID).length;

	if(frameVideoClassCounter == 0) {

		var transportName = $('#tuser').find(":selected").text();



		$("#trasportvideo").append("<div id='frame-video' class='frame-video"+eventPopupID+"' style='width:400px !important; height: 400px !important;'><div class='col-lg-12 header'  align='right'><span class='btn btn-warning btn-sm'>Transport: "+transportName+" <span style='color: #006E2E !important'><strong>Event #"+eventRec.events+"</strong></span></span><span onclick='transportClose("+eventPopupID+")' id='videoClose"+eventPopupID+"' class='btn btn-danger btn-sm'>X</span></div><div class='col-lg-12' style='z-index:9999 !important; width:100% !important; height: 82% !important;'><div class='mainVideo"+eventPopupID+"' id='mainVideo"+eventPopupID+"' class='col-lg-12' style='z-index: 99999; height: 100%; width: 100%;'></div></div><div class='col-lg-12 header'  align='right'><span onclick='transportClose("+eventPopupID+")' id='videoClose1"+eventPopupID+"' class='btn btn-danger btn-sm'>X</span></div></div>");

		$( ".frame-video"+eventPopupID ).draggable({ handle:'.header'}).resizable();
	}

	  var frameEventIntClassCounter = $('.tUserEventInt'+eventPopupID).length;


		if(frameEventIntClassCounter == 0) {

			var event_name = "";
				if (eventRec.event_name != " ") {
					event_name = eventRec.event_name;
				} else {
					event_name = "Event - "+eventRec.events;
				}

				$("#transportEventIntelligence").append("<div id='tUserEventInt' class='tUserEventInt"+eventPopupID+"'><div class='col-lg-12 header' align='right' style='background-color: #f0ad4e'><span style='color: #fff'>Event Intelligence - Transport: "+eventRec.user_name+" <span style='color: #006E2E !important'><strong>"+event_name+"</strong></span></span><span id='tuEvClose"+eventPopupID+"' onclick='tranportEventClose("+eventPopupID+")' class='btn btn-danger btn-sm'>X</span></div><div class='col-lg-12'><div id='tuEvContent"+eventPopupID+"'>&nbsp;&nbsp;Location:&nbsp;&nbsp;<span class='tuser-location"+eventPopupID+"'>"+eventRec.location_now+"</span><hr>&nbsp;&nbsp;Event:&nbsp;&nbsp;<span class='tuser-event"+eventPopupID+"'>"+eventRec.events+"</span><hr>&nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class='tuser-tds"+eventPopupID+"'>"+eventRec.alert_datetime+"</span><hr>&nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class='tuser-speed"+eventPopupID+"'>"+eventRec.alert_speed+" mph</span><hr>&nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class='tuser-elevation"+eventPopupID+"'>"+eventRec.elevation+" ft</span><hr>&nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class='tuser-direction"+eventPopupID+"'>"+eventRec.direction+"</span><hr>&nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class='tuser-battery-level"+eventPopupID+"'>"+eventRec.alert_battery_level+"</span><hr>&nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class='tuser-lat"+eventPopupID+"'>"+eventRec.lat+"</span><hr>&nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class='tuser-lng"+eventPopupID+"'>"+eventRec.lng+"</span><hr></div></div></div>");

				$( ".tUserEventInt"+eventPopupID ).draggable({ handle:'.header'}).resizable();
	  }


}

function streamingArchiveTransport(src){
	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',type:'video'};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'transparent'};
	var attributes={id:'video'};
	swfobject.embedSWF('https://raptorsecuritysoftware.com/public/assets/player.swf','video','100%','300','10.2',null,flashvars,params,attributes,embedHandler);

}

var embedHandler = function (e){
	var obj = event.ref;
   if(e.success){

      //console.log("e.ref.TotalFrames " + e.ref.TotalFrames());

   }

};

// function callback(event) {
// 	var obj = event.ref;
// 	for (var key in obj) {
// 		    console.log(key);
// 		}
// 		//console.log("obj.hidden " + obj.hidden);
// 	var currentFrame = obj.TotalFrames;
// 	console.log("currentFrame "+ currentFrame);
// 	swfobject.getObjectById('video').GotoFrame(50);
// }


function streamingArchiveTransportPopup(src,accesscode,eventPopupID) {
	var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',type:'video'};
	var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
	var attributes={id:'mainVideo'+eventPopupID};
	swfobject.embedSWF('https://raptorsecuritysoftware.com/public/assets/player.swf','mainVideo'+eventPopupID,'100%','100%','10.2',null,flashvars,params,attributes);
}

// function callbackfunc(event) {
//
// 			// console.log("event" + event.ref);
// 			  var obj = event.ref;
// 				//obj.CurrentFrame;
// 			//  for (var key in obj) {
// 			// 	    console.log(key);
// 			// 	}
// 			 //swfobject.getObjectById('video').StopPlay();
// 			 //obj.StopPlay();
//       // var totalFrames = obj.TotalFrames;
//       //   console.log("totalFrames : " + totalFrames);
//       // var currentFrame1 = obj.CurrentFrame;
// 			// 	console.log("currentFrame1 : " + currentFrame1);
// 			if(obj.PercentLoaded() === 100){
//
// 			}
//         obj.addEventListener("onStateChange", "onytplayerStateChange");
// }

// function onStateChange() {
// 	 					console.log("on state change has been called");
//
//             var obj = swfobject.getObjectById("video");
//             currentFrame1 = obj.TcurrentFrame;
// 						console.log("currentFrame1 : " + currentFrame1);
//
// }

function transportPopUp() {
	//accesscode = $("#tuser").find(':selected').val();
	accesscode = $("#tuser").find(':selected').data('accesscode');
	console.log('accesscode'+accesscode);
	console.log('eventPopupID'+GLOBAL_TUSER_EVENT);
	//streamingArchiveTransportPopup("{{url('public/videos/')}}/"+accesscode+"-"+GLOBAL_TUSER_EVENT+".flv", accesscode,eventPopupID);

	streamingArchiveTransportPopup("https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/" + accesscode + "-"+GLOBAL_TUSER_EVENT+".flv", accesscode,eventPopupID);

	 $(".frame-video"+eventPopupID).fadeIn();

	 $('#video').hide();
	// $("#mainVideo").attr("src", src);
	// $("#mainVideo").attr("autoplay", true);
	// $("#mainVideo").attr("style","width:100%");
	// $("#frame-video").fadeIn();
	//
	//   $("#videoClose").click(function(){
	// 	$("#mainImage").show();
	// 	$("#frame-video").fadeOut();
	// 	//$("#text-overlay").fadeOut();
	// });
}

function tranportEventClose(eventData) {
	$(".tUserEventInt"+eventData).fadeOut();


}

function transportClose(eventData) {
	$(".frame-video"+eventData).fadeOut();
	$('#video').show();
	console.log("stop video called");
	//$("#video").trigger("pause");

	swfobject.getObjectById('video').StopPlay();


}

// $(document).on("click","#video",function(e){
//
//
// 	var src = $(this).attr("src");
//
//
//
//
// 	$(".mainVideo"+eventPopupID).attr("src", src);
// 	$(".mainVideo"+eventPopupID).attr("autoplay", true);
// 	$(".mainVideo"+eventPopupID).attr("style","width:100%");
// 	$(".frame-video"+eventPopupID).fadeIn();
// 	//$("#text-overlay").fadeIn();
// 	// $("#text-overlay").click(function(){
// 	// 	$(this).fadeOut();
// 	// 	$("#frame-video").fadeOut();
// 	// });
//
// 	/*$("#frame-video").click(function(){
// 		$("#mainImage").show();
// 		$(this).fadeOut();
// 		//$("#text-overlay").fadeOut();
// 	});*/
//
// 	//var eventData = $(this).data("event");
//
// 	// $("#videoClose"+eventPopupID).click(function(){
// 	// 	//$("#mainImage").show();
// 	// 	$(".frame-video"+eventPopupID).fadeOut();
// 	// 	//$("#text-overlay").fadeOut();
// 	// });
// 	e.preventDefault();
// });




$( "#frame" ).draggable().resizable();
$(document).on("click","#ZoomIn",function(e){

	$(".tUserEventInt"+eventPopupID).fadeIn();

	// $("#tUserEventInt").fadeIn();
	// //$("#text-overlay").fadeIn();
	// $( "#tUserEventInt" ).draggable();
	// $("#tuEvClose").click(function(){
	// 	$("#mainImage").show();
	// 	$("#tUserEventInt").fadeOut();
	// 	//$("#text-overlay").fadeOut();
	// });
	e.preventDefault();
});

function updateTransportEventIntelligence(data) {


	$(".tuser-location").html(data["location_now"]);
	$(".tuser-tds").html(data["tds"]);
	$(".tuser-direction").html(data["direction"]);
			//$(".tuser-level").html(data["alert_level"]);
			$(".tuser-battery-level").html(data["battery_level"]);
			$(".tuser-event").html(data["event_id"]);
			//$(".tuser-ip").html(data.ip_address);
			$(".tuser-lat").html(data["lat"]);
			$(".tuser-lng").html(data["lon"]);
			//$(".tuser-floor").html(data["floor"]);

			//$("#location_now").html("Address: <span>"+data.location_now+"</span>TDS: <span>"+data.alert_datetime+"</span>Speed: <span>"+data.alert_speed+"</span>Elevation: <span>"+data.elevation+"ft</span>Direction: <span>"+data.direction+"</span>");

}

function tranportMultipleLocation(accesscode,events,type) {
  var transportLineCoordinates = [];

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
												var latLangTransport = new google.maps.LatLng(lat, lon);
												transportLineCoordinates.push(latLangTransport);

												var markerTransport = new google.maps.Marker({
													position: latLangTransport,
													map: map,
													icon: unSelectedMarkerIcon //selectedMarkerIcon
												 });

												markerTransport.addListener('click', function() {
										            updateTransportEventIntelligence(snapDict);
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


							} //if authentication
            }
        });
}


//list to firebase video if there is incoming changes by access code the page
//console.log("Access Code" + GLOBAL_TUSERACCESSCODE);
checkNewTransportEvent();
function checkNewTransportEvent() {
	 console.log("Transport Load New Events");
		var transportVideoRef = firebase.database().ref('video/'+GLOBAL_TUSERACCESSCODE);
		var refresh = false;
		transportVideoRef.on('value', function(snapshot){
						if(GLOBAL_REFRESH == true) {
							   GLOBAL_REFRESH = false;
								 console.log("Global Refresh true");
						} else {
							  console.log("Global Refresh false");
							  snapshot.forEach(function(childSnapshot) {
									var snapDict = childSnapshot.val();
								 	var key = childSnapshot.key;

									 	if(snapDict["refresh_status"] == "true") {
											 transportVideoRef.child(key).update({ refresh_status : "false" });

											 if(refresh==false) {
												 	$("#tu_event").empty();
													$("#video_feed").empty();
													displayAllEvents(GLOBAL_TUSER_ID);
													refresh = true;


											 }
										}
								});
						}
							// var refresh = false;
							// var transportFeedcounter = 0;
							//
							// snapshot.forEach(function(childSnapshot) {
							// 	var snapDict = childSnapshot.val();
							// 	var key = childSnapshot.key;
							//
							// 	if(snapDict["refresh_status"] == "true") {
							// 		 transportVideoRef.child(key).update({ refresh_status : "false" });
							// 		 //location.href = "http://raptorsecuritysoftware.com/dashboard/archived";
							// 		  refresh = true;
							//
							// 	}
							// 	transportFeedcounter = transportFeedcounter + 1;
							// });
							//
							// if(refresh == true) {
							// 	if(transportFeedcounter == snapshot.numChildren()) {
							// 		  console.log("Refresh has been called");
							// 			$("#tu_event").empty();
							// 			$("#video_feed").empty();
							// 			if(GLOBAL_REFRESH == false) {
							// 					displayAllEvents(GLOBAL_TUSER_ID);
							// 			} else {
							// 				 GLOBAL_REFRESH = false;
							// 			}
							// 			refresh = false;
							// 		}
							// }




		});




}


function deleteEventTransport() {
	var c = confirm("Are you sure you want to completely remove this Event from this user?\n\nPress 'OK' to delete.\nPress 'Cancel' to go back without deleting the Event.");
	if(c==true) {
		 var accesscode = $("#deleteSelectedEventTransport").data("accesscode");
		 var events = $("#deleteSelectedEventTransport").data("events");

		 				$.ajax({
							type: "GET",
							headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
							url:  "https://raptorsecuritysoftware.com/dashboard/delete-selected-event/"+accesscode+"/"+events,
							cache: false,
							success: function(){
								$("#tu_event").empty();
								$("#video_feed").empty();
								displayAllEvents(GLOBAL_TUSER_ID);


								// if ($('#tu_event').has('li').length === 0) {
								// 			location.href = "https://raptorsecuritysoftware.com/dashboard/archived";
								// }

							}
					  });

	}

}



//autoselect user
if(transSelectedEvents != "") {

	//console.log("transSelectedEvents: "+ transSelectedEvents);
	GLOBAL_TUSER_ID = transSelectedEvents;
	displayAllEvents(GLOBAL_TUSER_ID);
	$( document ).ready(function() {
		$('#tuser option').removeAttr('selected').filter('[value=' + transSelectedEvents + ']').attr('selected', true);
	});
	//$('#tuser  option[value="'+transSelectedEvents+'"]').prop("selected", true);
}

</script>
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<div class="col-lg-12 all-background-opacity">
    <div class="col-lg-5">
        <ul class="col-lg-12 nav nav-tabs headerText" role="tablist">
            <li class="col-lg-3 responsiveVersion-3"><p class="eventText">Archived Event</p></li>


            <?php  /*
            <li id="tu_video_click" role="presentation" class="active"><a href="#tu_video" role="tab" aria-controls="tu_video" data-toggle="tab">Video</a></li>
            */ ?>

            <li class="col-lg-5">
            	<form method="post" action="{{url('dashboard/archived')}}">
            		<input type="text" name="eventTrans" value="" class="eventTrans" style="color: #000">
            		<input type="hidden" name="eventTransID" class="eventTransID">
            		<input type="submit" name="Update" value="Update" class="btn btn-sm btn-danger">
            	</form>
            </li>

            <div class="col-lg-3 select">
                <select class="form-control" id="tuser" name="tuser"><script>jf_tusers();</script></select>
            </div>
        </ul>
        <div style="clear: both;"></div>
        <div class="col-lg-3 responsiveVersion-3">
       	 	<ul class="col-lg-12 tu-event" id="tu_event"><script>//jf_tu_events();</script></ul>

					<div class="col-lg-12 loadMoreButton" lastid=""><a class="btn btn-danger btn-sm" href="javascript:void(0)" id="deleteSelectedEventTransport" data-accesscode="" data-events="" onClick="deleteEventTransport()">Delete selected event</a></div>
        	<div class="col-lg-12 loadMoreButton" id="loadMoreTuserEvent" lastid=""><p>Add Events</p></div>

        </div>

        <div class="col-lg-9 tab-content responsiveVersion-9">
            <div role="tabpanel" class="col-lg-12 border-right-10px tab-p ane active" id="tu_video">
                <?php /*<div class="col-lg-3">
                    <ul class="col-lg-12 tu-event" id="video_feed"><script>//jf_tu_videos();</script></ul>
                    <div class="col-lg-12 loadMoreButton" id="loadMoreTuserVideo" lastid=""><p>Load More Video</p></div>
                </div>*/ ?>
                <div class="col-lg-12">
                	<!--<span id="video_feed"></span>-->
                    <?php /*<video id="video" controls="controls"></video>*/ ?>
										<?php /*<div onmousedown="transportPopUp()" > */ ?>
											<div id="video"></div>
											<div class="popupTransportClickable" onclick="transportPopUp()">&nbsp;</div>

										<?php /*</div>*/ ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <p>Transport Map:</p>
        <div id="tusermap" class="top-btm-map"></div>
    </div>
    <div class="col-lg-2" id="transDataFrequency">
        <p>Event Intelligence - Transport <span id="ZoomIn" class="btn btn-primary btn-xs">+</span></p>
        <div class="tu-last-frequency">
            &nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="tuser-location"></span><hr>
            &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="tuser-event"></span><hr>
            &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="tuser-tds"></span><hr>
            &nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="tuser-speed"></span><hr>
            &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="tuser-elevation"></span><hr>
            &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="tuser-direction"></span><hr>
						<?php /*&nbsp;&nbsp;Floor:&nbsp;&nbsp;<span class="tuser-floor"></span><hr>*/ ?>
            &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="tuser-battery-level"></span><hr>
            &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="tuser-lat"></span><hr>
            &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="tuser-lng"></span><hr>
        </div>
    </div>



</div>
