<div id="wrapper">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="brand">
    <span><?php echo $this->session->userdata('name'); ?></span>
  </div>
  <div class="container-fluid">
    <div class="navbar-btn">
      <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
    </div>
    <div id="navbar-menu">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span><?php echo $this->session->userdata('name_user'); ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url(); ?>login/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div id="sidebar-nav" class="sidebar">
  <div class="sidebar-scroll">
    <nav>
      <ul class="nav">
        <li><a href="<?php echo base_url(); ?>home"><i class="lnr lnr-home"></i> <span>Home</span></a></li>
        <li>
          <a href="#dt_master" data-toggle="collapse" class="collapsed"><i class="lnr lnr-database"></i> <span>Data Master</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
          <div id="dt_master" class="collapse ">
            <ul class="nav">
              <li><a href="<?php echo base_url(); ?>user"></i> <span>User</span></a></li>
              <li><a href="<?php echo base_url(); ?>employee"></i> <span>Data Pegawai</span></a></li>
              <li><a href="<?php echo base_url(); ?>Location"></i> <span>Lokasi Kerja</span></a></li>
            </ul>
          </div>
        </li>
        <li><a href="<?php echo base_url(); ?>report"><i class="lnr lnr-calendar-full"></i> <span>Report</span></a></li>
      </ul>
    </nav>
  </div>
</div>