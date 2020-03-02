<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{

	protected $page_header = 'Categories Management';

	public function __construct()
	{
		parent::__construct();


		$this->load->model('Categories_model', 'categories');
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
		$data['panel_heading'] = 'Categories List';
		$data['page']         = '';

		$this->template->backend('categories_v', $data);
	}

	public function get_categories()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$list = $this->categories->get_datatables();
		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($list as $field) {
			$id = $field->KategoriID;

			$url_view   = 'view_data(' . $id . ');';
			$url_update = 'update_data(' . $id . ');';
			$url_delete = 'delete_data(' . $id . ');';

			$no++;
			$row = array();
			$row[] = ajax_button($url_view, $url_update, $url_delete);
			$row[] = $no;
			$row[] = $field->NamaKategori;
			$row[] = $field->Deskripsi;

			$data[] = $row;
		}

		$draw = isset($_POST['draw']) ? $_POST['draw'] : null;

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $this->categories->count_rows(),
			"recordsFiltered" => $this->categories->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}


	public function view()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$id = $this->input->post('KategoriID');

		$query = $this->categories->where('KategoriID', $id)->get();
		if ($query) {
			$data = array(
				'KategoriID' => $query->KategoriID,
				'NamaKategori' => $query->NamaKategori,
				'Deskripsi' => $query->Deskripsi,
			);
		}

		echo json_encode($data);
	}

	public function form_data()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$row = array();
		if ($this->input->post('KategoriID')) {
			$id      = $this->input->post('KategoriID');
			$query   = $this->categories->where('KategoriID', $id)->get();
			if ($query) {
				$row = array(
					'KategoriID'    => $query->KategoriID,
					'NamaKategori'   => $query->NamaKategori,
					'Deskripsi'   => $query->Deskripsi,
				);
			}
			$row = (object) $row;
		}

		$data = array(
			'hidden' => form_hidden('KategoriID', !empty($row->KategoriID) ? $row->KategoriID : ''),
			'NamaKategori' => form_input(array('name' => 'NamaKategori', 'id' => 'NamaKategori', 'class' => 'form-control', 'value' => !empty($row->NamaKategori) ? $row->NamaKategori : '')),
			'Deskripsi' => form_input(array('name' => 'Deskripsi', 'id' => 'Deskripsi', 'class' => 'form-control', 'value' => !empty($row->Deskripsi) ? $row->Deskripsi : ''))
		);

		echo json_encode($data);
	}


	public function save_shipper()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$rules = array(
			'insert' => array(
				// array('field' => 'KategoriID', 'label' => 'Kategori ID', 'rules' => 'required|is_unique[categories.KategoriID]|max_length[5]'),
				array('field' => 'NamaKategori', 'label' => 'Kategori Produk', 'rules' => 'trim|required|max_length[40]'),
				array('field' => 'Deskripsi', 'label' => 'Deskripsi', 'rules' => 'max_length[60]')
			),
			'update' => array(
				array('field' => 'KategoriID', 'label' => 'Kategori ID', 'rules' => 'required|max_length[5]'),
				array('field' => 'NamaKategori', 'label' => 'Kategori Produk', 'rules' => 'trim|required|max_length[40]'),
				array('field' => 'Deskripsi', 'label' => 'Deskripsi', 'rules' => 'max_length[60]')
			)
		);

		$row = array(
			'NamaKategori' => $this->input->post('NamaKategori'),
			'Deskripsi' => $this->input->post('Deskripsi')
		);

		$code = 0;

		if ($this->input->post('KategoriID') == null) {

			$this->form_validation->set_rules($rules['insert']);

			if ($this->form_validation->run() == true) {

				$this->categories->insert($row);

				$error =  $this->db->error();
				if ($error['code'] <> 0) {
					$code = 1;
					$notifications = $error['code'] . ' : ' . $error['message'];
				} else {
					$notifications = 'Success Insert Data';
				}
			} else {
				$code = 1;
				$notifications = validation_errors('<p>', '</p>');
			}
		} else {

			$this->form_validation->set_rules($rules['update']);

			if ($this->form_validation->run() == true) {

				$id = $this->input->post('KategoriID');

				$this->categories->where('KategoriID', $id)->update($row);

				$error =  $this->db->error();
				if ($error['code'] <> 0) {
					$code = 1;
					$notifications = $error['code'] . ' : ' . $error['message'];
				} else {
					$notifications = 'Success Update Data';
				}
			} else {
				$code = 1;
				$notifications = validation_errors('<p>', '</p>');
			}
		}

		$notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);

		echo json_encode(array('message' => $notifications, 'code' => $code));
	}

	public function delete()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}  

		$code = 0;

		$id = $this->input->post('KategoriID');

		$this->categories->where('KategoriID', $id)->delete();

		$error =  $this->db->error();
		if ($error['code'] <> 0) {
			$code = 1;
			$notifications = $error['code'] . ' : ' . $error['message'];
		} else {
			$notifications = 'Success Delete Data';
		}

		$notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);

		echo json_encode(array('message' => $notifications, 'code' => $code));
	}
}
