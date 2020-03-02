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
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<button id="create" class="btn btn-primary btn-sm" title="Data Create" alt="Data Create"><i class="glyphicon glyphicon-plus"></i> Tambah Produk</button>
									
									<a href="<?php echo base_url() . 'index.php/products/cetak'; ?>" class="btn btn-primary btn-sm" id="btn-cetak" value="filter">Cetak</a>
								</div>
							</div>
						</div>
						<div class="table-responsive" id="table-responsive">
							<table id="table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th style="width: 100px!important;">Action</th>
										<th>No</th>
										<th>Kode Barang</th>
										<th>Nama Produk</th>
										<th>Supplier</th>
										<th>Kategori Produk</th>
										<th>Satuan</th>
										<th>Harga Beli</th>
										<th>Harga Jual</th>
										<th>Stok</th>
										<th>Terjual</th>
										<th>Reorder</th>
									</tr>
								</thead>
								<tbody>
								</tbody>

								<tfoot>
									<tr>
										<th>Action</th>
										<th>No</th>
										<th>Kode Barang</th>
										<th>Nama Produk</th>
										<th>Supplier</th>
										<th>Kategori Produk</th>
										<th>Satuan</th>
										<th>Harga Beli</th>
										<th>Harga Jual</th>
										<th>Stok</th>
										<th>Terjual</th>
										<th>Reorder</th>
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
								<div id="js-config"></div>

								<div class="form-group">
									<label>Nama Produk</label>
									<input type="hidden" id="ProdukID">
									<div id="NamaProduk"></div>
								</div>
								<div class="form-group">
									<label>Supplier ID</label>
									<div id="SupplierID"></div>
								</div>
								<div class="form-group">
									<label>Kategori Produk</label>
									<div id="KategoriID"></div>
								</div>
								<div class="form-group">
									<label>Satuan</label>
									<div id="Satuan"></div>
								</div>
								<div class="form-group">
									<label>HargaBeli</label>
									<div id="HargaBeli"></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Harga Jual</label>
									<div id="HargaJual"></div>
								</div>
								<div class="form-group">
									<label>Reorder</label>
									<div id="Reorder"></div>
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
									<label>Kode Produk</label>
									<p id="ProdukID"></p>
								</div>
								<div class="form-group">
									<label>Nama Produk</label>
									<p id="NamaProduk"></p>
								</div>
								<div class="form-group">
									<label>Supplier</label>
									<p id="SupplierID"></p>
								</div>
								<div class="form-group">
									<label>Kategori Produk</label>
									<p id="KategoriID"></p>
								</div>
								<div class="form-group">
									<label>Satuan</label>
									<p id="Satuan"></p>
								</div>
								<div class="form-group">
									<label>HargaBeli</label>
									<p id="HargaBeli"></p>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Stok</label>
									<p id="Stok"></p>
								</div>
								<div class="form-group">
									<label>Terjual</label>
									<p id="Terjual"></p>
								</div>
								<div class="form-group">
									<label>Reorder</label>
									<p id="Reorder"></p>
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
	var site_url = site_url() + 'products/';

	var table;
	$(document).ready(function() {

		table_data();

		table = $('#table').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": site_url + 'get_products',
				"type": "POST",
				"data": function(data) {
					data.start_date = $('#start_date').val();
					data.end_date = $('#end_date').val();
					data.ProdukID1 = $('#ProdukID1').val();
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

		$('#btn-filter').click(function() { //button filter event click
			table.ajax.reload(); //just reload table
		});
		$('#btn-reset').click(function() { //button reset event click
			$('#form-filter')[0].reset();
			table.ajax.reload(); //just reload table
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
					$('.box-title').text('Create Product');

					//data = JSON.parse(data);
					$('#hidden').html(data.hidden);
					$('#js-config').html(data.jsConfig);
					$('#ProdukID').html(data.ProdukID);
					$('#NamaProduk').html(data.NamaProduk);
					$('#SupplierID').html(data.SupplierID);
					$('#KategoriID').html(data.KategoriID);
					$('#Satuan').html(data.Satuan);
					$('#HargaBeli').html(data.HargaBeli);
					$('#HargaJual').html(data.HargaJual);
					$('#Reorder').html(data.Reorder);

					$(".chosen-select").chosen();
				}
			});
		});

		$('#submit').click(function() {
			$.ajax({
				url: site_url + 'save_product/',
				type: "POST",
				data: new FormData($('#form-data')[0]),
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
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error adding / update data');
				}
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

	});

	function table_data() {
		$('#table-data').show();
		$('#form-data').hide();
		$('#form-view').hide();

		$('.box-title').text('Product List');
	}

	function form_data() {
		$('#hidden').empty();
		$('#NamaProduk').empty();
		$('#SupplierID').empty();
		$('#KategoriID').empty();
		$('#Satuan').empty();
		$('#HargaBeli').empty();
		$('#Terjual').empty();
		$('#Reorder').empty();

		$('#table-data').hide();
		$('#form-data').show();
		$('#form-view').hide();
	}

	function form_view() {
		$('p#hidden').empty();
		$('p#ProdukID').empty();
		$('p#NamaProduk').empty();
		$('p#SupplierID').empty();
		$('p#KategoriID').empty();
		$('p#Satuan').empty();
		$('p#HargaBeli').empty();
		$('p#Stok').empty();
		$('p#Terjual').empty();
		$('p#Reorder').empty();

		$('#table-data').hide();
		$('#form-data').hide();
		$('#form-view').show();

		$('.box-title').text('View Product');
	}

	function view_data(id) {
		$.ajax({
			url: site_url + 'view/',
			data: {
				'ProdukID': id
			},
			cache: false,
			type: "POST",
			success: function(data) {
				form_view();

				data = JSON.parse(data);
				$('p#hidden').html(data.hidden);
				$('p#ProdukID').html(data.ProdukID);
				$('p#NamaProduk').html(data.NamaProduk);
				$('p#SupplierID').html(data.SupplierID);
				$('p#KategoriID').html(data.KategoriID);
				$('p#Satuan').html(data.Satuan);
				$('p#HargaBeli').html(data.HargaBeli);
				$('p#HargaJual').html(data.HargaJual);
				$('p#Stok').html(data.Stok);
				$('p#Terjual').html(data.Terjual);
				$('p#Reorder').html(data.Reorder);
			}
		});
	}

	function update_data(id) {
		$.ajax({
			url: site_url + 'form_data/',
			data: {
				'ProdukID': id
			},
			cache: false,
			type: "POST",
			success: function(data) {
				$(".chosen-select").chosen("destroy");
				form_data();
				$('.box-title').text('Update Product');

				data = JSON.parse(data);
				$('#hidden').html(data.hidden);
				$('#ProdukID').html(data.ProdukID);
				$('input[name=ProdukID]').prop('readonly', true);
				$('#NamaProduk').html(data.NamaProduk);
				$('#SupplierID').html(data.SupplierID);
				$('#KategoriID').html(data.KategoriID);
				$('#Satuan').html(data.Satuan);
				$('#HargaBeli').html(data.HargaBeli);
				$('#HargaJual').html(data.HargaJual);
				$('#Reorder').html(data.Reorder);
				$(".chosen-select").chosen();
			}
		});
	}

	function delete_data(id) {
		var agree = confirm("Are you sure you want to delete this item?");
		if (agree) {
			$.ajax({
				url: site_url + 'delete/',
				data: {
					'ProdukID': id
				},
				cache: false,
				type: "POST",
				dataType: "JSON", //Tidak Usah Memakai JSON.parse(data);
				success: function(data) {
					$('#notifications').append(data.message);
					if (data.code == 0) table.draw(false);
					table_data();
				}
			});
		} else
			return false;
	}
</script>
