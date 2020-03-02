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
                            <label class="col-sm-2 control-label">Name</label>
                            <p class="form-control-static"><?php echo isset($name) ? $name : '';?></p>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <p class="form-control-static"><?php echo isset($description) ? $description : '';?></p>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('groups/update/'.$id); ?>'">Edit Data</button> &nbsp; &nbsp; 
                    <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('groups'); ?>'">Back Button</button>
                </div>
            </form>
            
        </div><!-- /.box -->
    </div><!--/.col (right) -->
</div> <!-- /.row -->
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
                        <label>Name</label>
                        <input class="form-control" name="name" id="name" value = "<?php echo isset($name) ? $name : '';?>" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="description" class="form-control" name="description" id="description" value = "<?php echo isset($description) ? $description : '';?>" />
                    </div>
                    <!--
                    <div class="form-group">
                        <label>Status</label>
                        <?php
                            //echo form_dropdown('active', $actives, isset($active) ? set_value('active', $active) : '1', 'class="form-control" id="active"'); 
                        ?>                
                    </div>
                    -->
                </div>
                </div>
            </div>

            <div class="box-footer">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"> &nbsp; &nbsp; 
                <button type="reset" name="reset" class="btn btn-default">Reset Data</button>
                <button type="button" name="back" class="btn btn-primary pull-right" onClick="location.href='<?php echo site_url('groups'); ?>'">Back Button</button>
            </div>
        </form>
    </div><!-- /.box -->
    </div><!--/.col (right) -->
</div><!-- /.row -->
<?php
		break;

        default:
?>
<div class="row">
    <div class="col-lg-12">
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?></h3>
        </div><!-- /.box-header -->
            <div class="box-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <button id="add" class="btn btn-primary btn-sm" title="Data Add" alt="Data Add" onClick="location.href='<?php echo site_url('groups/create'); ?>'"><i class="glyphicon glyphicon-plus"></i> Add groups</button> 
                        </div>  
                    </div>
                </div>  
            
                <div class="table-responsive" id="table-responsive">               
                    <?php echo isset($table) ? $table : ''; ?>
                </div>
            </div>
    </div><!-- /.box -->
    </div><!--/.col (right) -->
</div><!-- /.row -->
<?php
        break;
    }
}
?>

</section><!-- /.content -->
