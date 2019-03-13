<?php
$qryFtc = mysqli_fetch_object($qry);
$GLOBAL_TUSER_ID = $qryFtc->user_id;
//echo $GLOBAL_TUSER_ID;
$GLOBAL_TUSER_EVENT = $qryFtc->events;
if($GLOBAL_TUSER_EVENT == '' || $GLOBAL_TUSER_EVENT == NULL || $GLOBAL_TUSER_EVENT == 0){
	$GLOBAL_TUSER_EVENT = 1;	
}
include 'pages/functions.php';
?> 
<script>
var tuserChange = false; 
var tuserEventChange = false;
var video = null;
var jv_tusers = <?php echo json_encode(pf_tusers($client_id));?>;
var jv_tu_event = <?php echo json_encode(pf_tu_events($GLOBAL_TUSER_ID));?>;
var jv_tu_video = <?php echo json_encode(pf_tu_videos($GLOBAL_TUSER_ID));?>;
var mapLoad = true;
var intMapLoad = true;
var jv_tu_allfeed = <?php echo json_encode(pf_tu_allfeeds($GLOBAL_TUSER_ID,$GLOBAL_TUSER_EVENT));?>;
var GLOBAL_TUSER_LAT = jv_tu_allfeed[0]['lat'];
var GLOBAL_TUSER_LNG = jv_tu_allfeed[0]['lng'];
var GLOBAL_TUSER_ID = jv_tusers[0]['user_id'];
var GLOBAL_TUSER_EVENT = jv_tu_event[0]['events'];
var GLOBAL_TUSER_NAME = jv_tusers[0]['user_name'];
</script>
<script src="pages/functions.js"></script>
<!--<script src="pages/tuserfeedsync.js"></script>-->
<?php
include 'include/syncTrAllFeed_AlertStatus.php';
?>
<script>
$(document).on("change","#tuser", function(e){
	//$("#tusermap").html("<p class='loading' style='color:#000'>Please Wait....</p>");
	//$("#map_integ_threat").html("<p class='loading' style='color:#000'>Please Wait....</p>");
	tuserChange = true;
	$("#video").attr("src",'');	
	$("#tu_event").html("<p class='loading'>Loading....</p>");
	$("#video_feed").html("<p class='loading'>Loading....</p>");
	GLOBAL_TUSER_ID = $(this).val();
	GLOBAL_TUSER_EVENT = $("#tuser option:selected").attr("tuser_sel_event");
	GLOBAL_TUSER_NAME = $("#tuser option:selected").text();
	e.preventDefault();
});
//TRANSPORT section
$(document).on("click","li[type='uevent']", function(e){
	jv_tu_video = '';
	tuserEventChange = true;	
	var ActiveItem = $(this);
	$("li[type='uevent']").removeClass("activeClass");
	ActiveItem.addClass("activeClass");
	$("#video").attr("src",'');	
	$("#video_feed").html("<p class='loading'>Loading....</p>");
	$("#tusermap").html(null);
	GLOBAL_TUSER_ID = GLOBAL_TUSER_ID;
	GLOBAL_TUSER_EVENT = $(this).attr("tuevent_id"); 
	//console.log(GLOBAL_TUSER_EVENT);
	//event video after click on event
	$.ajax({
	type: "POST",
	url:'clickableRecord/tRecords.php',
	//url: "eventVideo.php",
	data:"status=eventVideo&user_id="+GLOBAL_TUSER_ID+"&tEvent="+GLOBAL_TUSER_EVENT,
	success: function(response){
			/*setTimeout(function(){
				$("#video_feed").html(response);
			},500);*/
			if(response == 'NoVideoFound'){
				$('#video_feed').html("<p>No video found</p>");
			}else{
				var fixturesData=JSON.parse(response);
				jv_tu_video = fixturesData;
				var thedata='';
				var LastAlertDetailId = '';
				$.each(jv_tu_video,function(){
					LastAlertDetailId = this.alert_detail_id;
					thedata += "<li type='tuvideo' tuvideo_id='"+ this.alert_detail_id +"'>"+this.alert_datetime+"</li>";
					//console.log('T video: '+item.alert_detail_id);
				});
				$('#video_feed').html(thedata);
				$("#loadMoreTuserVideo").attr("lastid",LastAlertDetailId);  
			}
		}
	});		
	e.preventDefault();
});

