@extends('layouts.dashboard.dashboard')
@section('content')

<div class="row" style="margin-bottom: 40px;">
    <div class="col-md-12" >
        @include('dashboard.subscription.subscription')
    </div>
</div>

@stop

@section('headercodes')
  <link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/subscription.css')}}?<?=date('Ymdhis')?>">

@stop

@section('extracodes')
<script src="{{url('public/assets/toggle/bootstrap-toggle.min.js')}}"></script>
  
@stop
