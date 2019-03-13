<script>
function alertStatusCheck(){
	var tuserdata = {action:"tu_alert_status", GL_TUSER_ID: GLOBAL_TUSER_ID, GL_TU_EVENT_ID: GLOBAL_TUSER_EVENT};
	$.ajax({
	  type: "POST",
	 url: "actionTrAllFeed_AlertStatus.php",
	 data: tuserdata,
	 success: function(response){
		//jv_tu_alert_status = response.alert_status;
		//TrOnlineStatus = jv_tu_alert_status[0]['user_remote_activate'];		
		var temp_jv_tu_allfeed = jv_tu_allfeed;
		jv_tu_allfeed = response.all_feeds;
		//console.log(jv_tu_allfeed);
		if(tuserEventChange){
			//jv_tu_allfeed = response.all_feeds;
			if(GLOBAL_TUSER_EVENT != jv_tu_allfeed[0]['events']){
				//console.log('not equal: '+GLOBAL_TUSER_EVENT+', '+jv_tu_allfeed[0]['events']);
			}else{
				//console.log(jv_tu_allfeed);
				//jv_tu_allfeed = response.all_feeds;
				//GLOBAL_TUSER_ACCESS_CODE = jv_tu_allfeed[0]['user_code'];
				GLOBAL_TUSER_LAT = jv_tu_allfeed[0]['lat'];
				GLOBAL_TUSER_LNG = jv_tu_allfeed[0]['lng'];
				initialize();
				intLiveMap();
				//tuserAllFeed(jv_tu_allfeed[0]["alert_detail_id"]);
				//eventIntelligentIntegrated(jv_tu_allfeed[0]["alert_detail_id"]);
				tuserEventChange = false;
			}
		}
		
		//new points
		var new_points = [];
		var i = 0;
		if(response.all_feeds.length > 0){
			if(!jv_tu_allfeed && jv_tu_allfeed.length == 0){
				new_points = response.all_feeds;
			}else{
				$(jv_tu_allfeed).each(function(){
					var found = false;
					var myAlertObj = this;
					$(temp_jv_tu_allfeed).each(function(){
					//$(response.all_feeds).each(function(){
						if(this.alert_detail_id == myAlertObj.alert_detail_id)
						{
							found = true;
							//console.log(myAlertObj.alert_detail_id);
							return false;
						}
					});
					if(found == false){
						new_points[i] = myAlertObj;
						//console.log('new point: ' + myAlertObj.alert_detail_id);
						i++;	
					}
				});
			}
			if(new_points.length > 0){		
				$(new_points).each(function(){
					if(this.user_id != GLOBAL_TUSER_ID){
						return false;
					}
				});	
				if(map){
					//jv_tu_allfeed = response.all_feeds;
					//add points
					addMarkerToTuserMap(map, new_points);
					//tuserAllFeed(new_points[new_points.length - 1]['alert_detail_id']);
					//console.log(new_points[new_points.length - 1]['alert_detail_id']);
					//select the last point
					//selectMedia(new_points[new_points.length - 1]);
				}	
			}
			jv_tu_allfeed = response.all_feeds;			
		}
		/*if(map){
			//polyLine 
			flightPlanCoordinates = jv_tu_allfeed;
			flightPath = new google.maps.Polyline({
			  path: flightPlanCoordinates,
			  geodesic: true,
			  strokeColor: '#FF0000',
			  strokeOpacity: 1.0,
			  strokeWeight: 2
			});
			flightPath.setMap(map);
		}*/
		
		
		setTimeout(function(){
			alertStatusCheck();
		}, 1000);
	  },
	dataType: "json"
	});
}
setTimeout(function(){
	alertStatusCheck();
}, 1000);
</script>