<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="UTF-8">
    <title>RaptorSecuritySoftware&trade;::Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('public/admin/assets/css/main.min.css')}}">
    <link rel="icon" href="{{url('public/assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('public/assets/images/favicon.ico')}}" type="image/x-icon" />
    <!-- metisMenu stylesheet
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.css"> -->
    <!-- calender
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.css"> -->
    <!-- validation -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css">
    <!-- others
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.theme.min.css"> -->
    <!-- data table / sortable table -->
	<style>
	::-webkit-scrollbar {width: 10px;background-color: #FF9;opacity:.7;}
	/*::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 25px rgba(5,0,0,0.3);
		-moz-box-shadow: inset 0 0 25px rgba(5,0,0,0.3);
	}*/
	::-webkit-scrollbar-thumb {
		-webkit-box-shadow: inset 0 0 25px rgba(5,0,0,0.5);
		-moz-box-shadow: inset 0 0 25px rgba(5,0,0,0.5);
	}
	</style>
	 
    <!--<link rel="stylesheet" href="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css">-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132339588-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-132339588-1');
	</script>
    <script>
	function numbersOnly(oToCheckField, oKeyEvent) {
		return oKeyEvent.charCode === 0 || /\d/.test(String.fromCharCode(oKeyEvent.charCode));
	}
	function onlyAlphabets(e, t) {
		try {
			if (window.event) {
				var charCode = window.event.keyCode;
			}
			else if (e) {
				var charCode = e.which;
			}
			else { return true; }
			//if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode == 32 || charCode == 46))
			if (charCode < 10)
				return true;
			else
				alert('Please enter digit only');
				return false;
		}
		catch (err) {
			alert(err.Description);
		}
	}
	//window resize on page loading time
	/*$(function(){
		$(window).resize(function() {
			$('#wrap').height($(window).height());// - 46);
			$('#wrap').width($(window).width());
		});
		$(window).trigger('resize');
	});*/

    </script>
    <link rel="stylesheet" href="{{url('public/assets/css/admin.css')}}">
    @section('headercodes')
     @show
</head>

<div id="wrap">
    <div id="top" style="border-bottom: 1px solid #FFF;">
    	@include('dashboard.users.include.menu')
    </div>
    <div id="content">
      <div class="bg-light lter">
        <style>
          .form-control.col-lg-6 {
            width: 50% !important;
          }
        </style>
        <div class="row">
          <div class="col-lg-12">
	            <div class="box" id="mainContent">
	            	@yield('content')
	            </div>
            </div>
        </div>
      </div>
    </div>

</div>



 @section('extracodes')

 @show

 <!--<footer class="Footer bg-dark dker">-->
<footer class="bg-dark dker" id="footer">
  <p>&copy; 2014 - <?php echo date("Y"); ?> RaptorSecuritySoftware&trade; Corp. All Rights Reserved.</br><a href="https://tbltechnerds.com">Security Software Programming</a></p>
</footer>
