@extends('layouts.admin.dashboard')

@section('content')
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        @include('admin.includes.header')

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

      <!-- Sidebar Menu -->
        @include('admin.includes.menu')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Commander </h1>


          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Commander</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">

      @if(Session::has('success'))
         <div class="alert alert-success">{{Session::get('success')}}</div>
      @endif

      @if(Session::has('error'))
         <div class="alert alert-danger">{{Session::get('error')}}</div>
      @endif


       <a href="{{url('admin/clean_all_feeds')}}" class="btn btn-danger btn-sm margin-bottom-10" onClick="return confirm(&quot;Are you sure you want to clean all feeds?\n\nPress OK to clean.\nPress Cancel to go back without cleaning the  feeds.\n&quot;)">Clean All Feeds</a>


      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Commander </h3>


              
            </div>


            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>

                  <th>Name</th>
                  <th>Email Address</th>
                  <th>Mobile</th>
                  <th>User name</th>
                  <th>Action</th>
                </tr>

                @foreach($users as $user)
                <tr>

                  <td><a href="{{url('/admin/commander/users/'. $user->fldUserID)}}" class="margin-right-10">{{$user->fldUsersFullname}}</a></td>
                  <td>{{$user->fldUsersEmail}}</td>
                  <td>{{$user->fldUsersMobile}}</td>
                  <td>{{$user->fldUsersUserName}}</td>
                  <td>
                      <a href="{{url('/admin/commander/users/'. $user->fldUserID)}}" class="margin-right-10"><i class="fa fa-folder"></i></a>


                </tr>
                @endforeach


              </tbody></table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  @include('admin.includes.footer')
</div>
<!-- ./wrapper -->
@stop
