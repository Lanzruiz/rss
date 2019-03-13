<?php
$allAgent = array();
foreach($displayAlertDetail as $displayAlertDetails) {
	$allAgent[] = array(
		'alert_detail_id' => $displayAlertDetails->alert_detail_id,
		'events' => $displayAlertDetails->events,
		'alert_datetime' => $displayAlertDetails->alert_datetime,
		'user_id' => $displayAlertDetails->user_id,
		'status' => $displayAlertDetails->status,
		'user_name' => $displayAlertDetails->user_name,
		'lat' => (floatval($displayAlertDetails->lat)),
		'lng' => (floatval($displayAlertDetails->lng)),
		'location_now' => $displayAlertDetails->location_now,
		'filePath' => $displayAlertDetails->filePath,
		'fileType' => $displayAlertDetails->fileType,
		'image' => $displayAlertDetails->image,
		'audio' => $displayAlertDetails->audio,
		'video' => $displayAlertDetails->video,
		'alert_battery_level' => $displayAlertDetails->alert_battery_level,
		'alert_speed' => $displayAlertDetails->alert_speed,
		'direction' => $displayAlertDetails->direction,
		'elevation' => $displayAlertDetails->elevation
	);
}

/*
$tqry = mysqli_query($con,"select * from User where client_id = $client_id and status = 0 order by user_id desc");
$tqryFtc = mysqli_fetch_object($tqry);*/
?>
<style>
.noLiveTrackingMessage{text-align:center; padding:15px 0; font-size:24px}
</style>
<!--<script src="https://www.gstatic.com/firebasejs/3.2.1/firebase.js"></script>-->
<script>
var all_data = <?php echo json_encode($allAgent)?>;
//console.log(all_data);
function intLiveMap(){
	console.log('intLiveMap');
	var mapV,int_marker;
	var intSelectedMarker = null;
	/*var markers = [];
	var tmarkers = [];
	//var transportInfoWindow = new google.maps.InfoWindow();
	//var infoWindowIntMapOff = new google.maps.InfoWindow();
	var iconCounter = 0;
	var iconURLPrefix = '../images/';
	var icons = [
		iconURLPrefix + 'blue.png',
		iconURLPrefix + 'cyan.png',
		iconURLPrefix + 'gray.png',
		iconURLPrefix + 'green.png',
		iconURLPrefix + 'light_green.png',
		iconURLPrefix + 'yellow.png'
	]
	var iconsLength = icons.length;*/
	if(GLOBAL_TUSER_LAT ==  0 && GLOBAL_TUSER_LNG == 0) {
		var myCenter = new google.maps.LatLng(38.907192, -77.036871);
	} else {
			var myCenter=new google.maps.LatLng(GLOBAL_TUSER_LAT,GLOBAL_TUSER_LNG);
	}
	var mapProp = {
	  	center:myCenter,
	  	zoom:15,
	  	//mapTypeId: google.maps.MapTypeId.ROADMAP,//HYBRID//TERRAIN//SATELLITE
			mapTypeId: 'hybrid',
	  	fullscreenControl: true,
		streetViewControl: true,
		zoomControl: true,
		motionTracking: false,
		motionTrackingControl: false
	  };
	mapV=new google.maps.Map(document.getElementById("map_integ_threat"),mapProp);
	mapV.setTilt(45);

	if(GLOBAL_TUSER_LAT !=  0 && GLOBAL_TUSER_LNG != 0) {
		int_marker=new google.maps.Marker({
	  	position: myCenter,
			optimized: false,
	  	icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
		});
		google.maps.event.addListener(int_marker, 'click', function() {
  			//eventIntelligentIntegrated(jv_tu_allfeed[0]['alert_detail_id']);
  	});
		int_marker.setMap(mapV);
		intSelectedMarker = int_marker;
	}
	var tmusumarker, w;
	for (w = 0; w < all_data.length; w++) {
		tmusumarker = new google.maps.Marker({
			position: new google.maps.LatLng(all_data[w]["lat"], all_data[w]["lng"]),
			icon: '{{url('public/assets/images/agent-o.png')}}',
			map: mapV
		});
		google.maps.event.addListener(tmusumarker, 'click', (function(tmusumarker, w) {
		return function() {
		var alert_detail_id = all_data[w]["alert_detail_id"];
		//infoWindow.setContent("<strong>Address:</strong> "+all_data[w]['location_now']);
		//infoWindow.open(map, tmusumarker);
				$(all_data).each(function(){
					if(this.alert_detail_id == alert_detail_id){
						//console.log('this: '+this.alert_detail_id);
						//eventIntelligentIntegratedAgent(alert_detail_id);
						//remove all selected marker
						/*intSelectedMarker.setMap(null);
						//set as selected marker
						var latLang123 = new google.maps.LatLng(this.lat, this.lng);
						var marker2 = new google.maps.Marker({
							position:latLang123,
							map: mapV,
							icon: selectedMarkerIcon
						  });
						intSelectedMarker = marker2;*/
						//if(this.audio != null || (this.audio != null && this.image != null)){
						/*if(this.audio != null){
							$("#audio").show();
							$("#playPauseButton").show();
							$('a[href="#tu_audio"]').tab("show");
							if(this.alert_detail_id == all_data[w]["alert_detail_id"]){
								$("#audio").attr("src", "");
								$("#audio").attr("src", media_path+all_data[w]["user_id"]+'/audio/'+all_data[w]["audio"]);
								$("#audio").trigger("play");
								$("#audio").on("ended", function(){
									$("#audio").attr("src", media_path+all_data[w]["user_id"]+'/audio/'+all_data[w]["audio"]);
								});
								return false;
							}
						}else if(this.video != null){
							$("#video").show();
							$('a[href="#tu_video"]').tab("show");
							if(this.alert_detail_id = all_data[w]["alert_detail_id"]){
								$("#video").attr("src", media_path+all_data[w]["user_id"]+'/video/'+all_data[w]["video"]);
								$("#video").trigger("play");
								$("#video").on("ended", function(){
									$("#video").attr("src", media_path+all_data[w]["user_id"]+'/video/'+all_data[w]["video"]);
								});
								return false;
							}
						}else if(this.image != ""){
							$('a[href="#tuserPhoto"]').tab("show");
							$("#mainImage").attr("src", media_path+all_data[w]["user_id"]+'/image/'+all_data[w]["image"]);
							$("#frame").fadeIn();
							$("#frame").click(function(){
								$(this).fadeOut();
							});
						}*/
					}
				});
			}
		})(tmusumarker, w));
	}
/*dataRef = firebase.database().ref().child('location').child(GLOBAL_TUSER_ACCESS_CODE);
dataRef.on("value",function(snap){
	var iusers = snap.val();
	if(iusers['lat'] == s && iusers['lng'] == s){
		GLOBAL_TUSER_LAT = GLOBAL_TUSER_LAT;
		GLOBAL_TUSER_LNG = GLOBAL_TUSER_LNG;
		console.log('i-1: '+GLOBAL_TUSER_LAT+', '+GLOBAL_TUSER_LNG);
	}else{
		GLOBAL_TUSER_LAT = parseFloat(iusers['lat']);
		GLOBAL_TUSER_LNG = parseFloat(iusers['lng']);
		console.log('i-2: '+GLOBAL_TUSER_LAT+', '+GLOBAL_TUSER_LNG);
	}
});
*/	/*if(TrOnlineStatus == 'false'){
		$(function(){
			$("#map_integ_threat").html("<br><br><h1 style='color:#F00; text-align:center; padding:0; margin:0'>No Transport live now</h1>");
		});
	}else if(TrOnlineStatus == 'true' || TrOnlineStatus == 'deactivate'){
		$(function(){
			$("#map_integ_threat").html("<br><br><h1 style='color:#F00; text-align:center; padding:0; margin:0'>Waiting for server response....</h1>");
		});
	}else if(TrOnlineStatus == 'alert_on'){*/
		/*var dataRef = firebase.database().ref().child('location').child(GLOBAL_TUSER_ACCESS_CODE);
		dataRef.on("value",function(snap){
			var iusers = snap.val();
			if(iusers['user_access_code'] == GLOBAL_TUSER_ACCESS_CODE){
				if(iusers['lat'] == s && iusers['lng'] == s){
					GLOBAL_TUSER_LAT = GLOBAL_TUSER_LAT;
					GLOBAL_TUSER_LNG = GLOBAL_TUSER_LNG;
					//console.log('i-1: '+GLOBAL_TUSER_LAT+', '+GLOBAL_TUSER_LNG);
				}else{
					GLOBAL_TUSER_LAT = parseFloat(iusers['lat']);
					GLOBAL_TUSER_LNG = parseFloat(iusers['lng']);
					//console.log('i-2: '+GLOBAL_TUSER_LAT+', '+GLOBAL_TUSER_LNG);
				}
				var current_location = iusers['location_now'];
				var icon = '../images/Pulse_32x37.gif';//'../images/transport.png';
				var myLatLng = new google.maps.LatLng(GLOBAL_TUSER_LAT,GLOBAL_TUSER_LNG);
				if(intMapLoad){
					mapV = new google.maps.Map(document.getElementById('map_integ_threat'), {
						zoom: 18,
						center: myLatLng,
						mapTypeId: google.maps.MapTypeId.TERRAIN,////SATELLITE//HYBRID//ROADMAP
						fullscreenControl: true,
						streetViewControl: true,
						zoomControl: true,
						motionTracking: false,
      					motionTrackingControl: false
					});
					// Sets the map on all markers in the array.
					function tsetMapOnAll(mapV) {
						for (var i = 0; i < tmarkers.length; i++) {
							tmarkers[i].setMap(mapV);
						}
					}
					// Removes the markers from the map, but keeps them in the array.
					function tclearMarkers() {
						tsetMapOnAll(null);
					}
					// Deletes all markers in the array by removing references to them.
					function tdeleteMarkers(){
						tclearMarkers();
						tmarkers = [];
					}
					tdeleteMarkers();
					function taddMarker() {
						int_marker = new google.maps.Marker({
							position: myLatLng,
							map: mapV,
							icon: icon//,
							//optimized: false
						});
						tmarkers.push(int_marker);
						mapV.panTo(myLatLng);
					}
					taddMarker();
					//transportInfoWindow.setContent("<span style='color:#000;'>"+'Transport: '+transport_name+'<br>Address: '+current_location+"</span>");
					//transportInfoWindow.open(mapV, int_marker);
					google.maps.event.addListener(int_marker, 'click', function() {
						//transportInfoWindow.setContent("<span style='color:#000;'>"+'Transport: '+transport_name+'<br>Address: '+current_location+"</span>");
						//transportInfoWindow.open(mapV,int_marker);
					});
					intMapLoad = false;
				}else{
					function tsetMapOnAll(mapV) {
						for (var i = 0; i < tmarkers.length; i++) {
							tmarkers[i].setMap(mapV);
						}
					}
					// Removes the markers from the mapV, but keeps them in the array.
					function tclearMarkers() {
						tsetMapOnAll(null);
					}
					// Deletes all markers in the array by removing references to them.
					function tdeleteMarkers(){
						tclearMarkers();
						tmarkers = [];
					}
					tdeleteMarkers();
					// Adds a marker to the mapV and push to the array.
					function taddMarker() {
						int_marker = new google.maps.Marker({
							position: myLatLng,
							map: mapV,
							icon: icon//,
							//optimized: false
						});
						tmarkers.push(int_marker);
						mapV.panTo(myLatLng);
					}
					taddMarker();
					//transportInfoWindow.setContent("<span style='color:#000;'>"+'Transport: '+transport_name+'<br>Address: '+current_location+"</span>");
					//transportInfoWindow.open(mapV, int_marker);
					google.maps.event.addListener(int_marker, 'click', function() {
						//transportInfoWindow.setContent("<span style='color:#000;'>"+'Transport: '+transport_name+'<br>Address: '+current_location+"</span>");
						//transportInfoWindow.open(mapV,int_marker);
					});
				}
			}
		});
		//dataref end
		//agent for integrated threat map is counting
		if(all_data.length < 1){
			//console.log('no agent found');
			//return;
		}else{
			var adataRef = firebase.database().ref().child('location');
			adataRef.orderByChild('user_access_code').on("value",function(snap){
				function setMapOnAll(mapV) {
					for (var j = 0; j < markers.length; j++) {
						markers[j].setMap(mapV);
					}
				}
				//Removes the markers from the map, but keeps them in the array.
				function clearMarkers() {
					setMapOnAll(null);
				}
				//Deletes all markers in the array by removing references to them.
				function deleteMarkers(){
					clearMarkers();
					markers = [];
				}
				deleteMarkers();
				snap.forEach(function(childSnap){
					var childData = childSnap.val();
					var agent, i;
					for(i = 0; i < all_data.length; i++){
						var user_access_code = all_data[i]['user_access_code'];
						if(childData['user_access_code'] == user_access_code){
							var alat = parseFloat(childData['lat']);
							var alng = parseFloat(childData['lng']);
							var acurrent_location = childData['location_now'];
							//aicon = '../images/agent.png';
							var amyLatLng = new google.maps.LatLng(alat,alng);
							agent = new google.maps.Marker({
								position: amyLatLng,
								map: mapV,
								icon: icons[iconCounter]//,
								//optimized: true
							});
							markers.push(agent);
							google.maps.event.addListener(agent, 'click',(function(agent, i){
								return function(){
									var user_name = all_data[i]['user_name'];
									//infoWindowIntMapOff.setContent("<span style='color:#000'>"+'Agent: '+user_name+'<br>Address: '+acurrent_location+"</span>");
									//infoWindowIntMapOff.open(mapV,agent);
								}
							})(agent, i));
						}
						iconCounter++;
						// We only have a limited number of possible icon colors, so we may have to restart the counter
						if(iconCounter >= iconsLength){
							iconCounter = 0;
						}
					}
				});
			});
		}*/
	//}
}
google.maps.event.addDomListener(window, 'load', intLiveMap);

