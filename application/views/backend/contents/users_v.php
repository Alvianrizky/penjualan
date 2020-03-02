<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo isset($page_header) ? $page_header : '';?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?></li>
    </ol>
</section> 

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
<?php 
if ($this->session->flashdata('success')) {
    echo notifications('success', $this->session->flashdata('success'));
}
if ($this->session->flashdata('error')) {
    echo notifications('error', $this->session->flashdata('error'));
}
if (validation_errors()) {
    echo notifications('warning', validation_errors('<p>', '</p>'));
}
?>

<?php
if(isset($page)){
    $this->session->set_flashdata('page', $page);
    $this->session->keep_flashdata('offset');
    $this->session->keep_flashdata('q');


    switch ($page) {
        case 'view':
?>
     <div class="row">
        <div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?></h3>
    </div><!-- /.box-header -->

            <form class="form-horizontal">
                <div class="box-body"> 
                    <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Username</label>
                            <p class="form-control-static"><?php echo isset($username) ? $username : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <p class="form-control-static"><?php echo isset($first_name) ? $first_name : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <p class="form-control-static"><?php echo isset($email) ? $email : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Company</label>
                            <p class="form-control-static"><?php echo isset($company) ? $company : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <p class="form-control-static"><?php echo isset($phone) ? $phone : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Level</label>
                            <p class="form-control-static"><?php echo isset($level) ? $level : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <p class="form-control-static"><?php echo isset($active) ? $active : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Last Login</label>
                            <p class="form-control-static"><?php echo isset($last_login) ? $last_login : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Created On</label>
                            <p class="form-control-static"><?php echo isset($created_on) ? $created_on : '';?></p>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('users/update/'.$id); ?>'">Edit Data</button> &nbsp; &nbsp; 
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('users'); ?>'">Back Button</button>
                </div>
            </form>
            </div><!-- /.box -->
        </div>
    </div>
<?php
        break;
    
        case 'add':
	   case 'update':
?>
    <div class="row">
        <div class="col-lg-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?></h3>
            </div><!-- /.box-header -->
            <form role="form" method="POST" action="<?php echo $action; ?>"> 
                <div class="box-body">
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" name="username" id="username" value = "<?php echo isset($username) ? $username : '';?>" />
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="first_name" id="first_name" value = "<?php echo isset($first_name) ? $first_name : '';?>" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" value = "<?php echo isset($email) ? $email : '';?>" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password" />
                        </div>
                        <div class="form-group">
                            <label>Retype Password</label>
                            <input type="Password" class="form-control" name="repassword" id="repassword" />
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value = "<?php echo isset($phone) ? $phone : '';?>" />
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control" name="company" id="company" value = "<?php echo isset($company) ? $company : '';?>" />
                        </div>
                        <div class="form-group">
                            <label>Group</label>
                            <?php 
                            echo form_dropdown('groups[]', $groups, isset($group) ? set_value('group', $group) : '1', 'class="form-control chosen-select" id="group" multiple="TRUE"'); 
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <?php
                                echo form_dropdown('active', $actives, isset($active) ? set_value('active', $active) : '1', 'class="form-control" id="active"'); 
                            ?>                
                        </div>
                    </div>
                    </div>
                </div>

                <div class="box-footer">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"> &nbsp; &nbsp; 
                    <button type="reset" name="reset" class="btn btn-default">Reset Data</button>
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('users'); ?>'">Back Button</button>
                </div>
            </form>
            </div><!-- /.box -->
        </div>
    </div>
<?php
		break;

        default:
?>
<!-- general form elements -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?></h3>
    </div><!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <button id="add" class="btn btn-primary btn-sm" title="Data Add" alt="Data Add" onClick="location.href='<?php echo site_url('users/create'); ?>'"><i class="glyphicon glyphicon-plus"></i> Add Users</button> 
                    </div>  

                    <div class="col-lg-6">
                        <form class="form-inline" role="form" method="post" id="search-form" name="search-form" action="<?php echo site_url('users'); ?>">
                            <div class="input-group pull-right">
                                <input type="text" name="q" value="" class="form-control" placeholder=""  />
                                <span class="input-group-btn">
                                <button name="search" type="submit" id="search" class="btn btn-default" ><i class="glyphicon glyphicon-search"></i> </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        
            <div class="table-responsive" id="table-responsive">               
                <?php echo isset($table) ? $table : ''; ?>
            </div>
        </div>
</div><!-- /.box -->
<?php
        break;
    }
}
?>

        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
