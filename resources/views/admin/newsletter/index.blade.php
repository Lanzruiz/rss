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
            <h1 class="m-0 text-dark">Newsletter </h1>


          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Newsletter</li>
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


       <a href="{{url('admin/newsletter/create')}}" class="btn btn-primary btn-sm margin-bottom-10 ">Add New</a>


      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Newsletter </h3>


              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">

                </div>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>


                @foreach($newsletter as $newsletters)
                <tr>
                  <td>{{$newsletters->fldNewsletterID}}</td>
                  <td><a href="{{url('/admin/newsletter/'.$newsletters->fldNewsletterID.'/edit')}}" class="margin-right-10">{{$newsletters->fldNewsletterName}}</a></td>

                  <td>
                      <a href="{{url('/admin/newsletter/'.$newsletters->fldNewsletterID.'/edit')}}" class="margin-right-10"><i class="fa fa-edit"></i></a>
                      <a href="{{url('/admin/newsletter/'.$newsletters->fldNewsletterID.'/delete')}}" class="margin-right-10" onClick="return confirm(&quot;Are you sure you want to delete this administrator?\n\nPress OK to delete.\nPress Cancel to go back without deleting the administrator.\n&quot;)"><i class="fa fa-trash"></i> </a>
                      <a href="{{url('/admin/newsletter/'.$newsletters->fldNewsletterID.'/send')}}" class="margin-right-10">Send Newsletter</a>
                  </td>

                </tr>
                @endforeach

                @if($newsletter->count() == 0)
                  <tr>
                      <td colspan="3" class="text-center text-danger">No Record Found</td>
                  </tr>
                @endif



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
