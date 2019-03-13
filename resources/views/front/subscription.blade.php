@extends('layouts.front.index')

@section('content')
  @include('dashboard.subscription.subscription')
@stop

@section('headercodes')
<link rel="stylesheet" type="text/css" media="screen" href="{{url('public/assets/css/subscription.css')}}?<?=date('YmdHis')?>">
@stop

@section('extracodes')

@stop
