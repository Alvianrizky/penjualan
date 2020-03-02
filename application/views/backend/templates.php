<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Administrator | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url().'assets/';?>bootstrap/css/bootstrap.min.css">
        <!-- Custom Fonts -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/select2/css/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/iCheck/flat/blue.css">
        <!-- DataTables CSS -->
        <link href="<?php echo base_url().'assets/'; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/datepicker/bootstrap-datepicker3.min.css">
        
        <!-- Daterange picker 
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/daterangepicker/daterangepicker-bs3.css">
        -->
        <!-- datetimepicker -->      
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/datetimepicker/css/bootstrap-datetimepicker.css"></link>
        <!-- chosen CSS -->
        <link href="<?php echo base_url().'assets/'; ?>plugins/chosen/chosen.min.css" rel="stylesheet">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        
        <script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jquery-3.3.1.min.js"></script>
        
        <script type="text/javascript">           
            function base_url() {
                return "<?php echo base_url().'index.php/'; ?>";
            }

            function site_url() {
                return "<?php echo site_url('/'); ?>";
            }

            function ConfirmDelete(url) 
            {
                var agree = confirm("Are you sure you want to delete this item?");
                if (agree)
                    return location.href =  url;
                else
                    return false ;
            };
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo site_url(); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>S</b>IM</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">Administrator</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation"> 
                <?php echo isset($navbar) ? $navbar : ''; ?>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <?php echo isset($sidebar) ? $sidebar : ''; ?>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php echo isset($content) ? $content : '' ?>
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.3.0
                </div>
                <strong>Copyright &copy; 2019-2020 <a href="http://almsaeedstudio.com">Sofia Cell</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <?php //echo isset($ctrlsidebar) ? $ctrlsidebar : '' ?>
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url().'assets/';?>bootstrap/js/bootstrap.min.js"></script>

        <!-- Select2 -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/select2/js/select2.full.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>plugins/dataTables/dataTables.bootstrap.js"></script>
         <!-- daterangepicker
        <script src="<?php echo base_url().'assets/'; ?>jquery.dataTables.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>dataTables.bootstrap.js"></script>
        -->
        <!-- datetimepicker -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/moment/moment-with-locales.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <!-- daterangepicker 
        <script src="<?php echo base_url().'assets/'; ?>plugins/daterangepicker/daterangepicker.js"></script>
        -->
        
        <script src="<?php echo base_url().'assets/'; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
        
        <script src="<?php echo base_url().'assets/'; ?>plugins/input-mask/jquery.inputmask.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>

        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- Chosen Plugin JavaScript -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>plugins/chosen/chosen.proto.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/'; ?>dist/js/app.min.js"></script>

    <script>
    $(document).ready(function() {    
        $('#dataTables').dataTable();

        $('[data-mask]').inputmask();
        $('.select2').select2();
        /*
        //Date picker
        $('#datepicker').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd',
          language:'id'
          //minViewMode: 'years'
        })

        //Date picker
        $('#birthdatepicker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd',
            startView: 'years',
            viewMode: 'years',
            language:'en'
        })
        */
        $('#datetimepicker').datetimepicker({
            locale : moment.locale('id'),
            format : 'YYYY-MM-DD HH:mm'
            //locale : 'id'
        });


        $('#birthpicker').datetimepicker({
            locale : moment.locale('id'),
            format : 'YYYY-MM-DD',
            viewMode: 'years'
            //locale : 'id'
        });

    }); 
    </script>
    <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"150%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    </script>

    </body>
</html>
