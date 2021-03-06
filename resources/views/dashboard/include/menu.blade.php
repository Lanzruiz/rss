<nav class="navbar navbar-inverse navbar-static-top" >
  <div class="container-fluid" id="DeviceResponsive">
        <header class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

           <a href="javascript:void(0)" class="navbar-brand mobile_logo">
           <img src="{{url('public/assets/images/main-logo.png')}}" class="img-responsive"></a>
        </header>


        <div class="col-lg-12" id="resTeamNameMobile"><span class="consoleName">{{$consoleTitle}}</span></div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-left top_menu_link ">
            <li class="desktop_logo">
            	<a href="{{url('dashboard/console')}}" class="navbar-brand"><img src="{{url('public/assets/images/main-logo.png')}}" class="img-responsive"></a></li>
            <li><a href="{{url('dashboard/users')}}" id="dashboard"><i class="fa fa-users"></i> Dashboard</a></li>
            @if($consoleTitle == ARCHIVEDCONSOLE)
               <li><a href="{{url('dashboard/console')}}"><i class="fa fa-map-marker"></i> Console</a></li>
            @else
              <li><a href="{{url('dashboard/archived')}}" id = "archive"><i class="fa fa-map-marker"></i> Archive</a></li>
            @endif
            <li><a href="{{url('dashboard/sms')}}"  id = "archive"><i class="fa fa-envelope"></i> SMS</a></li>
            @if($consoleTitle == ARCHIVEDCONSOLE)
               <li><a href="#" id="audioPopup"><i class="fa fa-headphones"></i> PTT</a></li>
            @else
               <li><a href="#" id="audioPopup"><i class="fa fa-headphones"></i> PTT</a></li>            
            @endif
            <!--<li><a href="#"><i class="fa fa-table"></i> Records</a></li>-->
            <li><a href="{{url('/dashboard/logout')}}"><i class="fa fa-power-off" style="color:#FFF"></i></a></li>

            <li style="background-color:#000" class="resTeamNameDesktop">
            	<a href="javascript:"><strong style="font-size:40px; color:#09C;"><span class="consoleName">{{$consoleTitle}}</span></strong></a></li>
            
             <li class="install-flash-notif"> <p><strong>You do not have Flash installed, or it is older than the required 10.0.0.</strong></p> <p><strong>Click below to install the latest version and then try again. <a target="_blank" href="https://www.adobe.com/go/getflashplayer">[ Download ]</a></strong></p> </li>
                  

            </ul>

            <ul class="nav navbar-nav navbar-right top_menu_link">

              <li><a href="#" id= "intro_start" "><i class="fa fa-question"></i> </a></li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>

                 <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#" id = "first-login-notif">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> Welcome to RSS! 
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
            </ul>

        </div>
  </div>
</nav>
