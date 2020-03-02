<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

   protected $page_header = 'Produk Management';

   public function __construct()
   {
      parent::__construct();


      $this->load->model(array('Categories_model'=>'categories', 'Suppliers_model'=>'suppliers', 'Products_model'=>'products'));
      $this->load->library(array('ion_auth', 'form_validation', 'template', 'pdf'));
      $this->load->helper('bootstrap_helper');
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

      $this->template->backend('products_v', $data);
	}

   public function get_products()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $list = $this->products->get_datatables();
      $data = array();
      $no = isset($_POST['start']) ? $_POST['start'] : 0;
      foreach ($list as $field) { 
         $id = $field->ProdukID;

         $url_view   = 'view_data('.$id.');';
         $url_update = 'update_data('.$id.');';
         $url_delete = 'delete_data('.$id.');';

         $no++;
         $row = array();
         $row[] = ajax_button($url_view, $url_update, $url_delete);
         $row[] = $no;
         $row[] = $field->ProdukID;
         $row[] = $field->NamaProduk;
         $row[] = $field->NamaPerusahaan;
         $row[] = $field->NamaKategori;
         $row[] = $field->Satuan;
         $row[] = $field->HargaBeli;
			$row[] = $field->HargaJual;
			$row[] = $field->Stok;
			$row[] = $field->Terjual;
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

	public function cetak()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}


		$pdf = new FPDF('L', 'mm', 'A4'); //L = lanscape P= potrait
		// membuat halaman baru
		$pdf->AddPage();
		// setting jenis font yang akan digunakan
		$pdf->SetFont('Arial', 'B', 24);
		$ya = 44;
		// mencetak string 
		$pdf->Cell(15, 7, 'Sofia Cell', 0, 1);
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(15, 7, 'Jl. Mandungan No 57 Srimartani, Piyungan, Bantul', 0, 1);
		$pdf->Cell(15, 7, 'Telp :   +62 813 3818 0622', 0, 1);
		$pdf->Cell(15, 7, 'User : '. $this->session->userdata('first_name').'', 0, 1);
		
		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(10, 7, '', 0, 1);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(10, 7, 'Laporan Produk', 0, 1);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 7, '', 0, 1);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 8, 'No', 1, 0, 'C');
		$pdf->Cell(30, 8, 'Kode Produk', 1, 0);
		$pdf->Cell(60, 8, 'Nama Produk', 1, 0);
		// $pdf->Cell(35, 8, 'Supplier', 1, 0);
		// $pdf->Cell(35, 8, 'Kategori', 1, 0);
		$pdf->Cell(30, 8, 'Harga beli', 1, 0);
		$pdf->Cell(30, 8, 'Harga Jual', 1, 0);
		$pdf->Cell(25, 8, 'Stok', 1, 0);
		$pdf->Cell(25, 8, 'Terjual', 1, 1);
		$pdf->SetFont('Arial', '', 10);

		if (!empty($this->input->post('ProdukID1'))) 
		{
			$products = $this->products->where('ProdukID', $this->input->post('ProdukID1'))->get_all();
		} 
		// elseif (!empty($this->input->post('start_date')) && !empty($this->input->post('end_date'))) 
		// {
		// 	$where = array(
		// 		'DATE(created_at) >=' => $this->input->post('start_date'),
		// 		'DATE(created_at) <=' => $this->input->post('end_date')
		// 	);

		// 	$products = $this->products->where($where)->get_all();
		// } 
		else {

			$products = $this->products->as_object()->get_all();
			// $categories = $this->categories->as_object()->get();
			// $id = $products->SupplierID;
			// $id1 = $products->KategoriID;
			// $suppliers = $this->suppliers->where('SupplierID', $products->SupplierID)->get_all();
			// $categories = $this->categories->where('KategoriID', $products->KategoriID)->get();
			// $suppliers = $this->suppliers->as_object()->get();
		}

		$no = 1;
		foreach ($products as $row) {
			$pdf->Cell(10, 8, $no++, 1, 0, 'C');
			$pdf->Cell(30, 8, $row->ProdukID, 1, 0);
			$pdf->Cell(60, 8, $row->NamaProduk, 1, 0);
			// $pdf->Cell(35, 8, $suppliers->NamaPerusahaan, 1, 0);
			// $pdf->Cell(35, 8, $categories->NamaKategori, 1, 0);
			$pdf->Cell(30, 8, "Rp " . number_format($row->HargaBeli), 1, 0);
			$pdf->Cell(30, 8, "Rp " . number_format($row->HargaJual), 1, 0);
			$pdf->Cell(25, 8, $row->Stok, 1, 0);
			$pdf->Cell(25, 8, $row->Terjual, 1, 1);
		}

		$kode = date('ymdhis');


		$pdf->Output("D","Transaksi" . $kode . ".pdf");

		// redirect('tempo', 'refresh');
	}


   public function view()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $id = $this->input->post('ProdukID');

     $query = $this->products
         ->with_categories('fields:NamaKategori')
         ->with_suppliers('fields:NamaPerusahaan')
         ->where('ProdukID', $id)
         ->get();

      $data = array();
      if($query){
         $data = array('ProdukID' => $query->ProdukID,
            'NamaProduk' => $query->NamaProduk,
            'SupplierID' => $query->suppliers->NamaPerusahaan,
            'KategoriID' => $query->categories->NamaKategori,
            'Satuan'     => $query->Satuan,
            'HargaBeli'  => $query->HargaBeli,
				'HargaJual'  => $query->HargaJual,
				'Stok' => $query->Stok,
				'Terjual' => $query->Terjual,
            'Reorder' => $query->Reorder
         );
      }

      echo json_encode($data);
   }

   public function form_data()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $opt_supplier     = $this->suppliers->as_dropdown('NamaPerusahaan')->get_all();
      $opt_category     = $this->categories->as_dropdown('NamaKategori')->get_all();

      $row = array();
      if($this->input->post('ProdukID')){
         $id      = $this->input->post('ProdukID');
         $query   = $this->products->where('ProdukID', $id)->get(); 
         if($query){
            $row = array(
            'ProdukID'    => $query->ProdukID,
            'NamaProduk'   => $query->NamaProduk,
            'SupplierID'   => $query->SupplierID,
            'KategoriID'   => $query->KategoriID,
            'Satuan'       => $query->Satuan,
            'HargaBeli'    => $query->HargaBeli,
            'HargaJual'    => $query->HargaJual,
            'Reorder'    => $query->Reorder
            );
         }
         $row = (object) $row;
		}

		$kode = date('ymdhis');

      $data = array('hidden'=> form_hidden('action', !empty($row->ProdukID) ? 'update' : 'create'),
            'ProdukID' => form_input(array('name'=>'ProdukID', 'id'=>'ProdukID', 'class'=>'form-control', 'value'=>!empty($row->ProdukID) ? $row->ProdukID : $kode)),
             'NamaProduk' => form_input(array('name'=>'NamaProduk', 'id'=>'NamaProduk', 'class'=>'form-control', 'value'=>!empty($row->NamaProduk) ? $row->NamaProduk : '')),
             'SupplierID' => form_dropdown('SupplierID', $opt_supplier, !empty($row->SupplierID) ? $row->SupplierID : '', 'class="chosen-select"'),
             'KategoriID' => form_dropdown('KategoriID', $opt_category, !empty($row->KategoriID) ? $row->KategoriID : '', 'class="chosen-select"'),
             'Satuan' => form_input(array('name'=>'Satuan', 'id'=>'Satuan', 'class'=>'form-control', 'value'=>!empty($row->Satuan) ? $row->Satuan : '')),
             'HargaBeli' => form_input(array('name'=>'HargaBeli', 'id'=>'HargaBeli', 'class'=>'form-control', 'value'=>!empty($row->HargaBeli) ? $row->HargaBeli : '')),
            'HargaJual' => form_input(array('name'=>'HargaJual', 'id'=>'HargaJual', 'class'=>'form-control', 'value'=>!empty($row->HargaJual) ? $row->HargaJual : '')),
             'Reorder' => form_input(array('name'=>'Reorder', 'id'=>'Reorder', 'class'=>'form-control', 'value'=>!empty($row->Reorder) ? $row->Reorder : ''))
            );

      echo json_encode($data);
   }


   public function save_product()
   {   
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $rules = array(
            'insert' => array(                     
                     array('field' => 'NamaProduk', 'label' => 'Nama Produk', 'rules' => 'trim|required|max_length[40]'), 
                     array('field' => 'SupplierID', 'label' => 'Supplier', 'rules' => 'integer|max_length[11]'),                     
                     array('field' => 'KategoriID', 'label' => 'Kategori', 'rules' => 'integer|max_length[11]'),
                     array('field' => 'Satuan', 'label' => 'Satuan', 'rules' => 'max_length[20]'),
                     array('field' => 'Harga', 'label' => 'Harga', 'rules' => 'integer'),
                     array('field' => 'Reorder', 'label' => 'Reorder', 'rules' => 'integer|max_length[6]')
                     ),
            'update' => array(
                     array('field' => 'NamaProduk', 'label' => 'Company Name', 'rules' => 'trim|required|max_length[40]'), 
                     array('field' => 'SupplierID', 'label' => 'Supplier ID', 'rules' => 'integer|max_length[11]'),                     
                     array('field' => 'KategoriID', 'label' => 'KategoriID', 'rules' => 'integer|max_length[11]'),
                     array('field' => 'Satuan', 'label' => 'Satuan', 'rules' => 'max_length[20]'),
                     array('field' => 'Harga', 'label' => 'Harga', 'rules' => 'integer'),
                     array('field' => 'Reorder', 'label' => 'Reorder', 'rules' => 'integer|max_length[6]')
                     )                  
            );
        
      $row = array('ProdukID' => $this->input->post('ProdukID'),
            'NamaProduk' => $this->input->post('NamaProduk'),
            'SupplierID' => $this->input->post('SupplierID'),
            'KategoriID' => $this->input->post('KategoriID'),
            'Satuan'     => $this->input->post('Satuan'),
            'HargaBeli'  => $this->input->post('HargaBeli'),
            'HargaJual'  => $this->input->post('HargaJual'),
            'Reorder'    => $this->input->post('Reorder')
            );

      $code = 0;

      if($this->input->post('action') == 'create'){

         $this->form_validation->set_rules($rules['insert']);

         if ($this->form_validation->run() == true) {
            
            $this->products->insert($row);

            $error =  $this->db->error();
            if($error['code'] <> 0){
               $code = 1;
               $notifications = $error['code'].' : '.$error['message'];
            }
            else{
               $notifications = 'Success Insert Data';
            }
         }
         else{
            $code = 1;
            $notifications = validation_errors('<p>', '</p>'); 
         }

      }

      else{
         
         $this->form_validation->set_rules($rules['update']);

         if ($this->form_validation->run() == true) {

            $id = $this->input->post('ProdukID');

            $this->products->where('ProdukID', $id)->update($row);
            
            $error =  $this->db->error();
            if($error['code'] <> 0){               
               $code = 1;               
               $notifications = $error['code'].' : '.$error['message'];
            }
            else{               
               $notifications = 'Success Update Data';
            }
         }
         else{
            $code = 1;
            $notifications = validation_errors('<p>', '</p>'); 
         }
      }

      $notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);
      
      echo json_encode(array('message' => $notifications, 'code' => $code));
   }

   public function delete()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $code = 0;

      $id = $this->input->post('ProdukID');

      $this->products->where('ProdukID', $id)->delete();

      $error =  $this->db->error();
      if($error['code'] <> 0){
         $code = 1;
         $notifications = $error['code'].' : '.$error['message'];
      }
      else{
         $notifications = 'Success Delete Data';
      }

      $notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);
      
      echo json_encode(array('message' => $notifications, 'code' => $code));
   }
}
