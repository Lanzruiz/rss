<script>
//cctv/ bodycam/ satellite section
jQuery(document).on("click","#cctvPlay",function(){
	jQuery("#ccTvSection").trigger("play");
	jQuery("#bodyCamSection").trigger("pause");
	jQuery("#stltSection").trigger("pause");
});
jQuery(document).on("click","#bodyCamPlay",function(){
	jQuery("#bodyCamSection").trigger("play");
	jQuery("#ccTvSection").trigger("pause");
	jQuery("#stltSection").trigger("pause");
});
jQuery(document).on("click","#satellitePlay",function(){
	jQuery("#stltSection").trigger("play");
	jQuery("#bodyCamSection").trigger("pause");
	jQuery("#ccTvSection").trigger("pause");
});

jQuery(document).on("click","#cctv",function(){
	jQuery("#bodyCamSection").trigger("pause");
	jQuery("#stltSection").trigger("pause");
});
jQuery(document).on("click","#bd_cam",function(){
	jQuery("#stltSection").trigger("pause");
	jQuery("#ccTvSection").trigger("pause");
});
jQuery(document).on("click","#stlt",function(){
	jQuery("#bodyCamSection").trigger("pause");
	jQuery("#ccTvSection").trigger("pause");
});
</script>
<div class="col-lg-12 all-background-opacity">
	<div class="col-lg-5">
    	<ul class="nav nav-tabs headerText nav-tabs-cctvSection" role="tablist">
        <!--<ul class="nav nav-tabs headerText nav-tabs-cctvSection" role="tablist">-->
            <li id="cctv" role="presentation" class="active"><a href="#cc_tv" aria-controls="cc_tv" role="tab" data-toggle="tab">Drone-1</a></li>
            <li id="bd_cam" role="presentation"><a href="#body_cam" role="tab" aria-controls="body_cam" data-toggle="tab">Drone-2</a></li>
            <li id="stlt" role="presentation"><a href="#satellite" role="tab" aria-controls="satellite" data-toggle="tab">Drone-3</a></li>
            <div style="clear: both;"></div>
        </ul>
        <!--<div class="col-lg-12 tab-content cctv_content">-->
        <div class="col-lg-12 tab-content">
            <div role="tabpanel" class="tab-pane active" id="cc_tv">
                <ul class="col-lg-3 cctv_section_feed responsiveVersion-3" id="cctv_feed">
					<li id="cctvPlay">Drone List-1</li>
                </ul>
                <div class="col-lg-9 video-player-cc border-right-10px responsiveVersion-9">
                    <video id="ccTvSection" poster="{{url('public/assets/media/cctv/cctv.jpg')}}" controls><source src="{{url('public/assets/media/cctv/cctv-vdo-1.mp4')}}" type="video/mp4"></video>
                </div>
            </div> 
            <div role="tabpanel" class="tab-pane" id="body_cam">
                <ul class="col-lg-3 cctv_section_feed responsiveVersion-3">
					<li id="bodyCamPlay">Drone-2 List-1</li>
                </ul>
                <div class="col-lg-9 video-player-cc border-right-10px responsiveVersion-9">
                    <video id="bodyCamSection" poster="{{url('public/assets/media/bodycam/bodyCamOne.png')}}" controls><source src="{{url('public/assets/media/bodycam/bodyCamOne.mp4')}}" type="video/mp4"></video>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="satellite">
                <ul class="col-lg-3 cctv_section_feed responsiveVersion-3">
					<li id="satellitePlay">Drone-3 List-1</li>
                </ul>
                <div class="col-lg-9 video-player-cc border-right-10px responsiveVersion-9">
                    <video id="stltSection" poster="{{url('public/assets/media/satellite/satellite.png')}}" controls><source src="{{url('public/assets/media/satellite/satellite.mov')}}" type="video/mp4"></video>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <p>Integrated Threat Map<a id="itmap_expand_mbl" href="../live/" target="_blank" style="background:#000; color:#FFF; opacity:0.6; font-size:20px; padding:10px; text-decoration:none">Expand <i class="fa fa-expand"></i></a>
       <!-- <section class="recordrtc">-->
            <span id="recording-media" value="record-screen"></span>
            <span id="media-container-format" value="WebM"></span>
            <!--<select class="recording-media">
                <option value="record-video">Video</option>
                <option value="record-audio">Audio</option>
                <option value="record-screen">Screen</option>
            </select>-->
            <!--<select class="media-container-format">
                <option>WebM</option>
                <option disabled>Mp4</option>
                <option disabled>WAV</option>
                <option disabled>Ogg</option>
                <option>Gif</option>
            </select>-->
            <!--<button id="StartRecording" class="btn btn-primary btn-sm">Start Recording</button>-->
            <!--<div style="text-align: center; display: none;" id="uploadDiv">
                <button id="save-to-disk">Save To Disk</button>
                <button id="open-new-tab">Open New Tab</button>-->
                <!--<button id="upload-to-server" class="btn btn-primary btn-sm">Upload To Server</button>-->
            <!--</div>-->
           <!-- <video controls muted style="display:none"></video>-->
        <!--</section>-->
        </p>
        <div id="map_integ_threat"></div>
    </div>
    <!--<div class="col-lg-2">
        <p>Event Intelligence - Integrated</p>
        <div class="tu-last-frequency">
        	&nbsp;&nbsp;User:&nbsp;&nbsp;<span class="cuser-status"></span><hr>
            &nbsp;&nbsp;Location:&nbsp;&nbsp;<span class="cuser-location"></span><hr>
            &nbsp;&nbsp;Event:&nbsp;&nbsp;<span class="cuser-event"></span><hr>
            &nbsp;&nbsp;TDS:&nbsp;&nbsp;<span class="cuser-tds"></span><hr>
            &nbsp;&nbsp;Speed:&nbsp;&nbsp;<span class="cuser-speed"></span><hr>
            &nbsp;&nbsp;Elevation:&nbsp;&nbsp;<span class="cuser-elevation"></span><hr>
            &nbsp;&nbsp;Direction:&nbsp;&nbsp;<span class="cuser-direction"></span><hr>
            &nbsp;&nbsp;Latitude:&nbsp;&nbsp;<span class="cuser-lat"></span><hr>
            &nbsp;&nbsp;Longitude:&nbsp;&nbsp;<span class="cuser-lng"></span><hr>
            &nbsp;&nbsp;Media Status:&nbsp;&nbsp;<span class="cuser-media-status"></span>
        </div>                
    </div>-->
</div>