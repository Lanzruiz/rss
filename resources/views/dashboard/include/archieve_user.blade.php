<style>
#tu_event{
	animation: blinker 2s linear infinite;
}
@keyframes blinker {  
  50% { opacity: 0; }
}
</style>
<div class="col-lg-12 all-background-opacity">
    <div class="col-lg-12">
        
        <div style="clear: both;"></div>
        <div class="col-lg-12 responsiveVersion-9">
            <div role="tabpanel" class="col-lg-12 video-player border-right-10px tab-pane" id="tu_video" style="height:250px">
                
                <div class="col-lg-12 all-background-opacity">
    <div class="col-lg-5">
        <ul class="nav nav-tabs headerText" role="tablist">
            <li class="col-lg-3 responsiveVersion-3"><p class="eventText">Archived Event</p></li>            
            <li id="bu_video_click" role="presentation" class="active"><a href="#bu_video" role="tab" aria-controls="bu_video" data-toggle="tab" aria-expanded="true">Video</a></li>
            
            <div class="col-lg-3 select">
                <select class="form-control" id="tuser" name="tuser">
                	  @foreach($transport as $transports)
                            <option value="{{$transports->fldUsersAccessCode}}">{{$transports->fldUsersFullname}}</option>
                      @endforeach
                </select>
            </div>
           
            <div style="clear: both;"></div>
        </ul>
        <div class="col-lg-3 responsiveVersion-3">
        	<ul class="col-lg-12 tu-event" id="bu_event">
        		<li type="buevent" buadt_id="15" buevent_id="1">Event - 1</li>
        	</ul>
            <div class="col-lg-12 loadMoreButton" id="loadMoreBuserEvent" lastid="15"><p>Add Events</p></div> 
       	</div>
        <div class="col-lg-9 tab-content responsiveVersion-9">
        	
           
            <div role="tabpanel" class="col-lg-12 border-right-10px tab-pane active" id="bu_video">
            	<div class="col-lg-3">
                	<ul class="col-lg-12 tu-event" id="officer_video_feed"><script>//jf_bu_videos();</script><li type="buvideo" buvideo_id="30" class="activeClass">2017-05-04 10:05:41</li></ul>
                	<div class="col-lg-12 loadMoreButton" id="loadMoreBuserVideo" lastid="30"><p>Load More Video</p></div>
               	</div>
                <div class="col-lg-9 video-player">
                	<!--<span id="officer_video_feed"></span>-->
                    <video id="officer_video" controls="" src="https://firebasestorage.googleapis.com/v0/b/witnessone-6aa17.appspot.com/o/videos%2F519549%2FVideo_20170504_100536.mp4?alt=media" autoplay="autoplay"></video>
                </div>
            </div>
        </div> 
    </div>
    <div class="col-lg-5">
        <p>Transport Map</p>
        
        <div id="busermapmsg" align="center" style="display: none;">
        	<p style="color:#000">Loading map data: Event-<span class="eventID"></span><br>of <br>
            Agent-<span class="selectedbuserid" style="color:#F00"></span></p>
      	</div>
    </div>
    
</div>
            </div>
        </div>
    </div>
    
</div>
<script src="{{url('public/assets/jquery.min.js')}}"></script>
<script src="{{url('public/assets/uikit/js/uikit.min.js')}}"></script>
<script src="{{url('public/assets/swfobject.min.js')}}"></script>


<script>
    

</script>


