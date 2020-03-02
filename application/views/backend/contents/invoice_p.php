<style type="text/css">
	#form-data {
		display: none;
	}

	.form-inline {
		display: flex;
		flex-flow: row wrap;
		align-items: center;
	}

	.form-inline label {
		margin: 5px 10px 5px 0;
	}

	.form-inline p {
		vertical-align: middle;
		margin: 5px 10px 5px 0;
		padding: 10px;
	}

	@media print {
		#printPageButton {
			display: none;
		}
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
				<div class="box-header">
					<h3 class="box-title"> </h3>
					<div id="tampil">
						<p class="h5">Jl. Mandungan No 57 Srimartani, Piyungan, Bantul</p>
						<p class="h5">Telp : +62 813 3818 0622</p>
						<div class="form-inline" style="margin-bottom: -25px;">
							<label style="margin-right:46px; ">Transaksi ID</label>
							:<p id="transaksiID"></p>
						</div>
						<div class="form-inline">
							<label>Tanggal Transaksi</label>
							:<p id="created_at"></p>
						</div>
						<button id="printPageButton" onClick="window.print();" class="btn btn-primary btn-sm">Print</button>
					</div>

				</div><!-- /.box-header -->

				<div id="table-data">
					<div class="box-body">
						<div class="col-lg-12 table-responsive">
							<div id='subtransaksi'></div>
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

			</div><!-- /.box -->
		</div>
		<!--/.col (right) -->
	</div> <!-- /.row -->


</section><!-- /.content -->


<script type="text/javascript">
	var site_url = site_url() + 'invoice_pembelian/';

	var table;
	$(document).ready(function() {

		table_data();

		$('#create').click(function() {
			$.ajax({
				url: site_url + 'form_data/',
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data) {
					$(".chosen-select").chosen("destroy");
					form_data();
					$('.box-title').text('Create Barang');

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



		$('#dataTables').ready(function() {
			$.ajax({
				url: site_url + 'get_invoice/',
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data) {
					$(".chosen-select").chosen("destroy");
					form_data();
					$('.box-title').text('Sofia Cell');

					$('#transaksiID').html(data.transaksiID);
					$('#created_at').html(data.created_at);
					$('#subtransaksi').html(data.subtransaksi);

					$(".chosen-select").chosen();
				}

			});
		});

		window.onload = function() {
			var button = document.getElementById('printPageButton');
			setInterval(function() {
				button.click();
			}, 1000);
		}


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
						table_data();
						table.draw(true);
					}
				}

			});
			window.location = "Tempo";
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

		// $('#tampil').hide();
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
