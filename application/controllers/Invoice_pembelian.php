<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_pembelian extends CI_Controller {

   protected $page_header = 'Aplikasi Kasir';

   public function __construct()
   {
      parent::__construct();


	  $this->load->model(array('Invoicepem_model' => 'pembelian', 'Subtransaksi_model' => 'subtransaksi', 'Products_model' => 'produk'));
      $this->load->library(array('ion_auth', 'form_validation', 'template'));
      $this->load->helper(array('bootstrap_helper','html'));
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = 'Produk List';
		$data['page']         = '';
		
      $this->template->backend('invoice_p', $data);
	}

	public function get_invoice()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

		$penjualan = $this->pembelian->filter();

		// $id = date('ymdhis');
		$id = $penjualan->transaksiID;

		$query = $this->pembelian->where('transaksiID', $id)->get();
		$query1 = $this->subtransaksi->where('transaksiID', $id)->get_all();



		if ($query || $query1) {
			set_table(true);

			$No = array(
				'data' => 'No',
				'width' => '100px',
				'style' => 'padding: 10px 0 ;'
			);
			$Subtransaksi = array(
				'data' => 'Subtransaksi ID',
				'width' => '150px',
				'style' => 'padding: 10px 0 ;'
			);
			$Nama = array(
				'data' => 'Nama Produk',
				'width' => '150px',
				'style' => 'padding: 10px 0 ;'
			);
			$Qty = array(
				'data' => 'Qty',
				'width' => '100px',
				'style' => 'padding: 10px 0 ;'
			);
			$Total = array(
				'data' => 'Total Harga',
				'width' => '150px',
				'style' => 'padding: 10px 0 ;'
			);

			$this->table->set_heading($No, $Subtransaksi, $Nama, $Qty, $Total);

			$no = 1;

			foreach ($query1 as $row) {
				$produk = $row->ProdukID;

				$query3 = $this->produk->where('ProdukID', $produk)->get();

				$noo = array(
					'data' => $no++,
					'width' => '150px',
					'style' => 'padding: 10px 0 ;'
				);

				$this->table->add_row($noo, $row->subtransaksiID, $query3->NamaProduk, $row->jumlahbeli, 'Rp ' . number_format($row->totalharga));
			}

			$Grand = array(
				'data' => 'Grand Total',
				'width' => '100px',
				'style' => 'padding: 10px 0 ;'
			);

			$this->table->add_row('', '', '', $Grand, 'Rp ' . number_format($this->subtransaksi->total($id)));



			$subtransaksi = $this->table->generate();

			$data = array(
				'transaksiID' => $query->transaksiID,
				'totalharga' => $query->totalharga,
				'created_at' => $query->created_at,
				'subtransaksi' => $subtransaksi
			);
		}
		//file_put_contents('transaksi.json', json_encode($query1, JSON_PRETTY_PRINT));
		echo json_encode($data);

		// $data1['page']         = '';

		// $this->template->backend('invoice_v', $data1);
		// $this->load->view('backend/contents/invoice_v.php');


	}

}
