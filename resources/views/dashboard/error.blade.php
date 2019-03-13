<!DOCTYPE html>
<html>
<head>
<title>LiveWitness&trade;</title>
<style>
body{padding:0; margin:0;}
.image{width:100%; margin-top:100px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
#text-overlay{display:none;width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
#text-frame{display:none;width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:250px}
@media only screen and (min-device-width: 320px) and (max-device-width: 568px) and (orientation : portrait) { 
    /* iPhone 5 Portrait */ 
	.image{width:100%; margin-top:50px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
	.image img{width:90%; margin-left:auto; margin-right:auto}
	h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none; width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
	#text-frame{display:none; width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:100px}
}
@media only screen and (min-device-width: 375px) and (max-device-width: 568px) and (orientation : landscape) { 
    /* iPhone 5 landscape */
	.image{width:100%; margin-top:50px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
	.image img{width:90%; margin-left:auto; margin-right:auto}
	h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none; width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
	#text-frame{display:none; width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:100px}
}

@media only screen and (max-device-width: 640px), only screen and (max-device-width: 667px), only screen and (max-width: 480px){ 
    /* iPhone 6 and iPhone 6+ portrait and landscape */
	.image{width:100%; margin-top:50px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
	.image img{width:90%; margin-left:auto; margin-right:auto}
	h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none; width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
	#text-frame{display:none; width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:100px}
}

@media only screen and (max-device-width: 640px), only screen and (max-device-width: 667px), only screen and (max-width: 480px) and (orientation : portrait){ 
    /* iPhone 6 and iPhone 6+ portrait */
	.image{width:100%; margin-top:50px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
	.image img{width:90%; margin-left:auto; margin-right:auto}
	h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none; width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
	#text-frame{display:none; width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:100px}
}

@media only screen and (max-device-width: 640px), only screen and (max-device-width: 667px), only screen and (max-device-width: 1136px), only screen and (max-width: 480px) and (orientation : landscape){ 
    /* iPhone 6 and iPhone 6+ landscape */
	.image{width:100%; margin-top:50px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
	.image img{width:90%; margin-left:auto; margin-right:auto}
	h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none; width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
	#text-frame{display:none; width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:100px}
}
@media (min-width:668px) and (max-width:1024px){
	.image{width:100%; margin-top:150px; margin-left:auto; margin-right:auto; text-align:center; color:#FFF; position:fixed}
	.image img{width:90%; margin-left:auto; margin-right:auto}
	h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
	#text-overlay{display:none; width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
	#text-frame{display:none; width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:250px}
}
</style>
</head>
<body bgcolor="#0099FF">	
<div id="text-overlay"></div>
<div id="text-frame"><h1></h1></div>	
<div class="image">
	<img src='{{url('public/assets/images/main-logo.png')}}'><br>
	<h2>No archive found for Transport & Agent</h2>
	<p>Click <a href="{{url('dashboard/console')}}">here</a> to go back</p>
</div>	
</body>
</html>