$(document).on("click","li[type='tuvideo']", function(e){
	//selected Item highlight section
	var ActiveItem = $(this);
	$("li[type='tuvideo']").removeClass("activeClass");
	ActiveItem.addClass("activeClass");
	
	var tuvideo_id = $(this).attr("tuvideo_id");
	$(jv_tu_video).each(function(){
		if(tuvideo_id == this.alert_detail_id){
			//console.log(tuvideo_id+', '+this.alert_detail_id);
			$("#video").attr("src", "");
			$("#video").attr("src", this.filePath);//media_path+this.user_id+"/video/"+this.video);
			$("#video").attr("autoplay",true);
			selectMedia(this);
		}
	});
	//console.log(tuvideo_id);
	e.preventDefault();
});
/*function tuserAllFeed(custom_id){
	$(jv_tu_allfeed).each(function(){
		if(this.alert_detail_id == custom_id){
			var media_status = "";
			$(".tuser-location").html(this.location_now);
			$(".tuser-tds").html(this.alert_datetime);
			$(".tuser-speed").html(this.alert_speed);
			$(".tuser-elevation").html(this.elevation+"ft");
			$(".tuser-direction").html(this.direction);
			$(".tuser-level").html(this.level);
			$(".tuser-battery-level").html(this.alert_battery_level);
			$(".tuser-event").html(this.events);
			$(".tuser-ip").html(this.ip_address);
			$(".tuser-lat").html(this.lat);
			$(".tuser-lng").html(this.lng);			
			$("#location_now").html("Address: <span>"+this.location_now+"</span>TDS: <span>"+this.alert_datetime+"</span>Speed: <span>"+this.alert_speed+"</span>Elevation: <span>"+this.elevation+"ft</span>Direction: <span>"+this.direction+"</span>");
		}
	});
}*/

