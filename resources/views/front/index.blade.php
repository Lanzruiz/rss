@extends('layouts.front.index')

@section('content')

<style type="text/css">
  
  .download-buttons{
      display: block;
      width: 300px;
  }
  #google_translate_element{
	  display:inline-block;
	  float:left;
	  visibility: hidden;
  }
  .skiptranslate{
	  display:none;
  }
  body{
	  top:0px !important;
  }

</style> 
<?php
    // get language code
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $country  = "Unknown";

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $ip_data_in = curl_exec($ch); // string
    curl_close($ch);

    $ip_data = json_decode($ip_data_in,true);
    $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/

    if($ip_data && $ip_data['geoplugin_countryCode'] != null) {
        $country = $ip_data['geoplugin_countryCode'];
    }
	
	$locales = array('af-ZA','am-ET','ar-AE','ar-BH','ar-DZ','ar-EG','ar-IQ','ar-JO','ar-KW','ar-LB','ar-LY','ar-MA','ar-OM','ar-QA','ar-SA','ar-SY','ar-TN','ar-YE','az-AZ','be-BY','bg-BG','bn-BD','bs-BA','cs-CZ','da-DK','de-AT','de-CH','de-DE','de-LI','de-LU','dv-MV','el-GR','en-AU','en-BZ','en-CA','en-GB','en-IE','en-JM','en-MY','en-NZ','en-SG','en-TT','en-US','en-ZA','en-ZW','es-AR','es-BO','es-CL','es-CO','es-CR','es-DO','es-EC','es-ES','es-GT','es-HN','es-MX','es-NI','es-PA','es-PE','es-PR','es-PY','es-SV','en-US','es-UY','es-VE','et-EE','fa-IR','fi-FI','tl-PH','fo-FO','fr-BE','fr-CA','fr-CH','fr-FR','fr-LU','fr-MC','he-IL','hi-IN','hr-BA','hr-HR','hu-HU','hy-AM','id-ID','ig-NG','is-IS','it-CH','it-IT','ja-JP','ka-GE','kk-KZ','kl-GL','km-KH','ko-KR','ky-KG','lb-LU','lo-LA','lt-LT','lv-LV','mi-NZ','mk-MK','mn-MN','ms-BN','ms-MY','mt-MT','nb-NO','ne-NP','nl-BE','nl-NL','pl-PL','prs-AF','ps-AF','pt-BR','pt-PT','ro-RO','ru-RU','rw-RW','sv-SE','si-LK','sk-SK','sl-SI','sq-AL','sr-BA','sr-CS','sr-ME','sr-RS','sw-KE','tg-TJ','th-TH','tk-TM','tr-TR','uk-UA','ur-PK','uz-UZ','vi-VN','wo-SN','yo-NG','zh-CN-CN','zh-HK','zh-MO','zh-SG','zh-TW');

	shuffle($locales);

	foreach ($locales as $locale) {
        $locale_region = substr($locale, -2);

		if (strtoupper($country) == $locale_region) {
			$language = substr($locale, 0, -3);
		}
	} 
	 

    

?>

<div id="google_translate_element"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
$( document ).ready(function() {
	var lange = "<?php if(!empty($language)){echo $language; }else{echo 1;}?>";
	if(lange != '1'){
		window.location.assign("https://raptorsecuritysoftware.com/#googtrans(en|<?php echo $language; ?>)");
	}
});
</script>
  <div class="col-lg-12" id='login'>
  <form class="form-horizontal" id="popup-validation" action="" method="post" enctype="multipart/form-data" onSubmit="return firebaseLogin()">
  <div class="col-lg-4"></div>
  <div class="col-lg-4" style='box-shadow: 10px 0px 10px -7px rgba(0,0,0,0.5), -10px 10px 10px -7px rgba(0,0,0,0.5); overflow: auto;'>
      <div style='margin-top:25px;'>
        <fieldset><legend>Login</legend>
         @if (Session::has('error'))
              <div class="alert alert-danger">Invalid username or password</div>
          @endif

          @if(Session::has('reset-success'))
            <div class="alert alert-success">Success: <strong>Your password has been reset. You can now use your new password to login.</strong></div>
          @endif


         <div class="form-group">
            <label class="col-lg-12">Email/Username</label>
         </div>
         <div class="form-group">
            <div class="col-lg-12">
              <?php $username = isset($_COOKIE['remember_me']) ? $_COOKIE['remember_me'] : '' ?>
            <input type="text" name="username" id="username"  value="{{Session::has('username') ? Session::get('username') : $username}}" placeholder="Email/Username" class="validate[required] form-control">
                @if($errors->users->first('username'))
                  <div class="text-danger">{!!$errors->users->first('username')!!}</div>
               @endif
            </div>
         </div>
         <div class="form-group">
            <label class="col-lg-12">Password</label>
         </div>
         <div class="form-group">
             <div class="col-lg-12">
               <?php $password = isset($_COOKIE['remember_ps']) ? $_COOKIE['remember_ps'] : ''; ?>
            <input type="password" name="password" id="password" value="{{Session::has('password') ? Session::get('password') : $password}}" autocomplete="off" placeholder="password" class="validate[required] form-control">
            @if($errors->users->first('password'))
                  <div class="text-danger">{!!$errors->users->first('password')!!}</div>
               @endif
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-6">
                <input type="checkbox" name="remember" id="remember" <?php

                if(isset($_COOKIE['remember_me'])) {
echo 'checked="checked"';
}
else {
echo '';
}

