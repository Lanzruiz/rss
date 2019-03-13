<!DOCTYPE html>
<html lang="en">
<head>
  	<title>LiveWitness&trade;</title>
  	<meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
   	<link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/bootstrap.min.css')}}">
    <!--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css">-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/console.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/responsive.css')}}">
    <!-- tuser audio player -->
    <link rel="stylesheet" href="{{url('public/assets/css/audio_player/slider.css')}}">
	<!--<link href="https://vjs.zencdn.net/5.0/video-js.min.css" rel="stylesheet">-->
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('public/assets/images/favicon.ico')}}" type="image/x-icon" />
    <style>
	#text-frame h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none;width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.5;z-index:9999; float:left}
	#text-frame{display:none;width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:250px}
	</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.2.1/firebase.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA46DKC6GhBb46BpIj1GMSGtQyfaiX6HIc&libraries=geometry"></script>
    <script src="{{url('public/assets/audio_player/bootstrap-slider.js')}}"></script>
    <script>
	var media_path = "../media/";
	var DATA_REFRESH_ON = false;
	var DATA_REFRESH_FREQUENCY = 1000;
	var s;
	var selectedMarkerIcon = new google.maps.MarkerImage(
		'{{url("public/assets/images/selectedRedMarker.png")}}', // 'images/gmap/marker.gif',
		// This marker is 20 pixels wide by 32 pixels tall.
		new google.maps.Size(46,36),
		// The origin for this image is 0,0.
		new google.maps.Point(0,0),
		// The anchor for this image is the base of the flagpole at 0,32.
		new google.maps.Point(24,12)
	);
	var unSelectedMarkerIcon = new google.maps.MarkerImage(
		'{{url("public/assets/images/unSelectedMarker.png")}}', // 'images/gmap/marker.gif',
		// This marker is 20 pixels wide by 32 pixels tall.
		new google.maps.Size(16,16 ),
		// The origin for this image is 0,0.
		new google.maps.Point(0,0),
		// The anchor for this image is the base of the flagpole at 0,32.
		new google.maps.Point(8,8)
	);
	//var uns_2 = "../images/unSelectedMarker.png";//"../images/uns_2.png";
	var uns_2 = new google.maps.MarkerImage(
		'{{url("public/assets/images/uns_2.png")}}', // 'images/gmap/marker.gif',
		// This marker is 20 pixels wide by 32 pixels tall.
		new google.maps.Size(16,16),
		// The origin for this image is 0,0.
		new google.maps.Point(0,0),
		// The anchor for this image is the base of the flagpole at 0,32.
		new google.maps.Point(8,8)
	);
	
	</script>
	<script src="{{url('public/assets/js/firebase_conf.js')}}"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
	 @section('headercodes')
    @show 
<body>   


@yield('content') 



 @section('extracodes')
  	
  @show 

<div class="col-lg-12 footers">
        <footer class="container">
            <h5>&trade; &copy; 2008-<?php echo date("Y");?> WitnessOne, LLC. All Rights Reserved</h5>
        </footer>
    </div>
</div>
</body>
</html>  
			