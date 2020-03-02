<!-- Sidebar user panel -->
<div class="user-panel">
	<div class="pull-left image">
		<img src="<?php echo base_url() . 'assets/'; ?>dist/img/sofia.png" class="img-circle" alt="User Image">
	</div>
	<div class="pull-left info">
		<p><?php echo $this->session->userdata('first_name'); ?></p>
		<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
	</div>
</div>

<!-- search form
<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>
 /.search form -->

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
	<li class="header">MENU UTAMA</li>
	<li>
		<a href="<?php echo site_url('tempo'); ?>">
			<i class="fa fa-users"></i> <span>Aplikasi Penjualan</span>
		</a>
	</li>
	<li class="header"></li>
	<li>
		<a href="<?php echo site_url('auth/logout'); ?>">
			<i class="fa fa-power-off"></i> <span>Logout</span>
		</a>
	</li>

</ul>
