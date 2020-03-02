<style type="text/css">
	#form-data {
		display: none;
	}
</style>
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
					<h3 class="box-title"> </h3>
				</div><!-- /.box-header -->

				<div id="table-data">
					<div class="box-body">
						<div class="row">
							<div class="col-lg-8">
								<form role="form" method="POST" action="" id="form-tambah">
									<div class="box-body">
										<div class="row">
											<div class="col-lg-8">
												<div id="hidden"></div>
												<div id="js-config"></div>
												<div class="form-group">
													<label>Barang ID</label>
													<input type="hidden" id="subtransaksiID">
													<div id="HargaJual"></div>
													<div id="ProdukID"></div>
												</div>
												<div class="form-group">
													<label>Jumlah Beli</label>
													<div id="jumlahbeli"></div>
												</div>
											</div>
										</div>
										<button type="button" name="submit" id="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button> &nbsp; &nbsp;
										<button type="button" name="submit" id="simpan" class="btn btn-primary">Bayar Pesanan</button> &nbsp; &nbsp;
									</div>
								</form>
							</div>
							<div class="col-lg-4">
								<div class="card text-right" id="total" style="font-size: 50px;">
									<div id="tot"></div>
								</div>
							</div>
						</div>
						<div class="table-responsive" id="table-responsive">
							<table id="table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Barang</th>
										<th>Harga</th>
										<th>Jumlah Beli</th>
										<th>Total Harga</th>
										<th style="width: 100px!important;">Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>

								<tfoot>
									<tr>
										<th>No</th>
										<th>Nama Barang</th>
										<th>Harga</th>
										<th>Jumlah Beli</th>
										<th>Total Harga</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>

				<form role="form" method="POST" action="" id="form-data" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">

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
									<label>Barang ID</label>
									<p id="barangID"></p>
								</div>
								<div class="form-group">
									<label>Nama Barang</label>
									<p id="namabarang"></p>
								</div>
								<div class="form-group">
									<label>Nama Kategori</label>
									<p id="kategoriID"></p>
								</div>
								<div class="form-group">
									<label>Nama Supplier</label>
									<p id="supplierID"></p>
								</div>
								<div class="form-group">
									<label>Stok</label>
									<p id="stok"></p>
								</div>
								<div class="form-group">
									<label>Harga Beli</label>
									<p id="hargabeli"></p>
								</div>
								<div class="form-group">
									<label>Harga Jual</label>
									<p id="hargajual"></p>
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
	var site_url = site_url() + 'tempo_p/';

	var table;
	$(document).ready(function() {

		table_data();

		table = $('#table').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": site_url + 'get_tempo',
				"type": "POST"

			},

			"columnDefs": [{
				"targets": [0],
				"orderable": false,
			}, ],
		});

		$('#create').click(function() {
			$.ajax({
				url: site_url + 'form_data/',
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data) {
					$(".chosen-select").chosen("destroy");
					form_data();
					$('.box-title').text('Aplikasi Penjualan');

					//data = JSON.parse(data);
					$('#hidden').html(data.hidden);
					$('#js-config').html(data.jsConfig);
					$('#barangID').html(data.barangID);
					$('#namabarang').html(data.namabarang);
					$('#kategoriID').html(data.kategoriID);
					$('#supplierID').html(data.supplierID);
					$('#stok').html(data.stok);
					$('#hargabeli').html(data.hargabeli);
					$('#hargajual').html(data.hargajual);

					$(".chosen-select").chosen();
				}
			});
		});

		$('#form-tambah').ready(function() {
			$.ajax({
				url: site_url + 'form_tambah/',
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data) {
					$(".chosen-select").chosen("destroy");
					form_data();
					$('.box-title').text('Aplikasi Pembelian');

					//data = JSON.parse(data);
					$('#hidden').html(data.hidden);
					$('#js-config').html(data.jsConfig);
					$('#subtransaksiID').html(data.subtransaksiID);
					$('#ProdukID').html(data.ProdukID);
					$('#HargaJual').html(data.HargaJual);
					$('#jumlahbeli').html(data.jumlahbeli);
					$('#tot').html(data.total);

					$(".chosen-select").chosen();
				}
			});
		});

		$('#form-data').ready(function() {
			$.ajax({
				url: site_url + 'form_data/',
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data) {
					$(".chosen-select").chosen("destroy");
					form_data();
					$('.box-title').text('Aplikasi Pembelian');

					//data = JSON.parse(data);

					$('#subtransaksiID').html(data.subtransaksiID);
					$('#ProdukID').html(data.ProdukID);
					$('#HargaJual').html(data.HargaJual);
					$('#jumlahbeli').html(data.jumlahbeli);
					$('#totalharga').html(data.totalharga);

					$(".chosen-select").chosen();
				}
			});
		});


		$('#submit').click(function() {
			$.ajax({
				url: site_url + 'save_tempo/',
				type: "POST",
				data: new FormData($('#form-tambah')[0]),
				dataType: "JSON",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					if (data == "fail") {
						alert("Stok tidak mencukupi");
					}
					// if (data.code == 1) {
					// 	$('').append(data.message);
					// } else {
					// 	$('').append(data.message);
					// 	if (data.code == 0) {
					table.draw(false);
					$('#tot').html(data.total);
					// }
					table_data();
					// }
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Stok tidak mencukupi");
				}
			});
		});

		$('#simpan').click(function() {
			$.ajax({
				url: site_url + 'save_transaksi/',
				type: "POST",
				data: new FormData($('#form-tambah')[0]),
				dataType: "JSON",
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					if (data.code == 1) {
						$('').append(data.message);
					} else {
						$('').append(data.message);
						// table_data();
						table.draw(true);
					}
				}

			});

			window.location = "Tempo";
			window.open('invoice_pembelian');
		});

		$('#submit').on('keyup', function() {
			$.ajax({
				url: site_url + 'totalharga/',
				type: "POST",
				//data: new FormData($('#form-tambah')[0]),
				dataType: "JSON",
				contentType: true,
				cache: false,
				processData: false,
				success: function(data) {
					$('#tot').html(data.total);
				},
			});
		});

	});

	function table_data() {
		$('#table-data').show();
		$('#form-data').hide();
		$('#form-view').hide();

		$('.box-title').text('Barang List');
	}

	function form_data() {
		$('#hidden').empty();
		$('#barangID').empty();
		$('#namabarang').empty();
		$('#kategoriID').empty();
		$('#supplierID').empty();
		$('#stok').empty();
		$('#hargabeli').empty();
		$('#hargajual').empty();

		$('#table-data').show();
		$('#form-data').hide();
		$('#form-view').hide();
	}

	function form_tambah() {
		$('#hidden').empty();
		$('#subtransaksiID').empty();
		$('#barangID').empty();
		$('#hargajual').empty();
		$('#jumlahbeli').empty();

		$('#table-data').show();
		$('#form-data').hide();
		$('#form-view').hide();
	}


	function form_view() {
		$('p#hidden').empty();
		$('p#barangID').empty();
		$('p#namabarang').empty();
		$('p#kategoriID').empty();
		$('p#supplierID').empty();
		$('p#stok').empty();
		$('p#hargabeli').empty();
		$('p#hargajual').empty();

		$('#table-data').hide();
		$('#form-data').hide();
		$('#form-view').show();

		$('.box-title').text('Barang View');
	}

	function view_data(id) {
		$.ajax({
			url: site_url + 'view/',
			data: {
				'barangID': id
			},
			cache: false,
			type: "POST",
			success: function(data) {
				form_view();

				data = JSON.parse(data);
				$('p#hidden').html(data.hidden);
				$('p#barangID').html(data.barangID);
				$('p#namabarang').html(data.namabarang);
				$('p#kategoriID').html(data.kategoriID);
				$('p#supplierID').html(data.supplierID);
				$('p#stok').html(data.stok);
				$('p#hargabeli').html(data.hargabeli);
				$('p#hargajual').html(data.hargajual);
			}
		});
	}

	function update_data(id) {
		$.ajax({
			url: site_url + 'form_tambah/',
			data: {
				'subtransaksiID': id
			},
			cache: false,
			type: "POST",
			success: function(data) {
				$(".chosen-select").chosen("destroy");
				form_data();
				$('.box-title').text('Update Product');

				data = JSON.parse(data);
				$('#hidden').html(data.hidden);
				$('#js-config').html(data.jsConfig);
				$('#subtransaksiID').html(data.subtransaksiID);
				$('#barangID').html(data.barangID);
				$('#hargajual').html(data.hargajual);
				$('#jumlahbeli').html(data.jumlahbeli);
			}
		});
	}

	function delete_data(id) {
		var agree = confirm("Are you sure you want to delete this item?");
		if (agree) {
			$.ajax({
				url: site_url + 'delete/',
				data: {
					'subtransaksiID': id
				},
				cache: false,
				type: "POST",
				dataType: "JSON", //Tidak Usah Memakai JSON.parse(data);
				success: function(data) {
					$('').append(data.message);
					if (data.code == 0) {
						table.draw(false);
						$('#tot').html(data.total);
					}
					table_data();
				}
			});
		} else
			return false;
	}
</script>
