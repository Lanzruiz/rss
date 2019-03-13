<nav class="navbar navbar-inverse navbar-static-top" id="navbar">
  <div class="container-fluid">
    <header class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="javascript:void(0)" class="navbar-brand desktop_logo nopadding" style="padding:5px 0 0 0">
       <img src="{{url('public/assets/images/main-logo.png')}}" class="img-responsive" width="200px"></a>
    </header>
    <div class="topnav">
      <div class="btn-group">
        <a href="javascript:" class="btn btn-success btn-sm">Welcome Commander</a>
        <button class="btn btn-primary btn-sm">Action<!--<i class="fa fa-power-off"></i>--></button>
        <button class="btn btn-metis-5 btn-sm dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right">
            <li><a href="{{url('/dashboard/profile')}}"><i class="fa fa-user"></i>&nbsp;&nbsp;Profile</a></li>
            <li><a href="{{url('/dashboard/logout')}}"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Logout</a></li>
        </ul>
      </div>
    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <!-- .nav -->
      <ul class="nav navbar-nav">
        <li class="mobile_logo"><a href="javascript:void(0)" class="navbar-brand" style="padding:0">
        <img src="{{url('public/assets/images/main-logo.png')}}" class="img-responsive" width="200px"></a></li>
        <li><a href="{{url('dashboard/users')}}"><i class="fa fa-users"></i> Dashboard</a></li>
        <li><a href="{{url('dashboard/archived')}}"><i class="fa fa-map-marker"></i> Archive Console</a></li>
        <li><a href="{{url('dashboard/console')}}"><i class="fa fa-map-marker"></i> Live Console</a></li>
        <li><a href="{{url('dashboard/sms')}}"><i class="fa fa-envelope"></i> SMS</a></li>
        <!--<li><a href="#"><i class="fa fa-table"></i> Records</a></li>-->
      </ul><!-- /.nav -->
    </div>
  </div><!-- /.container-fluid -->
</nav><!-- /.navbar -->