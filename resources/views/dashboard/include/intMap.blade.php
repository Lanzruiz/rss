<style>
.noLiveTrackingMessage{text-align:center; padding:15px 0; font-size:24px}
</style>

<script>
var int_map = null;
var int_map_marker = null;
var aint_map_marker = null;
var int_map_selected_marker = null;
var int_map_agent_marker = null;
var int_map_load = true;
var aint_map_load = true;
var agentAccessCode = '';
var resetMap = false;
var transportMarkers = [];
var bounds = null;
var manualZoom = false;


function intLiveMap(){

	var data = firebase.database().ref().child('user_location').child(transportAccessCode);
	data.on("value",function(snap){

		if (snap.val() == null){

			//if(agentAccessCode == "") {
				resetMapLiveTracking();
        int_map_load = false;
				bounds = new google.maps.LatLngBounds();
				clearMarkerByAccessCode(transportAccessCode);
			//}


		} else {

			resetMap = true;
			var SnapValue = snap.val();

			var center = new google.maps.LatLng(SnapValue['lat'],SnapValue['lon']);

			if(int_map_load == false) {
				//console.log("One 1");
				var latLang123 = new google.maps.LatLng(SnapValue['lat'],SnapValue['lon']);

        if(int_map == null) {
          initializeLiveMapTracking(latLang123);
        }

        // if(int_map_selected_marker && int_map_selected_marker.setMap) {
        //   int_map_selected_marker.setMap(null);
        // }

        var marker2 = new google.maps.Marker({
					position:latLang123,
					map: int_map,
					optimized: false,
					icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
				  });

          transportMarkers.push(marker2);
					if(bounds == null) {
						//console.log("bounds 101");
						 bounds = new google.maps.LatLngBounds();
					}
					bounds.extend(marker2.position);

				int_map_selected_marker = marker2;
				int_map.panTo(latLang123);
        int_map_load = true;


				window['accesscode_'+transportAccessCode] = marker2
				//console.log(transportAccessCode);
				//console.log(window.transportAccessCode);
			} else {
				//console.log("Two 2");



        // if(int_map_selected_marker && int_map_selected_marker.setMap) {
				// 	int_map_selected_marker.setMap(null);
				// }


				//initializeLiveMapTracking(center);
				clearMarkerByAccessCode(transportAccessCode);
				int_map_marker = new google.maps.Marker({
					//position: center,
					map: int_map,
					optimized: false,
					icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
				});


				int_map_marker.setPosition(center);
				if(bounds == null) {
					bounds = new google.maps.LatLngBounds();
				}
				bounds.extend(int_map_marker.position);
				int_map_selected_marker = int_map_marker;
				//int_map_load = false;

				window['accesscode_'+transportAccessCode] = int_map_marker

			}

			centerMapBasedOnTransport();
		}
	});
	//agent part
  console.log("intMap agent: " + agentAccessCode);
	if(agentAccessCode != '') {
		var aInt_map_agent_marker = null;
		var aData = firebase.database().ref().child('user_location').child(agentAccessCode);
		aData.on("value",function(snap){
			if (snap.val() == null){

				if(resetMap == false) {
					resetMapLiveTracking()
				}
				bounds = new google.maps.LatLngBounds();
				clearMarkerByAccessCode(agentAccessCode);
			} else {

				var aSnapValue = snap.val();
				var aCenter = new google.maps.LatLng(aSnapValue['lat'],aSnapValue['lon']);

				if(resetMap == false) {
                   //initialize the map

                   resetMap = true;
                   int_map_load = true;
                   initializeLiveMapTracking(aCenter);
				}

				// if(aInt_map_agent_marker && aInt_map_agent_marker.setMap) {
				// 	aInt_map_agent_marker.setMap(null);
				// }

				clearMarkerByAccessCode(agentAccessCode);

				var alatLang123 = new google.maps.LatLng(aSnapValue['lat'],aSnapValue['lon']);
				var amarker2 = new google.maps.Marker({
					position: alatLang123,
					map: int_map,
					icon: '{{url('public/assets/images/agents.png')}}'
				  });
				aInt_map_agent_marker = amarker2;
				if(bounds == null) {
					bounds = new google.maps.LatLngBounds();
				}
				bounds.extend(amarker2.position);
				window['accesscode_'+agentAccessCode] = amarker2

				// if(transportAccessCode == "") {
				// 	 centerMapBasedOnTransport();
				// }

			}
		});
	}

}


function centerMapBasedOnTransport() {
	if(int_map == null) {
		 resetMapLiveTracking()
	}
	//console.log("manualZoom : " + manualZoom);
	if (manualZoom == false) {
		int_map.fitBounds(bounds);
  }
}

function initializeLiveMapTracking(center) {


	 int_map = new google.maps.Map(document.getElementById('map_integ_threat'),{
						zoom: 18,
						center: center,
						fullscreenControl: true,
						streetViewControl: true,
						zoomControl: true,
						motionTracking: false,
						mapTypeId: 'hybrid',
						motionTrackingControl: false
					});


	// int_map.addListener('zoom_changed', function() {
	// 	 			 manualZoom = true;
	// 	 			 counter = 0;
	// 				 console.log("manualZoom : " + manualZoom);
	// 	 			 //console.log('start timer');
	// 	 			 //timer= setInterval("stopInterval()", 10000);
	// });

	 bounds = new google.maps.LatLngBounds();
}

function resetMapLiveTracking() {

	defaultZoomBtn();

	var myCenter = new google.maps.LatLng(38.907192, -77.036871);
			var mapOptionsThreat = {
			      center:myCenter,
			      zoom:18,
						mapTypeId: 'hybrid',
						zoomControl: true,
			};
			 int_map = new google.maps.Map(document.getElementById("map_integ_threat"), mapOptionsThreat);
			 int_map.setTilt(45);

			//  int_map.addListener('zoom_changed', function() {
		 // 		 			 manualZoom = true;
		 // 		 			 counter = 0;
		 // 					 console.log("manualZoom : " + manualZoom);
		 // 		 			 //console.log('start timer');
		 // 		 			 //timer= setInterval("stopInterval()", 10000);
			// 	});
}


function clearMarkerByAccessCode(accesscode) {
	//console.log("Function Clear Marker");
	//console.log(accesscode);
	//console.log(window['accesscode_'+accesscode]);
	if(window['accesscode_'+accesscode] && window['accesscode_'+accesscode].setMap) {
		//console.log("Clear Marker");
		window['accesscode_'+accesscode].setMap(null);
	}
}


$(document).on("click","#btnZoom",function(e){
	//console.log("zoom click: " + $(this).val());
	 if($(this).val() == 0) {
			 $(this).val(1);
			 $(this).html('Auto Zoom - On');
			 manualZoom = true;
	 } else {
		 $(this).val(0);
		 $(this).html('Auto Zoom - Off');
		 manualZoom = false;
	 }
		e.preventDefault();
});

function defaultZoomBtn() {
	$("#btnZoom").val(0);
	$("#btnZoom").html('Auto Zoom - Off');
	manualZoom = false;
}





</script>
