// JavaScript Document
function buserdatasync(){
	//console.log('a');
	if(DATA_REFRESH_ON){
		//check again after 1 sec
		setTimeout(function(){
			buserdatasync();
		}, DATA_REFRESH_FREQUENCY);
		return false;
	}
	//lest begin the data refresh process
	DATA_REFRESH_ON = true;
	var media_path = "../media/";
	var loadMorePhotoAgent = true;
	//var buserdata = {action:"buserfeeds", GL_BUSER_ID: GLOBAL_BUSER_ID, buserEventID: GLOBAL_BUSER_EVENT};
	var buserdata = {action:"buserfeeds", GL_BUSER_ID: GLOBAL_BUSER_ID};//, buserEvent: GLOBAL_BUSER_EVENT};
	$.ajax({
	type: "POST",
	url: "bu_action.php",
	data: buserdata,
	//dataType: "json",
		success: function(response){
			//console.log(GLOBAL_BUSER_ID);
			//console.log(GLOBAL_BUSER_ID);
			//new user sync
			var new_buser = [];
			var new_buser_index = 0;
			if(response.buserList.length > 0){
				if(!jv_busers && jv_busers.length == 0){
					new_buser = response.buserList;
				}else{
					$(response.buserList).each(function(){
						var buserList_feed = this;
						var found = false;
						$(jv_busers).each(function(){
							//if(this.alert_detail_id == buserList_feed.alert_detail_id)
							if(this.user_id == buserList_feed.user_id){
								found = true;
								//console.log('buserList ' + buserList_feed.user_id);
								return false;
							}
						});
						if(found == false){
							//new buserList
							new_buser[new_buser_index] = buserList_feed;
							//console.log('New User ' + buserList_feed.user_id);
							new_buser_index++;
						}
					});
				}
				if(new_buser.length > 0){
					//we have new set of buserList feed, add them to the top of buserList list
					var new_buserList_list_html = "";
					$(new_buser).each(function(){
						if(this.user_id == GLOBAL_BUSER_ID){
							//no need to add this buserList, since the selected buser has probably changed
							return false; //just break out since the buserList feed belong to other buser anyway
							//console.log(this.user_id);
						}
						GLOBAL_BUSER_ID = GLOBAL_BUSER_ID;
						new_buserList_list_html += "<option value='"+this.user_id+"' buser_sel_event='"+this.events+"' selected>"+this.user_name+"</option>";
					});
					//agentRemoteCheck();
					if($("#buser option").length > 0){
						$("#buser").prepend(new_buserList_list_html);
						$("#buser option:first-child").trigger("change");
						/*buserChange = true;
						if(buserChange){
							$("#buserDataFrequency").show();
							$("#buserDataFrequencyMsg").hide();
							$("#busermap").show();
							$("#busermapmsg").hide();
							buserChange = false;
						}*/
					}
					else{
						$("#buser").html("");
						$("#buser").html(new_buserList_list_html);
					}
				}
				//now reset the old audio feed
				jv_busers = response.buserList;
			}
			//buser event synchronization
			var new_events = [];
			var new_event_index = 0;
			if(response.bu_events.length > 0){
				if(!jv_bu_event && jv_bu_event.length == 0){
					new_events = response.bu_events;
				}else{
					$(response.bu_events).each(function(){
						var event_feed = this;
						var found = false;						
						$(jv_bu_event).each(function(){
							//if(this.alert_detail_id == event_feed.alert_detail_id)
							if(this.events == event_feed.events && this.user_id == GLOBAL_BUSER_ID){
								found = true;
								//console.log('old event ' + event_feed.events);
								return false;								
							}
						});
						if(found == false){
							//new event
							new_events[new_event_index] = event_feed;
							console.log('New event ' + event_feed.events);
							new_event_index++;
						}
					});
				}
				
				if(new_events.length > 0){
					//we have new set of event feed, add them to the top of event list
					var new_event_list_html = "";
					$(new_events).each(function(){
						if(this.user_id != GLOBAL_BUSER_ID){
							//no need to add this event, since the selected tuser has probably changed
							return false; //just break out since the event feed belong to other tuser anyway
							//console.log(this.user_id);
						}
						
						new_event_list_html += "<li type='buevent' buadt_id='"+ this.alert_detail_id+"' buser_id='"+ this.user_id +"' buevent_id='"+ this.events +"'>"+"Event - "+this.events+"</li>";
						//console.log(new_event_list_html);
						var ActiveItem = $(this);
						$("li[type='buevent']").removeClass("activeClass");
						//ActiveItem.addClass("activeClass");
					});
					//console.log(new_event_list_html);
					if($("#bu_event li").length > 0){
						$("#bu_event").prepend(new_event_list_html);
						$("#bu_event li:first-child").trigger("click");
						//$('#loadMoreBuserEvent').trigger("click");
						//$('#showLessBuserEvent').trigger("click");
					}
					else{
						$("#bu_event").html("");
						$("#bu_event").html(new_event_list_html);
						//$("#bu_event li:first-child").trigger("click");
						//load more section (buser event)
						/*buserEvent_size_li = $("#bu_event li").size();
						buserEvent_x = 5;
						$('#loadMoreBuserEvent').show();
						$('#bu_event li:lt('+buserEvent_x+')').show();
						$(document).on('click','#loadMoreBuserEvent',function(){
							buserEvent_x = (buserEvent_x+5 <= buserEvent_size_li) ? buserEvent_x+5 : buserEvent_size_li;
							$('#bu_event li:lt('+buserEvent_x+')').show();
						});*/
					}	
				}
				//now reset the old event feed
				jv_bu_event = response.bu_events;
			}
			
			//video feed synchronization
			var off_new_videos = [];
			var off_new_video_index = 0;
			if(response.off_video.length > 0){
				if(!jv_bu_video && jv_bu_video.length == 0){
					off_new_videos = response.off_video;
				}else{
					$(response.off_video).each(function(){
						var video_feed = this;
						var found = false;
						$(jv_bu_video).each(function(){
							if(this.alert_detail_id == video_feed.alert_detail_id){
								found = true;
								//console.log('off_video ' + video_feed.alert_detail_id);
								return false;
							}
						});
						if(found == false){
							//new off_video
							off_new_videos[off_new_video_index] = video_feed;
							//console.log('New Video ' + video_feed.alert_detail_id);
							off_new_video_index++;
						}
					});
				}
				if(off_new_videos.length > 0){
					//we have new set of off_video feed, add them to the top of off_video list
					var new_video_list_html = "";
					$(off_new_videos).each(function(){
						if(this.user_id != GLOBAL_BUSER_ID){
							//no need to add this off_video, since the selected tuser has probably changed
							return false; //just break out since the off_video feed belong to other tuser anyway
							//console.log(this.user_id);
						}
						//new_video_list_html += "<li type='buvideo' buvideo_id='"+this.alert_detail_id+"'>"+this.alert_datetime+"</li>";
						//console.log(this.alert_detail_id);
						//var ActiveItem = $(this);
						//$("li[type='buvideo']").removeClass("activeClass");
						//ActiveItem.addClass("activeClass");
						if(this.events != GLOBAL_BUSER_EVENT){
							//console.log('n s v: '+this.events+', '+GLOBAL_TUSER_EVENT);
						}else{
							//$("#officer_video_feed").html("");
							$("#officer_video").show();
							$("#officer_video").attr("src", this.filePath);//media_path+this.user_id+'/video/'+this.video);
							$("#officer_video").attr("autoplay",true);
							//$("#officer_video").trigger("play");
							//$("#officer_video").attr("controls",false);
							//console.log("A sync: video playing");
						}
					});
					/*if($("#officer_video_feed li").length > 0){
						$("#officer_video_feed").prepend(new_video_list_html);
						$("li[type='buvideo']:first-child").addClass("activeClass");
						//$('#loadMoreBuserVideo').trigger("click");
					}else{
						$("#officer_video_feed").html("");
						$("#officer_video_feed").html(new_video_list_html);
					}*/
				}
				//now reset the old off_video feed
				jv_bu_video = response.off_video;
			}
			
		/*DATA_REFRESH_ON = false;
		setTimeout(function(){
			buserdatasync();
		}, DATA_REFRESH_FREQUENCY);*/
	  },
	dataType: "json"
	});
}
/*setTimeout(function(){
	buserdatasync();
}, DATA_REFRESH_FREQUENCY);*/