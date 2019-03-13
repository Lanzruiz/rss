<!DOCTYPE html>
<html lang="en">
<head>
  	<title>LiveWitness&trade;</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/bootstrap.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.2.1/firebase.js"></script>
    <script src="{{url('public/assets/js/firebase_conf.js')}}"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCm7lLXY9LEhmOEyTzzIeLbq6LA_teCGBE&sensor=false&callback=initializeMap"></script>

    <style>
      .container{
          width: 50%;
          min-height: 50%;
          margin: 0 auto;
       }
       #map { height : 80%; width : 80%; top : 0; left : 0; bottom: 0; right: 0; margin: auto; position : absolute; z-index : 200;}

    </style>
</head>
    <body>
        <div class="row">
            <div class="col-md-12">
              <div class="container">
                  @if($error == "")
                    <div id="map"></div>
                  @else
                    <div class="alert alert-danger">{{$error}}</div>
                  @endif
              </div>
            </div>
        </div>
    </body>

<script>
    var map = null;
    var agentMarker = [];
    var transportMarker = [];
    var isAgent = false;
    var agentCurrentLocation = false;
    var isTransport = false;
    var transportCurrentLocation = false;
    var allMarker = [];
    var bounds = null;
    var manualZoom = false;
    var timer = null;
    var counter = 0;

    @if($error == "")
      //for agent marker map
      var agentRef = firebase.database().ref('users/{{$comanderID}}/agent');
      agentRef.on('value', function(snapshot){
          if (snapshot.val() == null){
              isAgent = false;
              clearMarker("agent");

              if(isAgent == false && isTransport == false) {
                  initializeMap();
              }

          } else {
            isAgent = true;
            snapshot.forEach(function(childSnapshot) {
        			   var snapDict = childSnapshot.val();
                 accesscode = snapDict["accesscode"];
         				 eventID = snapDict["eventID"];

                 agentMapMarker(accesscode);
            });
          }
      });


      //for transport marker map
      var transportRef = firebase.database().ref('users/{{$comanderID}}/transport');
      transportRef.on('value', function(snapshot){
          if (snapshot.val() == null){
              isTransport = false;


              clearMarker("transport");
              if(isAgent == false && isTransport == false) {
                  initializeMap();
              }


          } else {
            isTransport = true

            snapshot.forEach(function(childSnapshot) {
        			   var snapDict = childSnapshot.val();
                 accesscode = snapDict["accesscode"];
         				 eventID = snapDict["eventID"];

                 transportMapMarker(accesscode);
            });
          }
      });


    @endif



    function initializeMap() {

      var myCenter = new google.maps.LatLng(38.907192, -77.036871);
      var mapOptions = {
            center:myCenter,
              mapTypeId: 'hybrid',
            zoom:18
      };

      map = new google.maps.Map(document.getElementById("map"), mapOptions);
      map.setTilt(45);

      map.addListener('zoom_changed', function() {
        manualZoom = true;
        counter = 0;
        console.log('start timer');
        timer= setInterval("stopInterval()", 10000);
      });
      //
      // map.addListener('dragend', function() {
      //   console.log("drag end");
      // });

      bounds = new google.maps.LatLngBounds();
    }

    function stopInterval() {
    //  counter++;
      console.log("false");
      //if (counter == 10) {
         manualZoom = false;
         clearInterval(timer);
      //}
    }

    function agentMapMarker(accesscode) {
        var agentLocationRef = firebase.database().ref('user_location/'+accesscode);
        agentLocationRef.on('value', function(snapshot){
      		var snapDict = snapshot.val();
      		if (snapDict == null) {
              clearMarkerByAccessCode(accesscode);
              bounds = new google.maps.LatLngBounds();
          } else {
            var lat = parseFloat(snapDict["lat"]);
      			var lon = parseFloat(snapDict["lon"]);


            if (accesscode == {{$accesscode}} && agentCurrentLocation == false) {
               agentCurrentLocation = true
               userCurrentLocation(lat,lon);
            }

            initMap(lat,lon,"agent",accesscode);
          }
        });
    }

    function transportMapMarker(accesscode) {
        var transportLocationRef = firebase.database().ref('user_location/'+accesscode);
        transportLocationRef.on('value', function(snapshot){
      		var snapDict = snapshot.val();
      		if (snapDict == null) {
            clearMarkerByAccessCode(accesscode);
            bounds = new google.maps.LatLngBounds();
          } else {
            var lat = parseFloat(snapDict["lat"]);
      			var lon = parseFloat(snapDict["lon"]);
            initMap(lat,lon,"transport",accesscode);
          }
        });
    }

  function initMap(lat,lon, type,accesscode){
    	 var coordinate = {lat: lat, lng: lon};

       clearMarkerByAccessCode(accesscode);

       if(type == "agent") {

        	var marker = new google.maps.Marker({
        		position: coordinate,
        		map: map,
        		icon: '{{url('public/assets/images/agent-o.png')}}'
        	});


          agentMarker.push(marker);

          if (accesscode == {{$accesscode}}) {
              bounds.extend(marker.position);
          }

         /********end marker for agent********/
      } else if (type == "transport") {
             //clearMarker("transport");

            var marker = new google.maps.Marker({
              position: coordinate,
              map: map,
              optimized: false,
          		icon: '{{url('public/assets/images/Pulse_32x37.gif')}}'
            });

          transportMarker.push(marker);

          bounds.extend(marker.position);

          centerMapBasedOnTransport();

      }



      window[accesscode] = marker

      if(accesscode == {{$accesscode}} && isTransport == false) {
        if(manualZoom == false) {
    	     map.setCenter(new google.maps.LatLng(lat,lon));
        }
      }
    }


    function centerMapBasedOnTransport() {
      //console.log("centerMapBasedOnTransport ");
      if(manualZoom == false) {
        map.fitBounds(bounds);
      }
    }


    function userCurrentLocation(lat,lon) {

       var coordinate = {lat: lat, lng: lon};

       map.setCenter(new google.maps.LatLng(lat,lon));
    }

    function clearMarker(type) {
       if(type == "agent") {
           for(i=0; i<agentMarker.length; i++){
               agentMarker[i].setMap(null);
           }
       } else if(type == "transport") {
         for(i=0; i<transportMarker.length; i++){
             transportMarker[i].setMap(null);
         }
       }
    }
    function clearMarkerByAccessCode(accesscode) {
      if(window[accesscode] && window[accesscode].setMap) {
        window[accesscode].setMap(null);
      }
    }



</script>

</html>
