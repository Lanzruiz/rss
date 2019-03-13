<!DOCTYPE html>
<html lang="en">
<head>
  	<title>RaptorSecuritySoftware&trade;</title>
  	<meta charset="UTF-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/custom_responsive.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/style.css')}}">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="{{url('public/assets/images/favicon.ico')}}" type="image/x-icon" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.min.css">
<style>
.form-group{
	margin-bottom:10px;
}
.tbl{
	border:1px solid #900;
	padding:10px;
	border-radius:5px;
	margin-top:25px;
}
@media all and (max-width:1024px){
	.form-group .col-lg-2{width:35%; float:left; margin-bottom:5px;}
	.form-group .col-lg-4{width:65%; float:left; margin-bottom:5px;}
	.form-group .col-lg-10{width:65%; float:left; margin-bottom:5px;}
	.form-group{margin:0}
}
@media all and (max-width:640px){
	.form-group .col-lg-2{width:100%;}
	.form-group .col-lg-4{width:100%;}
	.form-group .col-lg-10{width:100%;}
}
.failure{color:#F00;text-align:center; width:100%;}
h1{margin:0; padding:5px;color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;}
#text-overlay{display:none;width:100%;height:100%;position:fixed;background-color:#000;opacity: 0.9;z-index:9999; float:left}
#text-frame{display:none;width:100%; position:fixed; z-index:9999; cursor:pointer; text-align:center; margin-top:250px}
	</style>
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
			if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode == 32 || charCode == 46))
				return true;
			else
				alert('Characters and spaces allowed only');
				return false;
		}
		catch (err) {
			alert(err.Description);
		}
	}
	</script>
	 @section('headercodes')
    @show
</head>
<body>
<div id="text-overlay"></div>
<div id="text-frame"><h1></h1></div>
<div class="container-fluid main">
	<header class="row home_header_wrap">
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="row logo_sec">
						<img src="{{url('public/assets/images/main-logo.png')}}" class="img-responsive" />
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</header>
</div>


@yield('content')



 @section('extracodes')

  @show
		<div class="col-lg-12">
            <footer class="container">
				<br/><br/>
				<div class="bottom_hr"></div>
					<br/>
						<a href="#">Privacy Policy</a> | <a href="#">Data Policy</a> | <a href="#"> Terms of Service </a> | <a href="{{url('/public/user_guide.pdf')}}" target="_blank" > Terms of Use</a> | <a href="{{url('/faq')}}"> FAQ </a>
					<hr/>
					<article class="grid_12">
						<div class="inner-block"> &trade; &copy; 2008-<?php echo date("Y");?> RaptorSecuritySoftware, LLC. All Rights Reserved. </br>
                            <a href="https://tbltechnerds.com">Security Software Programming</a>
    
                        </div>
           <?php /* <script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>*/ ?>
					</article>
				<div class="clear"></div>
				<br/>
			</footer>
        </div>
	</body>
</html>
