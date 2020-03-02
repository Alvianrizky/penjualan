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
									<button id="create" class="btn btn-primary btn-sm" title="Data Create" alt="Data Create"><i class="glyphicon glyphicon-plus"></i> Tambah Supplier</button>
									

									<a href="<?php echo base_url() . 'index.php/suppliers/cetak'; ?>" class="btn btn-primary btn-sm" id="btn-cetak" value="filter">Cetak</a>
								</div>
							</div>
						</div>

						<div class="table-responsive" id="table-responsive">
							<table id="table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th style="width: 100px!important;">Action</th>
										<th>No</th>
										<th>Perusahaan</th>
										<th>Kontak</th>
										<th>Alamat</th>
										<th>Kota</th>
										<th>Kode Pos</th>
										<th>Telephone</th>
										<th>Email</th>
									</tr>
								</thead>
								<tbody>
								</tbody>

								<tfoot>
									<tr>
										<th>Action</th>
										<th>No</th>
										<th>NamaPerusahaan</th>
										<th>NamaKontak</th>
										<th>Alamat</th>
										<th>Kota</th>
										<th>Kode Pos</th>
										<th>Telephone</th>
										<th>Email</th>
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
									<label>Nama Perusahaan</label>
									<div id="NamaPerusahaan"></div>
								</div>
								<div class="form-group">
									<label>Nama Kontak</label>
									<div id="NamaKontak"></div>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<div id="Alamat"></div>
								</div>
								<div class="form-group">
									<label>Kota</label>
									<div id="Kota"></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Kode Pos</label>
									<div id="KodePos"></div>
								</div>
								<div class="form-group">
									<label>Telephone</label>
									<div id="Telephone"></div>
								</div>
								<div class="form-group">
									<label>Email</label>
									<div id="Email"></div>
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
									<label>Nama Perusahaan</label>
									<p id="NamaPerusahaan"></p>
								</div>
								<div class="form-group">
									<label>Nama Kontak</label>
									<p id="NamaKontak"></p>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<p id="Alamat"></p>
								</div>
								<div class="form-group">
									<label>Kota</label>
									<p id="Kota"></p>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Kode Pos</label>
									<p id="KodePos"></p>
								</div>
								<div class="form-group">
									<label>Telephone</label>
									<p id="Telephone"></p>
								</div>
								<div class="form-group">
									<label>Email</label>
									<p id="Email"></p>
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
	var site_url = site_url() + 'suppliers/';

	var table;
	$(document).ready(function() {

		table_data();

		table = $('#table').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": site_url + 'get_suppliers',
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
				$('.box-title').text('Tambah Supplier');

				data = JSON.parse(data);
				$('#hidden').html(data.hidden);
				$('#NamaPerusahaan').html(data.NamaPerusahaan);
				$('#NamaKontak').html(data.NamaKontak);
				$('#Alamat').html(data.Alamat);
				$('#Kota').html(data.Kota);
				$('#KodePos').html(data.KodePos);
				$('#Telephone').html(data.Telephone);
				$('#Email').html(data.Email);
			});
		});

		$('#btn-cetak').click(function() {
			$.ajax({
				url: site_url + 'cetak/',
				type: "POST",
				data: new FormData($('#form-filter')[0]),
				dataType: "JSON",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					if (data.code == 1) {
						$('#notifications').append(data.message);
					} else {
						$('#notifications').append(data.message);
						table_data();
						table.draw(false);
					}
				}
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

		$('.box-title').text('Supplier List');
	}

	function form_data() {
		$('#hidden').empty();
		$('#NamaPerusahaan').empty();
		$('#NamaKontak').empty();
		$('#Alamat').empty();
		$('#Kota').empty();
		$('#KodePos').empty();
		$('#Telephone').empty();
		$('#Email').empty();

		$('#table-data').hide();
		$('#form-data').show();
		$('#form-view').hide();
	}

	function form_view() {
		$('p#hidden').empty();
		$('p#NamaPerusahaan').empty();
		$('p#NamaKontak').empty();
		$('p#Alamat').empty();
		$('p#Kota').empty();
		$('p#KodePos').empty();
		$('p#Telephone').empty();
		$('p#Email').empty();

		$('#table-data').hide();
		$('#form-data').hide();
		$('#form-view').show();

		$('.box-title').text('View Supplier');
	}

	function view_data(id) {
		$.post(site_url + 'view/', {
				'SupplierID': id
			}, function(data) {
				form_view();

				data = JSON.parse(data);
				$('p#hidden').html(data.hidden);
				$('p#NamaPerusahaan').html(data.NamaPerusahaan);
				$('p#NamaKontak').html(data.NamaKontak);
				$('p#Alamat').html(data.Alamat);
				$('p#Kota').html(data.Kota);
				$('p#KodePos').html(data.KodePos);
				$('p#Telephone').html(data.Telephone);
				$('p#Email').html(data.Email);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
			});
	}

	function update_data(id) {
		$.post(site_url + 'form_data/', {
				'SupplierID': id
			}, function(data) {
				form_data();
				$('.box-title').text('Update Supplier');

				data = JSON.parse(data);
				$('#hidden').html(data.hidden);
				$('#NamaPerusahaan').html(data.NamaPerusahaan);
				$('#NamaKontak').html(data.NamaKontak)
				$('#Alamat').html(data.Alamat);
				$('#Kota').html(data.Kota);
				$('#KodePos').html(data.KodePos);
				$('#Telephone').html(data.Telephone);
				$('#Email').html(data.Email);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
			});
	}

	function delete_data(id) {
		var agree = confirm("Are you sure you want to delete this item?");
		if (agree) {
			$.post(site_url + 'delete/', {
					'SupplierID': id
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
