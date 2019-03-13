<a href="index3.html" class="brand-link">
  <img src="{{url('public/assets/images/main-logo.png')}}" width="200">
</a>
<div class="sidebar">
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->


    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-cog"></i>
        <p>
          Administrator
          <i class="right fa fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{url('admin/settings/create')}}" class="nav-link">
            <i class="fa fa-circle-o nav-icon"></i>
            <p>New Administrator</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{url('admin/settings')}}" class="nav-link">
            <i class="fa fa-circle-o nav-icon"></i>
            <p>View Administrator</p>
          </a>
        </li>

      </ul>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-user-secret"></i>
        <p>
          Commander
          <i class="fa fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{url('admin/commander')}}" class="nav-link">
            <i class="fa fa-circle-o nav-icon"></i>
            <p>View Commander</p>
          </a>
        </li>

      </ul>
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-user-secret"></i>
        <p>
          Newsletter
          <i class="fa fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{url('admin/newsletter')}}" class="nav-link">
            <i class="fa fa-circle-o nav-icon"></i>
            <p>View Newsletter</p>
          </a>
        </li>
      </ul>
    </li>


      <li class="nav-item">
      <a href="{{url('admin/logout')}}" class="nav-link">
        <i class="nav-icon fa fa-user-secret"></i>
        <p>
          Logout

        </p>
      </a>

    </li>


  </ul>
</nav>
</div>
