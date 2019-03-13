<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="{{url('public/assets/uikit/css/uikit.min.css')}}" rel="stylesheet">
</head>
<body>

<div class="uk-grid">
    <div class="uk-width-1-2"> 
       <div id="player"></div> 

        <div id="flash" class="uk-container uk-container-center uk-margin-large-top" >
            <div class="uk-alert uk-alert-danger"> 
                <p><strong>You do not have Flash installed, or it is older than the required 10.0.0.</strong></p>
                <p><strong>Click below to install the latest version and then try again.</strong></p>
                <p>
                    <a target="_blank" href="https://www.adobe.com/go/getflashplayer">[ Download ]</a>            
                </p>
            </div>    
        </div> 
    </div>

    <div class="uk-width-1-2">
       <div id="map" style="width:100%; height:500px"></div>  
    </div>   

</div>

                  
      
</body>


</div>
<script src="{{url('public/assets/jquery.min.js')}}"></script>
<script src="{{url('public/assets/uikit/js/uikit.min.js')}}"></script>
<script src="{{url('public/assets/swfobject.min.js')}}"></script>

<script src="https://www.gstatic.com/firebasejs/3.9.0/firebase.js"></script>
<script src="{{url('public/assets/js/firebase_conf.js')}}"></script>

<script>
    //get the current location of the device id d7c533c029b404b9 
    var locationRef = firebase.database().ref('user_location/d7c533c029b404b9');
    locationRef.on('value', function(snapshot) {
        var snapDict = snapshot.val();
        var lat = snapDict["lat"];
        var lon = snapDict["lon"];
        
        initMap(parseFloat(lat),parseFloat(lon));
    });
</script>


<script>

        //Check if browser have flash installed
         $("#flash").hide();
         if(!swfobject.hasFlashPlayerVersion("1"))
         {
             $("#flash").show();
         }
           

        function streamingLive(src){

            var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};
            var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
            var attributes={id:'player'};
            swfobject.embedSWF('http://54.214.201.246/api/public/assets/player.swf','player','100%','500','10.2',null,flashvars,params,attributes);
        }

       
        $(document).ready(function() {
            streamingLive("rtmp://54.214.201.246/live");
            return false;            
        });
        

      function initMap(lat=parseFloat(14.554729),lon=parseFloat(121.024445)) {
        
        var coordinate = {lat: lat, lng: lon};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: coordinate
        });
        var marker = new google.maps.Marker({
          position: coordinate,
          map: map
        });
      }


    </script>

     <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCm7lLXY9LEhmOEyTzzIeLbq6LA_teCGBE&callback=initMap">
    </script>
</html>

