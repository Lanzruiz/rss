<style>
 a.channel:hover {
    color: #000;
 }
 a.channel:active {
   color: #000;
 }
 a.channel {
   text-decoration: none;
 }
</style>
<div id="audioMain" style="overflow-y: scroll;">
  <div class="col-lg-12 bg-primary" style="margin-bottom: 15px;">
      <div class="col-lg-10" style="padding-left: 15px;">
          <h4>Push To Talk</h4>
      </div>
      <div class="col-lg-2" align="right">
              <span id="audioClose" class="btn btn-danger btn-sm">X</span>
      </div>
  </div>
    <div class="col-lg-12" id="loading">
        <div class="alert alert-danger"><img src="{{url('public/assets/images/ajax-loader.gif')}}"> Please wait... Loading Data... </div>
    </div>
    <div id="backLinks"><a href="javascript:void(0)" onClick="backClick()"> Back </a></div>
    <div class="col-lg-12" id="displayChannel"></div>
    <div class="col-lg-12" id="displayChannelContent"></div>
</div>

<script>
$(document).on("click","#audioPopup",function(e){
	console.log('agent event int click');
	$("#audioMain").fadeIn();
  populateNewData();
  //console.log({{Session::get('users_id')}});
	//$("#text-overlay").fadeIn();
	$( "#audioMain" ).draggable();
	$("#audioClose").click(function(){
    $(".pttAudio").trigger('pause');
		$("#audioMain").fadeOut();
	});
	e.preventDefault();
});


function backClick() {
    $("#displayChannel").show();
    $("#displayChannelContent").hide();
    $("#backLinks").hide();
    $('.pttAudio').trigger('pause');
}


$("#backLinks").hide();
$("#displayChannelContent").hide();
function populateNewData() {

      var audioRef = firebase.database().ref('audio_recording/{{Session::get('users_id')}}');
      var audioContent = "";

      audioRef.once('value', function(snapshot){
          console.log(snapshot)
          snapshot.forEach(function(childSnapshot) {

                audioContent += "<div id='audioContent'>";
                  audioContent += "<div class='col-lg-8 text-danger' style='padding-top: 15px;'><strong>&nbsp;&nbsp;Channel:&nbsp;&nbsp;"+childSnapshot.key+"</strong></div><a href='javascript:void(0)' class='col-lg-4 channel' align='center' style='padding-top: 15px;cursor: pointer; background-color: transparent;'  onClick=displayVoiceChannel('"+childSnapshot.key+"')><i class='fa fa-play-circle-o' style='font-size: 1.9em'></i></a></div>";
                audioContent += "</div>";

          });



          $("#displayChannel").html(audioContent).promise().done(function(){
              $('#loading').hide();
          });
      });


}


function displayVoiceChannel(channelID) {

  $("#displayChannel").hide();
  $('#loading').show();
console.log(channelID);
  var channelAudioRef = firebase.database().ref('audio_recording/{{Session::get('users_id')}}/'+channelID);
  channelAudioRef.orderByChild('timestamp').once('value',function(snapshot) {
    var checkSnapshot = snapshot.exists();
    console.log("checkSnapshot : " + checkSnapshot);
    if(checkSnapshot == false) {
      $("#displayChannel").show();
      $('#loading').hide();
      $('#backLinks').hide();
    } else {
      $("#displayChannelContent").show();
      $("#backLinks").show();
    }

      var audioContent = "";
      var userTalk = [];
      var userVoice = [];
      var initialAudioByChannel = [];
      var remainingAudioByChannel = [];

      audioContent += "<div id='audioContentChanel'>";
      audioContent += "<div class='col-lg-8 text-danger' style='padding-top: 15px;'><strong>&nbsp;&nbsp;Channel:&nbsp;&nbsp;"+channelID+"</strong></div><div class='col-lg-4' align='right' style='padding-top: 15px;'><audio class='pttAudio' src='#' id='"+channelID+"' data-accesscode='' controls controlsList='nodownload' style='height: 20px !important;'></audio></div><hr>";
      audioContent += "<table border='0' class='col-lg-12'>";
      var ctr = 0;
      remainingAudioByChannel.push({"channel": channelID, audio: []});
      snapshot.forEach(function(childSnapshot) {
          ctr = ctr + 1;
          var audioDict = childSnapshot.val();
          //console.log(audioDict["accessCode"]);

          console.log(audioDict["counter"]);

          if (jQuery.inArray( audioDict["accessCode"], userTalk ) == -1) {
             userTalk.push(audioDict["accessCode"]);
             audioContent += "<tr><td class='col-lg-6' style='padding: 5px 15px;'>"+audioDict["name"]+"</td><td class='col-lg-6'><div class='progress' style='height: 20px !important;'><div class='progress-bar progress-bar-warning' id='progress_"+audioDict['accessCode']+'_'+channelID+"'  role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%'></div></div></td></tr>";
           }

           if(ctr == 1) {
                initialAudioByChannel.push({"channel": channelID, "filename": audioDict['data'], "access_code": audioDict['accessCode']});
           } else {

               remainingAudioByChannel[0].audio.push({"channel": channelID, "filename": audioDict['data'], "access_code": audioDict['accessCode']});

           }

      });

      ctr = 0;
      audioContent += "</table>";
      audioContent += "</div>";

      userTalk = [];

      $("#displayChannelContent").html(audioContent).promise().done(function(){
          $('#loading').hide();
      });

      //console.log("initialAudioByChannel: " + initialAudioByChannel.length);
      for (i = 0; i <= initialAudioByChannel.length-1; i++) {
        //console.log(initialAudioByChannel[i].filename);
           $("#"+initialAudioByChannel[i].channel).attr('src',"data:audio/ogg;base64,"+initialAudioByChannel[i].filename);
           $("#"+initialAudioByChannel[0].channel).trigger('play');
      }


      $('.pttAudio').on('play', function() {
          //var id = $(this).data('id');
          var access_code = $(this).data('accesscode');


          var progress_val = 0;
          var progressInterval = setInterval(function() {
                var progressID = access_code +'_'+initialAudioByChannel[0].channel;
                progress_val = progress_val + 40;
                $("#progress_"+progressID).attr('style','width:'+progress_val+'%');
                if (progress_val >= 150) {
                   progress_val = 0;
                   clearInterval(progressInterval);
                   $("#progress_"+progressID).attr('style','width:0%');
                }
          }, 200);



      });


      var audioCounter = 0;
      $('.pttAudio').on('ended', function() {
            //var id = $(this).data('id');

            if (audioCounter <=  remainingAudioByChannel[0].audio.length -1) {
              var currentAccessCode = remainingAudioByChannel[0].audio[audioCounter].access_code;
                $(this).data('accesscode',currentAccessCode);
                //console.log('accesscode'+currentAccessCode);
                 $("#"+initialAudioByChannel[0].channel).attr('src',"data:audio/ogg;base64,"+remainingAudioByChannel[0].audio[audioCounter].filename);
                 $("#"+initialAudioByChannel[0].channel).trigger('play');
                 audioCounter=audioCounter+1;
            } else {
                 $("#"+initialAudioByChannel[0].channel).attr('src',"data:audio/ogg;base64,"+initialAudioByChannel[0].filename);
                 audioCounter = 0;
                 $(this).data('accesscode',initialAudioByChannel[0].access_code);
                 $("#"+initialAudioByChannel[0].channel).trigger('stop');
            }
      });

  });
}



</script>
