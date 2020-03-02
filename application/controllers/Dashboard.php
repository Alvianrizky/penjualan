<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	protected $page_header = 'Daftar Restok Barang';

	public function __construct()
	{
		parent::__construct();


		$this->load->model(array('Categories_model' => 'categories', 'Suppliers_model' => 'suppliers', 'Products_model' => 'products', 'Dashboard_model'=>'dashboard'));
		$this->load->library(array('ion_auth', 'form_validation', 'template'));
		$this->load->helper('bootstrap_helper');
	}

	public function index()
	{

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$data['page_header']   = $this->page_header;
		$data['panel_heading'] = 'Produk List';
		$data['page']         = '';

		$this->template->backend('dashboard_v', $data);
	}

	public function get_dashboard()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$list = $this->dashboard->get_datatables();
		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($list as $field) {
			$id = $field->ProdukID;

			$url_view   = 'view_data(' . $id . ');';
			$url_update = 'update_data(' . $id . ');';
			$url_delete = 'delete_data(' . $id . ');';

			$no++;
			$row = array();
			// $row[] = ajax_button($url_view, $url_update, $url_delete);
			$row[] = $no;
			$row[] = $field->ProdukID;
			$row[] = $field->NamaProduk;
			$row[] = $field->HargaBeli;
			$row[] = $field->HargaJual;
			$row[] = $field->Stok;
			$row[] = $field->Reorder;

			$data[] = $row;
		}

		$draw = isset($_POST['draw']) ? $_POST['draw'] : null;

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $this->products->count_rows(),
			"recordsFiltered" => $this->products->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}
}
