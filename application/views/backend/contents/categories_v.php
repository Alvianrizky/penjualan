<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo isset($page_header) ? $page_header : ''; ?>
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"> <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?></li>
	</ol>
</section>


<!-- Main content -->
<section class="content">
	<div id="notifications"></div>

	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : ''; ?> </h3>
				</div><!-- /.box-header -->

				<div id="table-data">
					<div class="box-body">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<button id="create" class="btn btn-primary btn-sm" title="Data Create" alt="Data Create"><i class="glyphicon glyphicon-plus"></i> Tambah Kategori</button>
								</div>
							</div>
						</div>
						<div class="table-responsive" id="table-responsive">
							<table id="table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th style="width: 100px!important;">Action</th>
										<th>No</th>
										<th>Kategori Produk</th>
										<th>Deskripsi</th>
									</tr>
								</thead>
								<tbody>
								</tbody>

								<tfoot>
									<tr>
										<th>Action</th>
										<th>No</th>
										<th>Kategori Produk</th>
										<th>Deskripsi</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>

				<form role="form" method="POST" action="" id="form-data" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="col-lg-6">
								<div id="hidden"></div>
								<div class="form-group">
									<label>Kategori Produk</label>
									<div id="NamaKategori"></div>
								</div>
								<div class="form-group">
									<label>Deskripsi</label>
									<div id="Deskripsi"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button type="button" name="submit" id="submit" class="btn btn-primary">Submit Data</button> &nbsp; &nbsp;
						<button type="reset" name="reset" class="btn btn-default">Reset Data</button>

						<button type="button" name="back" class="btn btn-primary pull-right" onClick="table_data();">Back Button</button>
					</div>
				</form>

				<form role="form" method="POST" action="" id="form-view">
					<div class="box-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Kategori Produk</label>
									<p id="NamaKategori"></p>
								</div>
								<div class="form-group">
									<label>Deskripsi</label>
									<p id="Deskripsi"></p>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer"><button type="button" name="back" class="btn btn-primary pull-right" onClick="table_data();">Back Button</button></div>
				</form>

			</div><!-- /.box -->
		</div>
		<!--/.col (right) -->
	</div> <!-- /.row -->


</section><!-- /.content -->


<script type="text/javascript">
	var site_url = site_url() + 'categories/';

	var table;
	$(document).ready(function() {

		table_data();

		table = $('#table').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": site_url + 'get_categories',
				"type": "POST"
			},

			"columnDefs": [{
				"targets": [0],
				"orderable": false,
			}, ],
		});

		$('#create').click(function() {
			$.post(site_url + 'form_data/', function(data) {
				form_data();
				$('.box-title').text('Tambah Kategori');

				data = JSON.parse(data);
				$('#hidden').html(data.hidden);
				$('#NamaKategori').html(data.NamaKategori);
				$('#Deskripsi').html(data.Deskripsi);
			});
		});

		$('#submit').click(function() {
			$.post(site_url + 'save_shipper/', $('#form-data').serialize(), function(data) {
					if (data.code == 1) {
						$('#notifications').append(data.message);
					} else {
						$('#notifications').append(data.message);
						table_data();
						table.draw(false);
					}
				}, 'json')
				.fail(function(jqXHR, textStatus, errorThrown) {
					alert('Error adding / update data');
				});
		});

	});

	function table_data() {
		$('#table-data').show();
		$('#form-data').hide();
		$('#form-view').hide();

		$('.box-title').text('Kategori List');
	}

	function form_data() {
		$('#hidden').empty();
		$('#NamaKategori').empty();
		$('#Deskripsi').empty();

		$('#table-data').hide();
		$('#form-data').show();
		$('#form-view').hide();
	}

	function form_view() {
		$('p#hidden').empty();
		$('p#NamaKategori').empty();
		$('p#Deskripsi').empty();

		$('#table-data').hide();
		$('#form-data').hide();
		$('#form-view').show();

		$('.box-title').text('View Kategori');
	}

	function view_data(id) {
		$.post(site_url + 'view/', {
				'KategoriID': id
			}, function(data) {
				form_view();

				data = JSON.parse(data);
				$('p#hidden').html(data.hidden);
				$('p#NamaKategori').html(data.NamaKategori);
				$('p#Deskripsi').html(data.Deskripsi);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
			});
	}

	function update_data(id) {
		$.post(site_url + 'form_data/', {
				'KategoriID': id
			}, function(data) {
				form_data();
				$('.box-title').text('Update Kategori');

				data = JSON.parse(data);
				$('#hidden').html(data.hidden);
				$('#NamaKategori').html(data.NamaKategori);
				$('#Deskripsi').html(data.Deskripsi)
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
			});
	}

	function delete_data(id) {
		var agree = confirm("Are you sure you want to delete this item?");
		if (agree) {
			$.post(site_url + 'delete/', {
					'KategoriID': id
				}, function(data) {
					$('#notifications').append(data.message);
					if (data.code == 0) table.draw(false);
					table_data();
				}, 'json')
				.fail(function(jqXHR, textStatus, errorThrown) {
					alert('Error adding / update data');
				});
		} else
			return false;
	}
</script>
