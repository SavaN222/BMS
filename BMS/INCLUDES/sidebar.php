 <!-- Sidebar -->
    <ul class="navbar-nav black-bg sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dash.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-user-shield tomato-col"></i>
        </div>
        <div class="sidebar-brand-text mx-3 tomato-col ">BMS Admin</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="dash.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Admin Panel</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        BUSINESS CONTROL
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Work Place</span>
        <i class="fas fa-arrows-alt-v"></i>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="darkblue-bg py-2 collapse-inner rounded">
            <h6 class="collapse-header">Choose Option:</h6>
            <a class="collapse-item" href="creatework.php">Create Workplace</a>
            <a class="collapse-item" href="allworks.php">All Workplaces</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-user-friends"></i>
          <span>Employees</span>
          <i class="fas fa-arrows-alt-v"></i>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="darkblue-bg py-2 collapse-inner rounded">
            <h6 class="collapse-header">Choose Option:</h6>
            <a class="collapse-item" href="createprofile.php">Create an employee</a>
            <a class="collapse-item" href="allprofiles.php">All employees</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item"><a href="../landing/index.html" class="nav-link">
          <i class="fas fa-home"></i>
          <span>Landing Page</span>
      </a></li>
      <hr class="sidebar-divider">

    </ul>
    <!-- End of Sidebar -->