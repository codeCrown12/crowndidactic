<?php
include_once ('../connection.php');
include_once ('../functions.php');
$selector = $_SESSION['email'];
$query = "SELECT Name, category, address, about, mobile, profileimg, temp_id FROM basicusers WHERE email = '$selector' ";
$user_result = $connection->query($query);
if (!$user_result) {
    die($connection->error);
}
$user_record = $user_result->fetch_array(MYSQLI_ASSOC);

?>
<aside class="main-sidebar sidebar-dark-primary elevation-1">
    <!-- Brand Logo -->
    <!-- <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $user_record['profileimg'];?>?randomurl=<?php echo rand();?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="../<?php echo get_fname($connection, $user_record['temp_id']) ?>/index?selector=<?php echo $_SESSION['email']?>" class="d-block" target="_blank"><strong><?php 
          if(strlen($user_record['Name']) > 14){
            echo substr($user_record['Name'], 0, 14)."...";
          }
          else echo $user_record['Name']; ?></strong></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="home" class="nav-link">
              <i class="far fa-user nav-icon"></i>
              <p>Profile</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="settings" class="nav-link">
              <i class="fas fa-cogs nav-icon"></i>
              <p>Settings</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Portfolio
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="templates" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                  <p>Templates</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="addgallery" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                  <p>Gallery</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="faqs" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                  <p>FAQs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="courses" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                  <p>Courses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="utilities" class="nav-link">
                <i class="fas fa-circle nav-icon"></i>
                  <p>Display</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item">
            <a href="feedbacks" class="nav-link">
            <i class="fas fa-sticky-note nav-icon"></i>
              <p>Send Feedback</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="applicants" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
              <p>Students</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../logout" class="nav-link">
              <i class="fas fa-power-off nav-icon"></i>
              <p>Logout</p>
            </a>
          </li>
          <li class="nav-header">More Features coming soon <i class="nav-icon fas fa-rocket"></i></li>
          <!-- <li class="nav-item">
            <a href="upgrade.php" class="nav-link">
              <i class="nav-icon fas fa-rocket"></i>
              <p>
                Upgrade
                <span class="right badge badge-success">Premium</span>
              </p>
            </a>
          </li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>