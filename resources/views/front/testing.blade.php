@extends('layouts.front.index')

@section('content')
<div id="testingPlayer"></div>

@stop

@section('headercodes')
<script src="{{url('public/assets/swfobject.min.js')}}"></script>
<script>
src = "rtmp://54.214.201.246/live/testing";
var flashvars={autoPlay:'true',src:escape(src),streamType:'live',scaleMode:'letterbox',};
var params={allowFullScreen:'true',allowScriptAccess:'always',wmode:'opaque'};
var attributes={id:'testingPlayer'};
swfobject.embedSWF('http://livewitnessapp.net/public/assets/player.swf','testingPlayer','300','300','10.2',null,flashvars,params,attributes);

</script>
@stop