?> > <label for="remember" style="font-weight:normal">Remember Me</label>
            </div>
            <div class="col-lg-6" align="right">
                <a href="{{url('forgot-password')}}" style="text-decoration:none;">Forgot Password?</a>
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-12" align="right">
                <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
            </div>
         </div>
         <div class="row">
             <div class="col-md-12" style="padding-bottom: 10px;">
               Don't have an account? <a href="{{url('registration')}}">Create your account now.</a>
            </div>
        </div>
       </fieldset>
       </div>
   </div>
   <div class="col-lg-4"></div>
  </form>
</div>

<!-- Download Asset buttons -->
<div class="row" id = "app_store_link">
    <div class="col-md-12" style="margin-top: 2%;"> 
        <center>
          <fieldset><legend> Asset / Transport </legend>
            <a href="https://itunes.apple.com/us/app/raptor-security-software-asset/id1433225550?mt=8" target="_blank">
                <img src="{{ url('public/assets/images/apple.png') }}" alt="Apple app download link" class="download-buttons"> 
            </a> 
            <a href="https://play.google.com/store/apps/details?id=com.security.rss.trans" target="_blank">
                <img src="{{ url('public/assets/images/google_play.png') }}" alt="Google play download link" class="download-buttons">
            </a>
           	<a href="https://www.amazon.com/O321-Technologies-LLC-Security-Software/dp/B07LFJWDXY/ref=sr_1_3?ie=UTF8&qid=1546929027&sr=8-3&keywords=Raptor+Security+Software" target="_blank">
                <img src="{{ url('public/assets/images/amazon_2.png') }}" alt="Amazon download link" class="download-buttons">
            </a>
        </center>
    </div> 

<!-- Download Agent buttons -->
    <div class="col-md-12" style="margin-top: 2%;"> 
        <center>
          <fieldset><legend> Agent </legend>
            <a href="https://itunes.apple.com/us/app/raptor-security-software-agent/id1433225070?mt=8" target="_blank">
                <img src="{{ url('public/assets/images/apple.png') }}" alt="Apple app download link" class="download-buttons"> 
            </a> 
            <a href="https://play.google.com/store/apps/details?id=com.security.rss.agent" target="_blank">
                <img src="{{ url('public/assets/images/google_play.png') }}" alt="Google play download link" class="download-buttons">
            </a>
            <a href="https://www.amazon.com/O321-Technologies-LLC-Securty-Software/dp/B07L4MQGZS/ref=sr_1_5?ie=UTF8&qid=1546929088&sr=8-5&keywords=raptor+security" target="_blank">
                <img src="{{ url('public/assets/images/amazon_2.png') }}" alt="Amazon download link" class="download-buttons">
            </a>
        </center>
    </div> 
</div>

<!-- <div class="row" style="margin-top: 20px;">
   <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="bg-video">
             <video class="bg-video__content col-md-12 col-sm-12 col-xs-12" autoplay muted controls>
                 <source src="{{url('public/assets/video/video.mp4')}}" type="video/mp4">
                  <source src="img/video.webm" type="video/webm">  -->
               <!--   Your browser is not supported! -->
            <!--  </video>
     </div>
   </div>
</div> -->


@stop

@section('headercodes')
   <style type="text/css">
       .download-buttons{
            width: 20%;
			display: inline-block !important;
       }
       @media (max-width:480px){
          .download-buttons{
              width: 70%;
          }
       }
   </style>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
   <script src="https://www.gstatic.com/firebasejs/3.2.1/firebase.js"></script>
<script src="{{url('public/assets/js/firebase_conf.js')}}"></script>
<script>
function firebaseLogin() {
    
    var username = $("#username").val()+"@raptorsecuritysoftware.tk";
    var password = $("#password").val();
    firebase.auth().createUserWithEmailAndPassword(username, password).catch(function(error) {
                                                                                  var errorCode = error.code;
                                                                                  var errorMessage = error.message;
                                                                                  console.log(errorCode + ' - ' + errorMessage);
                                                                                  });
    
    // This is where it doesn't wanna work. Please check the first paragraph below
    // for the explanation of how it doesn't work.
    console.log('this message shouldn\'t show if there wasn\'t an error.'); //This fires before firebase.auth()... for some reason
    if(error) {
        console.log('there was an error');
        return false;
    } else {
        
        console.log('everything went fine');
        return true;
    }
    
}
</script>

@stop