//combine map id
/*function eventIntelligentIntegrated(custom_id){
	$(jv_tu_allfeed).each(function(){
		if(this.alert_detail_id == custom_id){
			//console.log(this.alert_detail_id +', '+ custom_id);
			var media_status = "";
			$(".cuser-status").html(this.user_name+' (Transport)');
			$(".cuser-location").html(this.location_now);
			$(".cuser-tds").html(this.alert_datetime);
			$(".cuser-speed").html(this.alert_speed);
			$(".cuser-elevation").html(this.elevation+"ft");
			$(".cuser-direction").html(this.direction);
			//$(".cuser-level").html(this.level);
			//$(".cuser-battery-level").html(this.alert_battery_level);
			$(".cuser-event").html(this.events);
			//$(".cuser-ip").html(this.ip_address);
			$(".cuser-lat").html(this.lat);
			$(".cuser-lng").html(this.lng);
			if(this.image != null && this.audio != null && this.video != null){
				media_status = 'Image, Audio & Video';
			}
			else if(this.image != null && this.audio != null){
				media_status = 'Image & Audio';
			}
			else if(this.image != null && this.video != null){
				media_status = 'Image & Video';
			}
			else if(this.image != null){
				media_status = 'Image';
			}
			else if(this.audio != null){
				media_status = 'Audio';
			}
			else if(this.video != null){
				media_status = ' Video ';
			}
			$(".cuser-media-status").html(media_status);
			$("#location_now").html("Address: <span>"+this.location_now+"</span>, TDS: <span>"+this.alert_datetime+"</span>, Speed: <span>"+this.alert_speed+"</span>, Elevation: <span>"+this.elevation+"ft</span>, Direction: <span>"+this.direction+"</span>");
		}
	});
}*/

