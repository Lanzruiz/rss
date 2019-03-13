@extends('layouts.front.index')

@section('content')

<div class="container" style="padding:0">
  <div class="panel panel-info">
  		<div class="panel-heading">
  			<h5 style="text-align:center; font-weight:bold;font-size:14px;">Download LiveWitness™</h5>
  		</div>
          	<br>
  	        <div class="col-lg-12">
  		        <!--<a href="itms-services://?action=download-manifest&url=https://witnessone.net/Apps/w1_agent/manifest.plist" class="thumbnail">-->
                  <a id="agentLogo" href="{{url('public/download/livewitness.apk')}}" class="thumbnail">
  		       <!-- <img src="images/App_Store_Icon.png" style="width:128px;"  alt="Download Agent" />-->
                  <img id="agentLogo2" src="{{url('public/assets/images/Android_Download.png')}}" style="width:128px;" alt="Download Agent">
  		        </a>
  	        </div>
  	</div>

<?php /*
<div class="panel panel-info">
  <div class="panel-heading">
    <h5 style="text-align:center; font-weight:bold;font-size:14px;">Download Transport</h5>
  </div>
        <br>
        <div class="col-lg-12">
          <!--<a href="itms-services://?action=download-manifest&url=https://witnessone.net/Apps/w1_agent/manifest.plist" class="thumbnail">-->
              <a id="agentLogo" href="{{url('public/download/transport.apk')}}" class="thumbnail">
         <!-- <img src="images/App_Store_Icon.png" style="width:128px;"  alt="Download Agent" />-->
              <img id="agentLogo2" src="{{url('public/assets/images/app_icon/t-light.png')}}" style="width:128px;" alt="Download Agent">
          </a>
        </div>
</div>
*/ ?>
<?php /*
<div class="panel panel-info">
  <div class="panel-heading">
    <h5 style="text-align:center; font-weight:bold;font-size:14px;">Download Agent</h5>
  </div>
        <br>
        <div class="col-lg-12">
          <!--<a href="itms-services://?action=download-manifest&url=https://witnessone.net/Apps/w1_agent/manifest.plist" class="thumbnail">-->
              <a id="agentLogo" href="{{url('public/download/agent.apk')}}" class="thumbnail">
         <!-- <img src="images/App_Store_Icon.png" style="width:128px;"  alt="Download Agent" />-->
              <img id="agentLogo2" src="{{url('public/assets/images/app_icon/a-light.png')}}" style="width:128px;" alt="Download Agent">
          </a>
        </div>
</div>
</div>
*/ ?>
@stop

@section('headercodes')

@stop
