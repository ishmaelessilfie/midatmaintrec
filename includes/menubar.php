
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $user->Get_profile_image(); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p class="username"><?php echo $user->Get_profile_name(); ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php
                if($user->is_master_user())
                {
                ?>
                <li class=""><a href="home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="header">MANAGE</li>
        <li class="treeview"><a href="#"><i class="fa fa-calendar"></i> <span>Report</span>
           <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
           <ul class="treeview-menu">
            <li><a href="#maintenance_history" data-toggle="modal" rel="no-refresh"><i class="fa fa-circle-o link"></i> maintenace history</a></li>
            <li><a href="statistics" rel="no-refresh"><i class="fa fa-circle-o link"></i> branch statistics</a></li>
            <li><a href="zonal_statistics" rel="no-refresh"><i class="fa fa-circle-o link"></i> zonal statistics</a></li>
            <li><a href="maintenance_statistics" rel="no-refresh"><i class="fa fa-circle-o link"></i> maintenance statistics</a></li>
          </ul>

        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i>
            <span>Setup</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="user" rel="no-refresh"><i class="fa fa-circle-o link"></i> User</a></li>
            <li><a href="branch" rel="no-refresh"><i class="fa fa-circle-o link"></i> Branch</a></li>
            <li><a href="brand" rel="no-refresh"><i class="fa fa-circle-o link"></i> Brand</a></li>
            <li><a href="type" rel="no-refresh"><i class="fa fa-circle-o link"></i>Machine Type</a></li>
           <!--  <li><a href="technician" rel="no-refresh"><i class="fa fa-circle-o link"></i> Technician</a></li> -->
            <li><a href="machine" rel="no-refresh"><i class="fa fa-circle-o link"></i> Machine Registration</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Maintenance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <!-- <li><a href="machine"><i class="fa fa-circle-o"></i> Machine List</a></li> -->
             <li><a href="maintenance" rel="no-refresh"><i class="fa fa-circle-o link"></i> Maintenanace List</a></li>
          </ul>
        </li>
        <li><a href="sait"><i class="fa fa-clock-o"></i> S&IT <span id="sait_count" style=" border-radius: 50%;background: #FF6030; color:#fefefe;  right: 1;margin-left:5px;width: 20px;height: 20px; position: absolute; text-align: center" ><?php echo $user->Get_total_sait();?></span></a></li>
      <?php
          }
      ?>
      <?php

        if($user->is_tech())
      {
      ?>
      <li class=""><a href="home" rel="no-refresh"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="header">MANAGE</li>
      <li><a href="#maintenance_history" data-toggle="modal" rel="no-refresh"><i class="fa fa-history link"></i> maintenace history</a></li>
      <li><a href="maintenance"><i class="fa fa-wrench"></i> Maintenance</a></li>
      <li class="header"></li> 
            <li><a href="task"><i class="fa fa-tasks"></i> Task <span id="sait_count" style=" border-radius: 50%;background: #FF6030; color:#fefefe;  right: 1;margin-left:5px;width: 20px;height: 20px; position: absolute; text-align: center" ><?php echo $user->Get_total_task();?></span></a></li> 
      <?php
          }
      ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <?php include 'includes/maintenance_history_modal.php'; ?>