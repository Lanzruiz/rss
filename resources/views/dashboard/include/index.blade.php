@extends('layouts.dashboard.index')

@section('content')  
<div id="text-overlay"></div>
<div id="text-frame"><h1></h1></div>
<!--<div id="overlay"></div>-->
<!--<div id="frame"><div id="location_now"></div><img src="" alt="" id="mainImage" class="img-responsive" /></div>-->
<div id="frame-video" style="width:400px; height: 400px;">
  <div class="col-lg-12" align="right">
      <span class="btn btn-warning btn-sm">Live Streaming - Transport</span><span id="videoClose" class="btn btn-danger btn-sm">X</span>
    </div>
    <div class="col-lg-12">
    <?php /*
      <div class="col-lg-12" id="tbUserVideoStreamer">

            <p style="color:#000; text-align:center">Streaming...</p>

            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                  <span class="sr-only"></span> 
              </div>

            </div>

        </div>
        */ ?>
      <div id="transportPlayerPopup" class="col-lg-12" style="z-index: 99999; height: 400px;"></div>
    </div>
</div>
<div id="aframe-video">
  <div class="col-lg-12" align="right">
      <span class="btn btn-success btn-sm">Live Streaming - Agent</span><span id="avideoClose" class="btn btn-danger btn-sm">X</span>
    </div>
  <div class="col-lg-12">
      <?php /*
      <div class="col-lg-12" id="abUserVideoStreamer">
            <p style="color:#000; text-align:center">Streaming...</p>
            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                <span class="sr-only"></span> 
              </div>
            </div>
        </div>
        */ ?>
     
      <div id="agentPlayerPopup"></div>      
      

    </div>
</div>
@include('dashboard.include.menu')
<div class="console">
   @include('dashboard.include.user')
   @include('dashboard.include.intMap')
   @include('dashboard.include.inttrMap') 
   @include('dashboard.include.buser')
</div>
@stop

@section('headercodes')
  
@stop