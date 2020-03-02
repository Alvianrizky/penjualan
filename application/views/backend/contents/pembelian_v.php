<!-- Content Header (Page header) -->
<style type="text/css">
	.form-inline123 {
		display: flex;
		flex-flow: row wrap;
		align-items: center;
	}

	.form-inline123 label {
		margin: 5px 10px 5px 0;
	}

	.form-inline123 p {
		vertical-align: middle;
		margin: 5px 10px 5px 0;
		padding: 10px;
	}

	@media print {

		#printPageButton,
		#back {
			display: none;
		}
	}
</style>
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
				<div class="box-header">
					<h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : ''; ?> </h3>
				</div><!-- /.box-header -->

				<div id="table-data">
					<div class="box-body">
						<form role="form" method="POST" action="" id="form-filter">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3">
										<input type="text" name="transaksiID" value="" class="form-control" id="transaksiID" placeholder="Transaksi ID">
									</div>
									<div class="col-lg-3">
										<input type="text" name="start_date" value="" class="form-control datepicker" id="start_date" placeholder="Start Date">
									</div>
									<div class="col-lg-3">
										<input type="text" name="end_date" value="" class="form-control datepicker" id="end_date" placeholder="End Date">
									</div>

								</div>
								<div class="row" style="margin-top: 20px; margin-left: 1px;">

									<button type="button" class="btn btn-primary" id="btn-filter" value="filter"><i class="fa fa-search fa-fw"></i>Filter</button>


									<button type="button" class="btn btn-primary" id="btn-cetak" value="filter">Cetak</button>


									<button type="button" id="btn-reset" class="btn btn-primary">Reset</button>

								</div>
							</div>
						</form>
						<div class="table-responsive" id="table-responsive">
							<table id="table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th style="width: 100px!important;">Action</th>
										<th>No</th>
										<th>Transaksi ID</th>
										<th>Total Harga</th>
									</tr>
								</thead>
								<tbody>
								</tbody>

								<tfoot>
									<tr>
										<th>Action</th>
										<th>No</th>
										<th>Transaksi ID</th>
										<th>Total Harga</th>
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
									<label>Transaksi ID</label>
									<div id="transaksiID"></div>
								</div>
								<div class="form-group">
									<label>Total Harga</label>
									<div id="totalharga"></div>
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
							<div class="col-lg-6" style="margin-bottom: 25px;">
								<button id="printPageButton" onClick="window.print();" class="btn btn-primary btn-sm">Print</button>

								<div class="form-inline123" style="margin-bottom: -25px;">
									<label style="margin-right:44px; ">Nama User</label>
									<p style="margin-right:1px; ">:</p>
									<?php echo $this->session->userdata('first_name'); ?>
								</div>
								<div class="form-inline123" style="margin-bottom: -25px;">
									<label style="margin-right:46px; ">Transaksi ID</label>
									:<p id="transaksiID"></p>
								</div>
								<div class="form-inline123">
									<label>Tanggal Transaksi</label>
									:<p id="created_at"></p>
								</div>

							</div>
							<div class="col-lg-12 table-responsive">
								<div id='subtransaksi'></div>
							</div>
						</div>
					</div>
					<div class="box-footer"><button type="button" name="back" id="back" class="btn btn-primary pull-right" onClick="table_data();">Back Button</button></div>
				</form>

			</div><!-- /.box -->
		</div>
		<!--/.col (right) -->
	</div> <!-- /.row -->


</section><!-- /.content -->


<script type="text/javascript">
	var site_url = site_url() + 'pembelian/';

	var table;
	$(document).ready(function() {

		table_data();

		table = $('#table').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": site_url + 'get_pembelian',
				"type": "POST",
				"data": function(data) {
					data.start_date = $('#start_date').val();
					data.end_date = $('#end_date').val();
					data.transaksiID = $('#transaksiID').val();
				}
			},

			"columnDefs": [{
				"targets": [0],
				"orderable": false,
			}, ],
		});

		$(function() {
			$(".datepicker").datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
				todayHighlight: true,
			});
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
				$('#Fax').html(data.Fax);
				$('#Email').html(data.Email);
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

		$('#btn-filter').click(function() { //button filter event click
			table.ajax.reload(); //just reload table
		});
		$('#btn-reset').click(function() { //button reset event click
			$('#form-filter')[0].reset();
			table.ajax.reload(); //just reload table
		});

	});

	function table_data() {
		$('#table-data').show();
		$('#form-data').hide();
		$('#form-view').hide();

		$('.box-title').text('Pembelian Management');
	}

	function form_data() {
		$('#hidden').empty();
		$('#NamaPerusahaan').empty();
		$('#NamaKontak').empty();
		$('#Alamat').empty();
		$('#Kota').empty();
		$('#KodePos').empty();
		$('#Telephone').empty();
		$('#Fax').empty();
		$('#Email').empty();

		$('#table-data').hide();
		$('#form-data').show();
		$('#form-view').hide();
	}

	function form_view() {
		$('p#hidden').empty();
		$('p#transaksiID').empty();
		$('p#created_at').empty();

		$('#table-data').hide();
		$('#form-data').hide();
		$('#form-view').show();

		$('.box-title').text('Detail Laporan');
	}

	function view_data(id) {
		$.post(site_url + 'view/', {
				'transaksiID': id
			}, function(data) {
				form_view();

				data = JSON.parse(data);
				$('p#hidden').html(data.hidden);
				$('p#transaksiID').html(data.transaksiID);
				$('p#created_at').html(data.created_at);
				$('#subtransaksi').html(data.subtransaksi);

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
				$('#Fax').html(data.Fax)
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