/*function eventIntelligentIntegratedAgent(custom_id){
	$(all_data).each(function(){
		if(this.alert_detail_id == custom_id){
			//console.log(this.alert_detail_id +', '+ custom_id);
			var media_status = "";
			$(".cuser-status").html(this.user_name+' (Agent)');
			$(".cuser-location").html(this.location_now);
			$(".cuser-tds").html(this.alert_datetime);
			$(".cuser-speed").html(this.alert_speed);
			$(".cuser-elevation").html(this.elevation+"ft");
			$(".cuser-direction").html(this.direction);
			//$(".cuser-level").html(this.level);
			//$(".cuser-battery-level").html(this.alert_battery_level);
			$(".cuser-event").html(this.events);
			//$(".cuser-ip").html(this.ip_address);
			$(".cuser-lat").html(this.lat);
			$(".cuser-lng").html(this.lng);
			if(this.image != null && this.audio != null && this.video != null){
				media_status = 'Image, Audio & Video';
			}
			else if(this.image != null && this.audio != null){
				media_status = 'Image & Audio';
			}
			else if(this.image != null && this.video != null){
				media_status = 'Image & Video';
			}
			else if(this.image != null){
				media_status = 'Image';
			}
			else if(this.audio != null){
				media_status = 'Audio';
			}
			else if(this.video != null){
				media_status = ' Video ';
			}
			$(".cuser-media-status").html(media_status);
			$("#location_now").html("Address: <span>"+this.location_now+"</span>, TDS: <span>"+this.alert_datetime+"</span>, Speed: <span>"+this.alert_speed+"</span>, Elevation: <span>"+this.elevation+"ft</span>, Direction: <span>"+this.direction+"</span>");
		}
	});
}*/
</script>