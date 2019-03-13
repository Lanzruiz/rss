<div id="audioMain" style="overflow-y: scroll;">
  <div class="col-lg-12 bg-primary" style="margin-bottom: 15px;">
      <div class="col-lg-10" style="padding-left: 15px;">
          <h4>Push To Talk</h4>
      </div>
      <div class="col-lg-2" align="right">
              <span id="audioClose" class="btn btn-danger btn-sm">X</span>
      </div>
  </div>
    <div class="col-lg-12" id="displayLiveChannel"></div>

    <div class="col-lg-12" id="loading">
        <div class="alert alert-danger"><img src="{{url('public/assets/images/ajax-loader.gif')}}"> Waiting for Live channel... </div>
    </div>
</div>

<script>
$(document).on("click","#audioPopup",function(e){
	console.log('agent event int click');
	$("#audioMain").fadeIn();
	//$("#text-overlay").fadeIn();
	$( "#audioMain" ).draggable();
	$("#audioClose").click(function(){
    //$(".pttAudioLive").trigger('pause');
		$("#audioMain").fadeOut();
	});
	e.preventDefault();
});



var audioRef = firebase.database().ref('audio_live_recording/{{Session::get('users_id')}}');
var audioContent = "";
var userTalk = [];
var userVoice = [];
var initialAudioByChannel = [];
var remainingAudioByChannel = [];

audioRef.on('value', function(snapshot){
    var checkSnapshot = snapshot.exists();
    if(checkSnapshot == false) {
        $("#displayLiveChannel").hide();
        $("#loading").show();
    } else {
       $("#displayLiveChannel").show();
       $("#loading").hide();
    }

    var dctr = 0;

      snapshot.forEach(function(childSnapshot) {
        var snapDict = childSnapshot.val();

            var ctr = 0;
            childSnapshot.forEach(function(userSnapshot) {
                var audioDict = userSnapshot.val();

                if (ctr == 0) {
                  audioContent += "<div id='audioContent'>";
                    audioContent += "<div class='col-lg-8 text-danger' style='padding-top: 15px;'><strong>&nbsp;&nbsp;Channel:&nbsp;&nbsp;"+childSnapshot.key+"</strong></div><div class='col-lg-4' align='right' style='padding-top: 15px;'><audio class='pttAudioLive' src='#' id='"+childSnapshot.key+"' data-accesscode='"+userSnapshot.key+"' data-id='"+dctr+"' controls controlsList='nodownload' style='height: 20px !important;'></audio></div><hr>";
                    audioContent += "<table border='0' class='col-lg-12'>";
                }

                if (jQuery.inArray( userSnapshot.key, userTalk ) == -1) {
                   userTalk.push(userSnapshot.key);
                   audioContent += "<tr><td class='col-lg-6' style='padding: 5px 15px;'>"+audioDict["name"]+"</td><td class='col-lg-6'><div class='progress' style='height: 20px !important;'><div class='progress-bar progress-bar-warning' id='progress_"+userSnapshot.key+'_'+childSnapshot.key+"'  role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%'></div></div></td></tr>";
                   $("#displayLiveChannel").append(audioContent);
                 }

                 $("#"+childSnapshot.key).attr('src',"data:audio/ogg;base64,"+audioDict['data']);
                 $("#"+childSnapshot.key).trigger('play');
                 ctr = ctr + 1;
            });
      });


      dctr = dctr + 1;
      audioContent += "</table>";
      audioContent += "</div>";

      $('.pttAudioLive').on('play', function() {
          var id = $(this).attr('id');
          var access_code = $(this).data('accesscode');

          var progress_val = 0;
          var progressInterval = setInterval(function() {
                var progressID = access_code +'_'+id;

                progress_val = progress_val + 40;
                $("#progress_"+progressID).attr('style','width:'+progress_val+'%');
                if (progress_val >= 150) {
                   progress_val = 0;
                   clearInterval(progressInterval);
                   $("#progress_"+progressID).attr('style','width:0%');
                }
          }, 200);


      });

});






</script>
