<script>
function agentAllFeedCheck(){
	var buserData = {action:"buserAllFeeds", GL_BUSER_ID: GLOBAL_BUSER_ID, buserEventID: GLOBAL_BUSER_EVENT};
	//var buserData = {action:"buserAllFeeds", GL_BUSER_ID: GLOBAL_BUSER_ID};
	$.ajax({
	type: "POST",
	headers: { "Authorization": "{{Session::get('securityToken')}}", "Content-Type": "application/x-www-form-urlencoded" },
	url: "{{url('api/v1/actionAgAllFeed')}}",
	data: buserData,
	success: function(response){
		if(response.message == "Invalid Token Authentication.") {
				console.log("Invalid Token Authentication.");
		} else {

						var temp_jv_bu_allfeed = jv_bu_allfeed;
						jv_bu_allfeed = response.agentAllFeeds;
						//new points
						var officer_new_points = [];
						var i = 0;
						$(jv_bu_allfeed).each(function(){
							var found = false;
							var myAlertObj = this;
							$(temp_jv_bu_allfeed).each(function(){
								if(this.alert_detail_id == myAlertObj.alert_detail_id){
									found = true;
									return false;
								}
							});
							if(found == false){
								officer_new_points[i] = myAlertObj;
								//console.log(myAlertObj.alert_detail_id);
								i++;
							}
						});

						if(officer_new_points.length > 0){
							if(officer_map){
								//add points
								officer_addMarkerToTuserMap(officer_map, officer_new_points[officer_new_points.length - 1]);
								//select the last point
								Officer_Select_Media(officer_new_points[officer_new_points.length - 1]);
							}
						}

						//event and agent change
						if(buserEventChange){
							if(jv_bu_allfeed.length > 0) {
								if(GLOBAL_BUSER_EVENT != jv_bu_allfeed[0]['events']){

								}else{
									//console.log(jv_bu_allfeed[0]['events']+', '+GLOBAL_BUSER_EVENT);
									$("#busermapmsg").hide();
									$("#busermap").show();
									//$("#buserDataFrequencyMsg").hide();
									//$("#buserDataFrequency").show();
									GLOBAL_BUSER_LAT = jv_bu_allfeed[0]['lat'];
									GLOBAL_BUSER_LNG = jv_bu_allfeed[0]['lng'];
									officer_initialize();
									//buserAllFeed(jv_bu_allfeed[0]['alert_detail_id']);
									//console.log(jv_bu_allfeed[0]['alert_detail_id']);
									buserEventChange = false;
								}
							}
						}

						setTimeout(function(){
							agentAllFeedCheck();
						}, DATA_REFRESH_FREQUENCY);
		} //if authentication
	  },
	dataType: "json"
	});
}
setTimeout(function(){
	agentAllFeedCheck();
}, DATA_REFRESH_FREQUENCY);
</script>
