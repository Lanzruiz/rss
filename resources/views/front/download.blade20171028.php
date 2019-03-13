@extends('layouts.front.index')

@section('content')

<div class="container" style="padding:0">
   <?php /*
  <div class="panel panel-info">
  		<div class="panel-heading">
  			<h5 style="text-align:center; font-weight:bold;font-size:14px;">Download LiveWitness™</h5>
  		</div>
          	<br>
  	        <div class="col-lg-12">
  		        <!--<a href="itms-services://?action=download-manifest&url=https://witnessone.net/Apps/w1_agent/manifest.plist" class="thumbnail">-->
                  <a id="agentLogo" href="{{url('public/download/livewitness.apk')}}" class="thumbnail">
  		       <!-- <img src="images/App_Store_Icon.png" style="width:128px;"  alt="Download Agent" />-->
                  <img id="agentLogo2" src="{{url('public/assets/images/Android_Download.png')}}" style="width:128px;" alt="Download Android">
  		        </a>
  	        </div>
  	</div>
    */ ?>




<div class="panel panel-info">
  <div class="panel-heading">
    <h5 style="text-align:center; font-weight:bold;font-size:14px;">Download Transport</h5>
  </div>
        <br>
        <div class="col-lg-12">
          <!--<a href="itms-services://?action=download-manifest&url=https://witnessone.net/Apps/w1_agent/manifest.plist" class="thumbnail">-->
              <a id="agentLogo" href="{{url('public/download/livewitness_trans.apk')}}" class="thumbnail">
         <!-- <img src="images/App_Store_Icon.png" style="width:128px;"  alt="Download Agent" />-->
              <img id="agentLogo2" src="{{url('public/assets/images/app_icon/t-light.png')}}" style="width:128px;" alt="Download Transport">
          </a>
        </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">
    <h5 style="text-align:center; font-weight:bold;font-size:14px;">Download Agent</h5>
  </div>
        <br>
        <div class="col-lg-12">
          <!--<a href="itms-services://?action=download-manifest&url=https://witnessone.net/Apps/w1_agent/manifest.plist" class="thumbnail">-->
              <a id="agentLogo" href="{{url('public/download/livewitness_agent.apk')}}" class="thumbnail">
         <!-- <img src="images/App_Store_Icon.png" style="width:128px;"  alt="Download Agent" />-->
              <img id="agentLogo2" src="{{url('public/assets/images/app_icon/a-light.png')}}" style="width:128px;" alt="Download Agent">
          </a>
        </div>
</div>



  <div class="panel panel-info">
      <div class="panel-heading">
        <h5 style="text-align:center; font-weight:bold;font-size:14px;">iOS Transport</h5>
      </div>
            <br>
            <div class="col-lg-12">
                  <?php /*<a id="agentLogo" href="{{url('public/download/livewitness.ipa')}}" class="thumbnail">*/ ?>
                    <a href="itms-services://?action=download-manifest&url={{url('public/download/ipa/LWTmanifest.plist')}}" class="thumbnail">


                  <?php /*<a id="agentLogo" href="{{url('public/download/ipa/LiveWitnessTrans.ipa')}}" class="thumbnail">*/ ?>
                  <img id="agentLogo2" src="{{url('public/assets/images/app_icon/t-light.png')}}" style="width:128px;" alt="iOS Transport">
              </a>
            </div>
    </div>

  <div class="panel panel-info">
      <div class="panel-heading">
        <h5 style="text-align:center; font-weight:bold;font-size:14px;">iOS Agent</h5>
      </div>
            <br>
            <div class="col-lg-12">
                  <?php /*<a id="agentLogo" href="{{url('public/download/livewitness.ipa')}}" class="thumbnail">*/ ?>
                    <a href="itms-services://?action=download-manifest&url={{url('public/download/ipa/LWAmanifest.plist')}}" class="thumbnail">

                  <?php /*<a id="agentLogo" href="{{url('public/download/ipa/LiveWitnessAgent.ipa')}}" class="thumbnail" itms-services://?action=download-manifest&url={{url('public/download/ipa/LWAmanifest.plist')}}>*/ ?>
                  <img id="agentLogo2" src="{{url('public/assets/images/app_icon/a-light.png')}}" style="width:128px;" alt="iOS Agent">
              </a>
            </div>
    </div>





<div class="panel panel-info">
    <div class="panel-heading">
      <h5 style="text-align:center; font-weight:bold;font-size:14px;">LWWT Trans</h5>
    </div>
          <br>
          <div class="col-lg-12">

                <a href="itms-services://?action=download-manifest&url={{url('public/download/ipa/LWWT/Transportmanifest.plist')}}" class="thumbnail">
                <img id="agentLogo2" src="{{url('public/assets/images/app_icon/lwwt_tansport.jpg')}}" style="width:128px;" alt="LWWT Trans">
            </a>
          </div>
  </div>





<div class="panel panel-info">
    <div class="panel-heading">
      <h5 style="text-align:center; font-weight:bold;font-size:14px;">LWWT Agent</h5>
    </div>
          <br>
          <div class="col-lg-12">

                <a href="itms-services://?action=download-manifest&url={{url('public/download/ipa/LWWT/Agentmanifest.plist')}}" class="thumbnail">
                <img id="agentLogo2" src="{{url('public/assets/images/app_icon/lwwt_agent.jpg')}}" style="width:128px;" alt="LWWT Agent">
            </a>
          </div>
  </div>


</div>



@stop

@section('headercodes')

@stop
