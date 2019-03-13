// JavaScript Document
function jf_tusers(){
	var tusers,i;
	for(i = 0; i < jv_tusers.length; i++){
		tusers = "<option data-accesscode='"+jv_tusers[i]['user_code']+"' value='"+jv_tusers[i]['user_id']+"' tuser_sel_event='"+jv_tusers[i]['events']+"'>"+jv_tusers[i]['user_name']+"</option>";
		document.write(tusers);
	}
}

function jf_tu_events(){
	var tuevent,i;
	for(i = 0; i < jv_tu_event.length; i++){
		//tuevent = "<li type='uevent' adt_id='"+ jv_tu_event[i]['alert_detail_id'] +"' tuser_id='"+ jv_tu_event[i]['user_id'] +"' uevent_id='"+ jv_tu_event[i]['events'] +"'>"+"Event - "+jv_tu_event[i]['events']+"</li>";
		tuevent = "<li type='uevent' data-accesscode='"+jv_tusers[i]['user_code']+"' uevent_id='"+ jv_tu_event[i]['events'] +"'>"+"Event - "+jv_tu_event[i]['events']+"</li>";
		document.write(tuevent);
	}
}

function jf_tu_videos(){
	var tuvideo,i;
	if(jv_tu_video==''){
		tuvideo = '<p class="loading">No video Found on '+GLOBAL_TUSER_NAME+"</p>";
		document.write(tuvideo);
	}else{
		for(i = 0; i < jv_tu_video.length; i++){
			tuvideo = "<li type='tuvideo' data-accesscode='"+jv_tusers[i]['user_code']+"' tuvideo_id='"+ jv_tu_video[i]['alert_detail_id'] +"'>"+jv_tu_video[i]['alert_datetime']+"</li>";
			document.write(tuvideo);
		}
	}
}