var map, marker, flightPlanCoordinates, flightPath;
var selectedMarker = null;
//var infoWindow = new google.maps.InfoWindow();
function initialize(){
	//console.log('t: '+TrOnlineStatus);
	var myCenter=new google.maps.LatLng(GLOBAL_TUSER_LAT,GLOBAL_TUSER_LNG);
	var mapProp = {
	  center:myCenter,
	  zoom:18,
	  mapTypeId: google.maps.MapTypeId.SATELLITE,//SATELLITE,//HYBRID//TERRAIN//ROADMAP
	  fullscreenControl: true
	  };
	map=new google.maps.Map(document.getElementById("tusermap"),mapProp);
	marker=new google.maps.Marker({
	  position:myCenter,
	  icon: selectedMarkerIcon
	  });
	marker.setMap(map);  
	selectedMarker = marker;
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
						//console.log('this: '+this.alert_detail_id);
						//tuserAllFeed(alert_detail_id);
						//remove all selected marker
						selectedMarker.setMap(null);
						//set as selected marker
						var latLang123 = new google.maps.LatLng(this.lat, this.lng);
						var marker2 = new google.maps.Marker({
							position:latLang123,
							map: map,
							icon: selectedMarkerIcon
						  });
						selectedMarker = marker2;							
						//if(this.audio != null || (this.audio != null && this.image != null)){
						if(this.fileType == 'video'){
							$("#video").show();
							$('a[href="#tu_video"]').tab("show");
							if(this.alert_detail_id = jv_tu_allfeed[w]["alert_detail_id"]){
								$("#video").attr("src", jv_tu_allfeed[w]["filePath"]);
								$("#video").trigger("play");
								$("#video").on("ended", function(){
									//alert("Hello"); 
									$("#video").attr("src", jv_tu_allfeed[w]["filePath"]);
									//$("#audio").trigger("pause");
								});
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
	selectedMarker.setMap(null);
	var latLang = new google.maps.LatLng(media_data.lat, media_data.lng);
		var marker=new google.maps.Marker({
		position:latLang,
		map: map,
		title: media_data.location_now,
		icon: selectedMarkerIcon 
	  });
	selectedMarker = marker;
	//infoWindow.setContent("<strong>Address:</strong> "+media_data.location_now);
	//infoWindow.open(map, marker);
	google.maps.event.addListener(marker, 'click', function() {
		//infoWindow.open(map, marker);
	});
	map.panTo(latLang);
}
//tuser audio player
var current_play_indexVideo = 0; 
$(function(){
	//video player section start
	$("#video").on("ended", function(){
		//alert("Hello");
		var next_play_indexVideo = current_play_indexVideo + 1;
		if(next_play_indexVideo >= jv_tu_video.length)
			return;
		$("#video").attr("src", jv_tu_video[next_play_indexVideo].filePath);
		//console.log('video ended');
		$("#video").trigger("play");	
		current_play_indexVideo = next_play_indexVideo;
		/*if(jv_tu_video[next_play_indexVideo].events != GLOBAL_TUSER_EVENT){
			$("#video").attr("src","");
		}*/
	});
	if(jv_tu_video == null || jv_tu_video == ''){
		$("#video").hide(); 
		$("#video_feed").html("<p>No video found</p>");
		//console.log('video null'); 
	}else{
		$("#video").show(); 
		$("#video").attr("src", jv_tu_video[0]["filePath"]);
		//console.log('video playing');
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
            url:'clickableRecord/tRecords.php',
            data:"status=video&user_id="+GLOBAL_TUSER_ID+"&last_id="+ID+"&tEvent="+GLOBAL_TUSER_EVENT,
            success:function(response){
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
						//console.log('T video: '+item.alert_detail_id);
					});
					$('#video_feed').append(thedata);
					$("#loadMoreTuserVideo").attr("lastid",LastAlertDetailId);  
					$('#loadMoreTuserVideo').html("<p>Load More Video</p>");
				}
            }
        });
    });
	//event
	$(document).on('click','#loadMoreTuserEvent',function(){
        var ID = $(this).attr('lastid');
        $('#loadMoreTuserEvent').html("<p>Loading event...</p>");
        $.ajax({
            cache: false,
            type:'POST',
            url:'clickableRecord/tRecords.php',
            data:"status=events&user_id="+GLOBAL_TUSER_ID+"&last_id="+ID,
            success:function(response){
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
					$.each(fixturesData,function(key,item){
						//LastAlertDetailId = item.alert_detail_id;
						LastAlertDetailId = item.alert_detail_id;
						thedata += "<li type='uevent' uevent_id='"+ item.alert_detail_id +"' tuevent_id='"+ item.events +"'>"+"Event - "+item.events+"</li>";
					});
					$('#tu_event').append(thedata);
					$("#loadMoreTuserEvent").attr("lastid",LastAlertDetailId);  
					$('#loadMoreTuserEvent').html("<p>Add Events</p>");
				}
            }
        });
    });
	setTimeout(function(){
		$("#loadMoreTuserVideo").trigger('click');
		$("#loadMoreTuserEvent").trigger('click');
	},1000);
});
$(document).on("click","#video",function(e){
	$("#mainImage").hide();
	var src = $(this).attr("src");
	$("#mainVideo").attr("src", src);
	$("#mainVideo").attr("autoplay", true);
	$("#mainVideo").attr("style","width:100%");
	$("#frame-video").fadeIn();
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
	$("#videoClose").click(function(){
		$("#mainImage").show();
		$("#frame-video").fadeOut();
		//$("#text-overlay").fadeOut();
	});
	e.preventDefault();
});
$( "#frame-video" ).draggable().resizable();
$( "#frame" ).draggable().resizable();
$(document).on("click","#ZoomIn",function(e){
	$("#tUserEventInt").fadeIn();
	//$("#text-overlay").fadeIn();
	$( "#tUserEventInt" ).draggable().resizable();
	$("#tuEvClose").click(function(){
		$("#mainImage").show();
		$("#tUserEventInt").fadeOut();
		//$("#text-overlay").fadeOut();
	});
	e.preventDefault();
});
</script>
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<div class="col-lg-12 all-background-opacity">
    <div class="col-lg-5">
        <ul class="col-lg-12 nav nav-tabs headerText" role="tablist"> 
            <li class="col-lg-3 responsiveVersion-3"><p class="eventText">Archived Event</p></li>            
            <li id="tu_video_click" role="presentation" class="active"><a href="#tu_video" role="tab" aria-controls="tu_video" data-toggle="tab">Video</a></li>
            <div class="col-lg-3 select">
                <select class="form-control" id="tuser" name="tuser"><script>jf_tusers();</script></select>
            </div>           
        </ul>      	
        <div style="clear: both;"></div>
        <div class="col-lg-3 responsiveVersion-3">
       	 	<ul class="col-lg-12 tu-event" id="tu_event"><script>//jf_tu_events();</script></ul>
        	<div class="col-lg-12 loadMoreButton" id="loadMoreTuserEvent" lastid=""><p>Add Events</p></div>
        </div>
        
        <div class="col-lg-9 tab-content responsiveVersion-9">
            <div role="tabpanel" class="col-lg-12 border-right-10px tab-pane active" id="tu_video">
                <div class="col-lg-3">
                    <ul class="col-lg-12 tu-event" id="video_feed"><script>//jf_tu_videos();</script></ul>
                    <div class="col-lg-12 loadMoreButton" id="loadMoreTuserVideo" lastid=""><p>Load More Video</p></div>
                </div>
                <div class="col-lg-9 video-player">
                	<!--<span id="video_feed"></span>-->
                    <video id="video" controls="controls"></video>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <p>Transport Map:</p>
        <div id="tusermap" class="top-btm-map"></div>
    </div>
    <!--<div class="col-lg-2" id="transDataFrequency">
        <p>Event Intelligence - Transport <span id="ZoomIn" class="btn btn-primary btn-xs">+</span></p>
        <div class="tu-last-frequency">
            &nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="tuser-location"></span><hr>
            &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="tuser-event"></span><hr>
            &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="tuser-tds"></span><hr>
            &nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="tuser-speed"></span><hr>
            &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="tuser-elevation"></span><hr>
            &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="tuser-direction"></span><hr>
            &nbsp;&nbsp;Battery Level:&nbsp;&nbsp;<span class="tuser-battery-level"></span><hr>
            &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="tuser-lat"></span><hr>
            &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="tuser-lng"></span><hr>
        </div>                
    </div>-->
</div>