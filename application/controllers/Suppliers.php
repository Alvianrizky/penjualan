<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

   protected $page_header = 'Suppliers Management';

   public function __construct()
   {
      parent::__construct();


      $this->load->model('suppliers_model', 'suppliers');
      $this->load->library(array('ion_auth', 'form_validation', 'template','pdf'));
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
      $data['panel_heading'] = 'Supplier List';
      $data['page']         = '';

      $this->template->backend('suppliers_v', $data);
	}

   public function get_suppliers()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $list = $this->suppliers->get_datatables();
      $data = array();
      $no = isset($_POST['start']) ? $_POST['start'] : 0;
      foreach ($list as $field) { 
         $id = $field->SupplierID;

         $url_view   = 'view_data('.$id.');';
         $url_update = 'update_data('.$id.');';
         $url_delete = 'delete_data('.$id.');';

         $no++;
         $row = array();
         $row[] = ajax_button($url_view, $url_update, $url_delete);
         $row[] = $no;
         $row[] = $field->NamaPerusahaan;
         $row[] = $field->NamaKontak;
         $row[] = $field->Alamat;
         $row[] = $field->Kota;
         $row[] = $field->KodePos;
         $row[] = $field->Telephone;
         $row[] = $field->Email;

         $data[] = $row;
      }
      
      $draw = isset($_POST['draw']) ? $_POST['draw'] : null;

      $output = array(
         "draw" => $draw,
         "recordsTotal" => $this->suppliers->count_rows(),
         "recordsFiltered" => $this->suppliers->count_filtered(),
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
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(15, 7, 'Telp :   +62 813 3818 0622', 0, 1);
		$pdf->Cell(15, 7, 'User : ' . $this->session->userdata('first_name') . '', 0, 1);
		// Memberikan space kebawah agar tidak terlalu rapat
		$pdf->Cell(10, 7, '', 0, 1);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(10, 7, 'Laporan Supplier', 0, 1);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 7, '', 0, 1);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 8, 'No', 1, 0, 'C');
		$pdf->Cell(55, 8, 'Perusahaan', 1, 0);
		$pdf->Cell(25, 8, 'Kontak', 1, 0);
		$pdf->Cell(65, 8, 'Alamat', 1, 0);
		$pdf->Cell(30, 8, 'Kota', 1, 0);
		$pdf->Cell(20, 8, 'Kode Pos', 1, 0);
		$pdf->Cell(30, 8, 'Telephone', 1, 0);
		$pdf->Cell(45, 8, 'Email', 1, 1);
		$pdf->SetFont('Arial', '', 10);

		// if (!empty($this->input->post('ProdukID1'))) {
		// 	$products = $this->products->where('ProdukID', $this->input->post('ProdukID1'))->get_all();
		// }
		// elseif (!empty($this->input->post('start_date')) && !empty($this->input->post('end_date'))) 
		// {
		// 	$where = array(
		// 		'DATE(created_at) >=' => $this->input->post('start_date'),
		// 		'DATE(created_at) <=' => $this->input->post('end_date')
		// 	);

		// 	$products = $this->products->where($where)->get_all();
		// } 
		// else {

		 	$suppliers = $this->suppliers->as_object()->get_all();
		// }

		$no = 1;
		foreach ($suppliers as $row) {
			
			$pdf->Cell(10, 8, $no++, 1, 0, 'C');
			$pdf->Cell(55, 8, $row->NamaPerusahaan, 1, 0);
			$pdf->Cell(25, 8, $row->NamaKontak, 1, 0);
			$pdf->Cell(65, 8, $row->Alamat, 1, 0);
			$pdf->Cell(30, 8, $row->Kota, 1, 0);
			$pdf->Cell(20, 8, $row->KodePos, 1, 0);
			$pdf->Cell(30, 8, $row->Telephone, 1, 0);
			$pdf->Cell(45, 8, $row->Email, 1, 1);
		}

		$kode = date('ymdhis');


		$pdf->Output("D","Transaksi" . $kode . ".pdf");
		// $this->fpdf->output("D", "Transaksi" . $kode . ".pdf");

		// redirect('tempo', 'refresh');
	}


   public function view()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $id = $this->input->post('SupplierID');

      $query = $this->suppliers->where('SupplierID', $id)->get();
      if($query){
         $data = array('SupplierID' => $query->SupplierID,
            'NamaPerusahaan' => $query->NamaPerusahaan,
            'NamaKontak' => $query->NamaKontak,
            'Alamat'      => $query->Alamat,
            'Kota'         => $query->Kota,
            'KodePos' => $query->KodePos,
            'Telephone'    => $query->Telephone,
            'Email'  => $query->Email);
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

      $row = array();
      if($this->input->post('SupplierID')){
         $id      = $this->input->post('SupplierID');
         $query   = $this->suppliers->where('SupplierID', $id)->get(); 
         if($query){
            $row = array(
               'SupplierID'    => $query->SupplierID,
               'NamaPerusahaan'   => $query->NamaPerusahaan,
               'NamaKontak'   => $query->NamaKontak,
               'Alamat'       => $query->Alamat,
               'Kota'          => $query->Kota,
               'KodePos'    => $query->KodePos,
               'Telephone'         => $query->Telephone,
               'Email'      => $query->Email
            );
         }
         $row = (object) $row;
      }

      $data = array('hidden'=> form_hidden('SupplierID', !empty($row->SupplierID) ? $row->SupplierID : ''),
             'NamaPerusahaan' => form_input(array('name'=>'NamaPerusahaan', 'id'=>'NamaPerusahaan', 'class'=>'form-control', 'value'=>!empty($row->NamaPerusahaan) ? $row->NamaPerusahaan : '')),
             'NamaKontak' => form_input(array('name'=>'NamaKontak', 'id'=>'NamaKontak', 'class'=>'form-control', 'value'=>!empty($row->NamaKontak) ? $row->NamaKontak : '')),
             'Alamat' => form_input(array('name'=>'Alamat', 'id'=>'Alamat', 'class'=>'form-control', 'value'=>!empty($row->Alamat) ? $row->Alamat : '')),
             'Kota' => form_input(array('name'=>'Kota', 'id'=>'Kota', 'class'=>'form-control', 'value'=>!empty($row->Kota) ? $row->Kota : '')),
             'KodePos' => form_input(array('name'=>'KodePos', 'id'=>'KodePos', 'class'=>'form-control', 'value'=>!empty($row->KodePos) ? $row->KodePos : '')),
             'Telephone' => form_input(array('name'=>'Telephone', 'id'=>'Telephone', 'class'=>'form-control', 'value'=>!empty($row->Telephone) ? $row->Telephone : '')),
             'Email' => form_input(array('name'=>'Email', 'id'=>'Email', 'class'=>'form-control', 'value'=>!empty($row->Email) ? $row->Email : ''))
            );

      echo json_encode($data);
   }


   public function save_shipper()
   {   
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
      }elseif (!$this->ion_auth->is_admin()) {
			redirect('auth/login', 'refresh');
		}

      $rules = array(
            'insert' => array(                     
                     // array('field' => 'SupplierID', 'label' => 'Supplier ID', 'rules' => 'required|is_unique[suppliers.SupplierID]|max_length[5]'),
                     array('field' => 'NamaPerusahaan', 'label' => 'Company Name', 'rules' => 'trim|required|max_length[40]'),                      
                     array('field' => 'Alamat', 'label' => 'Alamat', 'rules' => 'max_length[60]'),
                     array('field' => 'Kota', 'label' => 'Kota', 'rules' => 'max_length[15]'),
                     array('field' => 'KodePos', 'label' => 'KodePos', 'rules' => 'max_length[10]'),
                     array('field' => 'Telephone', 'label' => 'Telephone', 'rules' => 'max_length[24]')
                     ),
            'update' => array(
                     array('field' => 'SupplierID', 'label' => 'Supplier ID', 'rules' => 'required|max_length[5]'),
                     array('field' => 'NamaPerusahaan', 'label' => 'Company Name', 'rules' => 'trim|required|max_length[40]'),                      
                     array('field' => 'Alamat', 'label' => 'Alamat', 'rules' => 'max_length[60]'),
                     array('field' => 'Kota', 'label' => 'Kota', 'rules' => 'max_length[15]'),
                     array('field' => 'KodePos', 'label' => 'KodePos', 'rules' => 'max_length[10]'),
                     array('field' => 'Telephone', 'label' => 'Telephone', 'rules' => 'max_length[24]')
                     )                  
            );
        
      $row = array('NamaPerusahaan' => $this->input->post('NamaPerusahaan'),
            'NamaKontak' => $this->input->post('NamaKontak'),
            'Alamat'      => $this->input->post('Alamat'),
            'Kota'         => $this->input->post('Kota'),
            'KodePos' => $this->input->post('KodePos'),
            'Telephone'    => $this->input->post('Telephone'),
            'Email' => $this->input->post('Email'));

      $code = 0;

      if($this->input->post('SupplierID') == null){

         $this->form_validation->set_rules($rules['insert']);

         if ($this->form_validation->run() == true) {
            
            $this->suppliers->insert($row);

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

            $id = $this->input->post('SupplierID');

            $this->suppliers->where('SupplierID', $id)->update($row);
            
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

      $id = $this->input->post('SupplierID');

      $this->suppliers->where('SupplierID', $id)->delete();

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
