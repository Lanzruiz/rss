// JavaScript Document
function tuserdatasync(){
	if(DATA_REFRESH_ON){
		//check again after 1 sec
		setTimeout(function(){
			tuserdatasync();
		}, DATA_REFRESH_FREQUENCY);
		return false;
	}
	//lest begin the data refresh process
	DATA_REFRESH_ON = true;
	var media_path = "../media/";
	var loadMorePhoto = true;
	//var tuserdata = {action:"tuserfeeds", GL_TUSER_ID: GLOBAL_TUSER_ID, GL_TU_EVENT_ID: GLOBAL_TUSER_EVENT};
	var tuserdata = {action:"tuserfeeds", GL_TUSER_ID: GLOBAL_TUSER_ID};
	$.ajax({
	type: "POST",
	url: "action.php",
	data: tuserdata,
	//dataType: "json",
		success: function(response){
			//new user sync
			var new_tuser = [];
			var new_tuser_index = 0;
			if(response.tuserList.length > 0){
				//console.log('helow');
				if(!jv_tusers && jv_tusers.length == 0){
					new_tuser = response.tuserList;
				}else{
					$(response.tuserList).each(function(){
						var tuserList_feed = this;
						var found = false;
						$(jv_tusers).each(function(){
							//if(this.alert_detail_id == tuserList_feed.alert_detail_id)
							if(this.user_id == tuserList_feed.user_id){
								found = true;
								//console.log('Old user: ' + tuserList_feed.user_id);
								return false;
							}
						});
						if(found == false){
							//new tuserList
							new_tuser[new_tuser_index] = tuserList_feed;
							//console.log('New PID ' + tuserList_feed.user_id);
							new_tuser_index++;
						}
					});
				}
				if(new_tuser.length > 0){
					//we have new set of tuserList feed, add them to the top of tuserList list
					var new_tuserList_list_html = "";
					$(new_tuser).each(function(){
						if(this.user_id == GLOBAL_TUSER_ID){
							//no need to add this tuserList, since the selected tuser has probably changed
							return false; //just break out since the tuserList feed belong to other tuser anyway
						}
						GLOBAL_TUSER_ID = this.user_id;
						new_tuserList_list_html += "<option value='"+this.user_id+"' tuser_sel_event='"+this.events+"' selected>"+this.user_name+"</option>";
					});
					GLOBAL_TUSER_ID = GLOBAL_TUSER_ID;
					if($("#tuser option").length > 0){
						//$("#tuser").prepend(new_tuserList_list_html);
						//$("#tuser option:first-child").trigger("change");
						
						$("#text-frame").fadeIn();
						$("#text-overlay").fadeIn();
						$("#text-frame h1").html('New Transport found, please wait.....');
						setTimeout(function(){
							//$("#tuser").prepend(new_tuserList_list_html);
							setTimeout(function(){
								window.location = './';
							},1000);
						}, 3000);
					}else{
						$("#tuser").html("");
						$("#tuser").html(new_tuserList_list_html);
					}
				}
				//now reset the old audio feed
				jv_tusers = response.tuserList;
			}
			//tuser event synchronization
			var new_events = [];
			var new_event_index = 0;
			if(response.tu_events.length > 0){
				if(!jv_tu_event && jv_tu_event.length == 0){
					new_events = response.tu_events;
				}else{
					$(response.tu_events).each(function(){
						var event_feed = this;
						var found = false;
						$(jv_tu_event).each(function(){
							//if(this.alert_detail_id == event_feed.alert_detail_id)
							if(this.events == event_feed.events && this.user_id == GLOBAL_TUSER_ID){
								found = true;
								//console.log('old event ' + event_feed.events);
								return false;
							}
						});
						if(found == false){
							//new event
							new_events[new_event_index] = event_feed;
							//console.log('new event ' + event_feed.events);
							new_event_index++;
						}
					});
				}
				
				if(new_events.length > 0){
					//we have new set of event feed, add them to the top of event list
					var new_event_list_html = "";
					$(new_events).each(function(){
						if(this.user_id != GLOBAL_TUSER_ID){
							//no need to add this event, since the selected tuser has probably changed
							return false; //just break out since the event feed belong to other tuser anyway
							//console.log(this.user_id);
						}
						GLOBAL_TUSER_EVENT = this.events;
						new_event_list_html += "<li type='uevent' uevent_id='"+ this.events +"'>"+"Event - "+this.events+"</li>";
						var ActiveItem = $(this);
						$("li[type='uevent']").removeClass("activeClass");
						//ActiveItem.addClass("activeClass");
					});
					GLOBAL_TUSER_EVENT = GLOBAL_TUSER_EVENT;
					//console.log(GLOBAL_TUSER_EVENT);
					alertStatusChecks();
					if($("#tu_event li").length > 0){
						$("#tu_event").prepend(new_event_list_html);
						//$("#tu_event li:first-child").trigger("click");
						//$('#loadMoreTuserEvent').trigger("click");
					}else{
						$("#tu_event").html("");
						$("#tu_event").html(new_event_list_html);
						/*$("#tu_event li:first-child").trigger("click");
						tuserEvent_size_li = $("#tu_event li").size();
						tuserEvent_x = 5;
						$('#loadMoreTuserEvent').show();
						$('#tu_event li:lt('+tuserEvent_x+')').show();
						$(document).on('click','#loadMoreTuserEvent',function(){
							tuserEvent_x = (tuserEvent_x+5 <= tuserEvent_size_li) ? tuserEvent_x+5 : tuserEvent_size_li;
							$('#tu_event li:lt('+tuserEvent_x+')').show();
						});*/
					}	
				}
				//now reset the old event feed
				jv_tu_event = response.tu_events;
			}
			
			//video feed synchronization
			var new_videos = [];
			var new_video_index = 0;
			if(response.video.length > 0){
				if(!jv_tu_video && jv_tu_video.length == 0){
					new_videos = response.video;
				}else{
					$(response.video).each(function(){
						var video_feed = this;
						var found = false;
						$(jv_tu_video).each(function(){
							if(this.alert_detail_id == video_feed.alert_detail_id){
								found = true;
								//console.log('video ' + video_feed.alert_detail_id);
								return false;
							}
						});
						if(found == false){
							//new video
							new_videos[new_video_index] = video_feed;
							new_video_index++;
						}
					});
				}
				if(new_videos.length > 0){
					//we have new set of video feed, add them to the top of video list
					var new_video_list_html = "";
					$(new_videos).each(function(){
						if(this.user_id != GLOBAL_TUSER_ID){
							//no need to add this video, since the selected tuser has probably changed
							return false; //just break out since the video feed belong to other tuser anyway
							//console.log(this.user_id);
						}
						
						if(this.events != GLOBAL_TUSER_EVENT){
							//console.log('n s v: '+this.events+', '+GLOBAL_TUSER_EVENT);
						}else{
							new_video_list_html += "<li type='tuvideo' tuvideo_id='"+this.alert_detail_id+"'>"+this.alert_datetime+"</li>";
							//console.log('s v: '+this.events+', '+GLOBAL_TUSER_EVENT);
							//$("#video_feed").html("");
							$("#video").show(); 
							$("#video").attr("src", this.filePath);//media_path+this.user_id+'/video/'+this.video);
							//$("#video").attr("autoplay",true);
							//$("#video").attr("controls",false);
							//console.log('t v sync: '+this.events+', '+GLOBAL_TUSER_EVENT);
						}
						/*$("#video").attr("src", media_path+this.user_id+'/video/'+this.video);
						$("#video").attr("autoplay",true);
						$("#video").attr("controls",false);
						console.log("T sync: video playing");*/
					});
					if($("#video_feed li").length > 0){
						$("#video_feed").prepend(new_video_list_html);
						$("li[type='tuvideo']:first-child").trigger("click");
						//$('#loadMoreTuserVideo').trigger("click");
					}
					else{
						$("#video_feed").html("");
						$("#video_feed").html(new_video_list_html);
					}
				}
				//now reset the old video feed
				jv_tu_video = response.video;
			}

		DATA_REFRESH_ON = false;
		setTimeout(function(){
			tuserdatasync();
		}, DATA_REFRESH_FREQUENCY);
	  },
	dataType: "json"
	});
}
setTimeout(function(){
	tuserdatasync();
}, DATA_REFRESH_FREQUENCY);