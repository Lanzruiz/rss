$(function(){

$(".install-flash-notif").hide();

 	if(swfobject.hasFlashPlayerVersion("9.0.115")){
    
    	alert("You have the minimum required flash version (or newer)");
	
	}else {
   
 		$(".install-flash-notif").show();

	}


});