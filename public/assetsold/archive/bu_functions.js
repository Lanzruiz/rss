//Officer's Section
function jf_busers(){
	var busers,i;
	for(i = 0; i < jv_busers.length; i++){
		busers = "<option data-accesscode='"+jv_busers[i]['user_code']+"' value='"+jv_busers[i]['user_id']+"' buser_sel_event='"+jv_busers[i]['events']+"'>"+jv_busers[i]['user_name']+"</option>";
		document.write(busers);
	}
}
function jf_bu_events(){
	var buevent,i;
	for(i = 0; i < jv_bu_event.length; i++){
		buevent = "<li data-accesscode='"+jv_busers[i]['user_code']+"' type='buevent' buadt_id='"+ jv_bu_event[i]['alert_detail_id'] +"' buevent_id='"+ jv_bu_event[i]['events'] +"'>"+"Event - "+jv_bu_event[i]['events']+"</li>";
		document.write(buevent);
	}
}

function jf_bu_videos(){
	var buvideo,i;
	if(jv_bu_video==''){
		buvideo = '<p class="loading">No video Found on '+GLOBAL_BUSER_NAME+"</p>";
		document.write(buvideo);
	}else{
		for(i = 0; i < jv_bu_video.length; i++){
			buvideo = "<li data-accesscode='"+jv_busers[i]['user_code']+"' type='buvideo' buvideo_id='"+ jv_bu_video[i]['alert_detail_id'] +"'>"+jv_bu_video[i]['alert_datetime']+"</li>";
			document.write(buvideo);
		}
	}
}
