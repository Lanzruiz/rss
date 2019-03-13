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
            <div role="tabpanel" class="col-lg-12 video-player border-right-10px tab-pane" id="agent_video" style="height:250px">
                
    	      <div class="col-lg-12 all-background-opacity">
   	 			<div class="col-lg-7">
				        <ul class="nav nav-tabs headerText" role="tablist">
				            <li class="col-lg-3 responsiveVersion-3"><p class="eventText">Archived Event</p></li>            
				            <li id="bu_video_click" role="presentation" class="active"><a href="#bu_video" role="tab" aria-controls="bu_video" data-toggle="tab" aria-expanded="true">Video</a></li>
				            
				            <div class="col-lg-3 select">
				                <select class="form-control" id="buser" name="buser">
				                	  @foreach($agent as $agents)
				                	  		<option value="{{$agents->fldUsersAccessCode}}">{{$agents->fldUsersFullname}}</option>
				                	  @endforeach
				                </select>
				            </div>
				           
				            <div style="clear: both;"></div>
				        </ul>
			        	<div id="displayAgentEvent">
					        <div class="col-lg-3 responsiveVersion-3">
					        	<ul class="col-lg-12 tu-event" id="agent_event">
					        		
					        	</ul>
					            <div class="col-lg-12 loadMoreButton" id="loadMoreBuserEvent" lastid="15"><p>Add Events</p></div> 
					       	</div>
					        <div class="col-lg-9 tab-content responsiveVersion-9">
					        						           
					            <div role="tabpanel" class="col-lg-12 border-right-10px tab-pane active" id="bu_video">
					            	<div class="col-lg-4">
					                	<ul class="col-lg-12 tu-event" id="agent_video_feed">
					                		
					                	</ul>

					                	<div class="col-lg-12 loadMoreButton" id="loadMoreBuserVideo" lastid="30"><p>Load More Video</p></div>
					               	</div>
					                <div class="col-lg-8 video-player">
					                	<!--<span id="officer_video_feed"></span>-->
					                    <video id="officer_video" controls="" src="https://firebasestorage.googleapis.com/v0/b/witnessone-6aa17.appspot.com/o/videos%2F519549%2FVideo_20170504_100536.mp4?alt=media" autoplay="autoplay"></video>
					                </div>
					            </div>
					        </div> 
					   </div> 
				</div>	   
			    <div class="col-lg-5">
			        <p>Agent Map</p>
			        
			        <div id="busermapmsg" align="center" style="display: none;">
			        	<p style="color:#000">Loading map data: Event-<span class="eventID"></span><br>of <br>
			            Agent-<span class="selectedbuserid" style="color:#F00"></span></p>
			      	</div>
			    </div>
		   


				 <div id="displayAgentError" style="margin-top:50px;">
				 	<div class="alert alert-danger">No Archive Found</div>
		</div>

        </div>

        
    </div>
    
</div>
<script src="{{url('public/assets/jquery.min.js')}}"></script>
<script src="{{url('public/assets/uikit/js/uikit.min.js')}}"></script>


<script>
	var agentAccessCode = {{$agent{0}->fldUsersAccessCode}};
	var eventID = "";

	populateEvents(agentAccessCode);

	function populateEvents(accesscode) {
		
		var agentArchiveRef = firebase.database().ref('video/'+accesscode);
		agentArchiveRef.once('value', function(snapshot){
				var agentEventCount = 0;

				snapshot.forEach(function(childSnapshot) {
					agentEventCount = agentEventCount + 1;
					$("#agent_event").append('<li data-accesscode="'+accesscode+'" data-id="'+childSnapshot.key+'">Event - '+childSnapshot.key+'</li>');
					if(agentEventCount == 1) {
						eventID = childSnapshot.key;
					}
				});

				if(agentEventCount == 0) {
					$("#displayAgentEvent").hide();
					console.log('no archive found');
					$("#displayAgentError").show();
				} else {
					$("#displayAgentEvent").show();
					$("#displayAgentError").hide();
					displayAllVideoByDate(accesscode,eventID);
				}
		});
	}

	function displayAllVideoByDate(accesscode,eventID) {
		var agentVideoRef = firebase.database().ref('video/'+accesscode+'/'+eventID);
		var agentVideoCount = 0;
		agentVideoRef.once('value', function(snapshot){
			snapshot.forEach(function(childSnapshot) {
				var childDict = childSnapshot.val();
				var classActive= "";
				agentVideoCount = agentVideoCount + 1;

				if(agentVideoCount == 1) {					
					$("#agent_video_feed").append('<li class="activeClass" data-lat="'+childDict["lng"]+'" data-lon="'+childDict["lon"]+'" data-filename="'+childDict["filename"]+'" data-id="'+childSnapshot.key+'">'+childDict["alert_datetime"]+'</li>');
				} else {
					$("#agent_video_feed").append('<li data-lat="'+childDict["lat"]+'" data-lon="'+childDict["lng"]+'" data-filename="'+childDict["filename"]+'" data-id="'+childSnapshot.key+'">'+childDict["alert_datetime"]+'</li>');
				}

				
			});
		});
	}


	$('#buser').on('change', function() {
	   accesscode =  this.value;
	   populateEvents(accesscode);
	})

</script>

