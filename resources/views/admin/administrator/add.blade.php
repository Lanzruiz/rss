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
            <h1 class="m-0 text-dark">Administrator </h1>


          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{url('admin/settings')}}">Administrator</a></li>
              <li class="breadcrumb-item active">Add new</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
       <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action="{{url('admin/settings')}}">
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                  @if($errors->admin->first('name'))
                    <div class="text-danger">{!!$errors->admin->first('name')!!}</div>
                 @endif
                </div>
                <div class="form-group">
                  <label for="contact_no">Contact no</label>
                  <input type="text" class="form-control" id="contact_no" placeholder="Enter contact no" name="contact_no">
                  @if($errors->admin->first('contact_no'))
                    <div class="text-danger">{!!$errors->admin->first('contact_no')!!}</div>
                 @endif
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" autocomplete="new-email">
                  @if($errors->admin->first('email'))
                    <div class="text-danger">{!!$errors->admin->first('email')!!}</div>
                 @endif
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" autocomplete="new-password">
                  @if($errors->admin->first('password'))
                    <div class="text-danger">{!!$errors->admin->first('password')!!}</div>
                 @endif
                </div>


              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>

              {!! csrf_field() !!}

            </form>
          </div>
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
