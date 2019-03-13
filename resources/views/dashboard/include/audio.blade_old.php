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
    <div class="col-lg-12" id="displayChannel"></div>
</div>

<script>
$(document).on("click","#audioPopup",function(e){
	console.log('agent event int click');
	$("#audioMain").fadeIn();
	//$("#text-overlay").fadeIn();
	$( "#audioMain" ).draggable();
	$("#audioClose").click(function(){
    $(".pttAudio").trigger('pause');
		$("#audioMain").fadeOut();
	});
	e.preventDefault();
});


var audioRef = firebase.database().ref('audio_recording/{{Session::get('users_id')}}');
var audioContent = "";
var userTalk = [];
var userVoice = [];
var initialAudioByChannel = [];
var remainingAudioByChannel = [];

audioRef.orderByChild("timestamp").once('value', function(snapshot){
    //console.log(snapshot.val());
    console.log(snapshot.key);
    var checkSnapshot = snapshot.exists();
    if(checkSnapshot == false) {
        $("#loading").hide();
        $("#displayChannel").hide();
    }

    //userVoice.push(snapshot.val());
    // var dctr = 0;
    // snapshot.forEach(function(childSnapshot) {
    //
    //   var snapDict = childSnapshot.val();
    //
    //     // audioContent += "<div id='audioContent'>";
    //     //   audioContent += "<div class='col-lg-8 text-danger' style='padding-top: 15px;'><strong>&nbsp;&nbsp;Channel:&nbsp;&nbsp;"+childSnapshot.key+"</strong></div><div class='col-lg-4' align='right' style='padding-top: 15px;'><audio class='pttAudio' src='#' id='"+childSnapshot.key+"' data-accesscode='"+snapDict["access_code"]+"' data-id='"+dctr+"' controls controlsList='nodownload' style='height: 20px !important;'></audio></div><hr>";
    //     //   audioContent += "<table border='0' class='col-lg-12'>";
    //
    //     audioContent += "<div id='audioContent'>";
    //         audioContent += "<div class='col-lg-8 text-danger' style='padding-top: 15px;'><strong>&nbsp;&nbsp;Channel:&nbsp;&nbsp;"+childSnapshot.key+"</strong></div><div class='col-lg-4' align='right' style='padding-top: 15px;'>Play</div>";
    //     audioContent += "</div>";
    //
    //
    //     var ctr = 0;
    //
    //     // remainingAudioByChannel.push({"channel": childSnapshot.key, audio: []});
    //     // childSnapshot.forEach(function(childAudioSnapshot) {
    //     //     ctr = ctr + 1;
    //     //      var audioDict = childAudioSnapshot.val();
    //     //
    //     //      if (jQuery.inArray( audioDict["accessCode"], userTalk ) == -1) {
    //     //         userTalk.push(audioDict["accessCode"]);
    //     //         audioContent += "<tr><td class='col-lg-6' style='padding: 5px 15px;'>"+audioDict["name"]+"</td><td class='col-lg-6'><div class='progress' style='height: 20px !important;'><div class='progress-bar progress-bar-warning' id='progress_"+audioDict['accessCode']+'_'+childSnapshot.key+"'  role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%'></div></div></td></tr>";
    //     //       }
    //     //
    //     //       if(ctr == 1) {
    //     //
    //     //            initialAudioByChannel.push({"channel": childSnapshot.key, "filename": audioDict['data'], "access_code": audioDict['accessCode']});
    //     //       } else {
    //     //
    //     //           remainingAudioByChannel[dctr].audio.push({"channel": childSnapshot.key, "filename": audioDict['data'], "access_code": audioDict['accessCode']});
    //     //
    //     //       }
    //     //
    //     // });
    //
    //     //ctr = 0;
    //     dctr = dctr + 1;
    //     // audioContent += "</table>";
    //     // audioContent += "</div>";
    //
    //     //userTalk = [];
    //     //console.log(initialAudioByChannel);
    //     console.log(audioContent);
    // });

    $("#displayChannel").html(audioContent).promise().done(function(){
        $('#loading').hide();
    });


    for (i = 0; i <= initialAudioByChannel.length-1; i++) {

         $("#"+initialAudioByChannel[i].channel).attr('src',"data:audio/ogg;base64,"+initialAudioByChannel[i].filename);

    }

    $('.pttAudio').on('play', function() {
        var id = $(this).data('id');
        var access_code = $(this).data('accesscode');
        //console.log('access_code'+access_code);
        //console.log(this.duration);
        //$("#progress_"+initialAudioByChannel[id].access_code).attr('style','width:20%');
        //console.log(id);
        //console.log(initialAudioByChannel[id].access_code);
        // $("#progress_"+initialAudioByChannel[id].access_code).data('progress',20);
        // var pGress = setInterval(function() {
        //   var pVal = $("#progress_"+initialAudioByChannel[id].access_code).data('progress');
        //   var pCnt = !isNaN(pVal) ? (pVal + 20) : 20;
        //     if (pCnt > 100) {
        //         $("#progress_"+initialAudioByChannel[id].access_code).attr('style','width:0%');
        //     } else {
        //         $("#progress_"+initialAudioByChannel[id].access_code).data('progress',pCnt);
        //         $("#progress_"+initialAudioByChannel[id].access_code).attr('style','width:'+pCnt+'%');
        //     }
        // },10);
        //console.log(id);
        //console.log(initialAudioByChannel[id].access_code+'_'+initialAudioByChannel[id].channel);

        var progress_val = 0;
        var progressInterval = setInterval(function() {
              var progressID = access_code +'_'+initialAudioByChannel[id].channel;
              progress_val = progress_val + 40;
              $("#progress_"+progressID).attr('style','width:'+progress_val+'%');
              if (progress_val >= 150) {
                 progress_val = 0;
                 clearInterval(progressInterval);
                 $("#progress_"+progressID).attr('style','width:0%');
              }
        }, 200);
        // console.log("Duration: "+this.duration);
        // console.log("Current Time: "+this.currentTime);
        // var progressID = access_code +'_'+initialAudioByChannel[id].channel;
        // var value = 0;
        // if(this.duration == 'Infinity') {
        //  		value = 100;
        //  } else if (this.currentTime > 0) {
        //     console.log("ok");
        //     value = Math.floor((100 / this.duration) * this.currentTime);
        //  }
        //  console.log("Value: "+value);
        //  //set the width of the progress bar
        //  $("#progress_"+progressID).attr('style','width:'+value+'%');
        //  if (value >= 100) {
        //     value = 0;
        //     $("#progress_"+progressID).attr('style','width:0%');
        // }
         //progressID.stop().css({'width':value + '%'},500)



    });



    // $('.pttAudio').addEventListener("timeupdate", updateProgress, false);
    //
    // function updateProgress() {
    //    var progress = document.getElementById("progress");
    //    var value = 0;
    //    if (video.currentTime > 0) {
    //       value = Math.floor((100 / video.duration) * video.currentTime);
    //    }
    //    progress.style.width = value + "%";
    //  }

    var audioCounter = 0;
    $('.pttAudio').on('ended', function() {
          var id = $(this).data('id');

          if (audioCounter <=  remainingAudioByChannel[id].audio.length -1) {
            var currentAccessCode = remainingAudioByChannel[id].audio[audioCounter].access_code;
              $(this).data('accesscode',currentAccessCode);
              //console.log('accesscode'+currentAccessCode);
               $("#"+initialAudioByChannel[id].channel).attr('src',"data:audio/ogg;base64,"+remainingAudioByChannel[id].audio[audioCounter].filename);
               $("#"+initialAudioByChannel[id].channel).trigger('play');
               audioCounter=audioCounter+1;
          } else {
               $("#"+initialAudioByChannel[id].channel).attr('src',"data:audio/ogg;base64,"+initialAudioByChannel[id].filename);
               audioCounter = 0;
               $(this).data('accesscode',initialAudioByChannel[id].access_code);
               $("#"+initialAudioByChannel[id].channel).trigger('stop');
          }
    });

});


</script>
