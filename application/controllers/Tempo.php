<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tempo extends CI_Controller {

   protected $page_header = 'Aplikasi Penjualan';

   public function __construct()
   {
      parent::__construct();


      $this->load->model(array('Products_model'=>'produk', 'Tempo_model'=>'tempo','Transaksi_model' => 'transaksi', 'Penjualan_model' => 'penjualan'));
      $this->load->library(array('ion_auth', 'form_validation', 'templatekasir'));
      $this->load->helper(array('bootstrap_helper','html'));
   }

	public function index()
	{  
      
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group('members')) {
			redirect('auth/login', 'refresh');
		} 

      $data['page_header']   = $this->page_header;
      $data['panel_heading'] = 'Produk List';
      $data['page']         = '';
      $data['tampil'] = $this->tempo->as_object()->get_all();

      $this->templatekasir->backend('tempo_v', $data);
	}

   public function get_tempo()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group('members')) {
			redirect('auth/login', 'refresh');
		} 

      $list = $this->tempo->get_datatables();
      $data = array();
      $no = isset($_POST['start']) ? $_POST['start'] : 0;
      foreach ($list as $field) { 
         $id = $field->subtransaksiID;

         $url_view   = 'view_data('.$id.');';
         $url_update = 'update_data('.$id.');';
         $url_delete = 'delete_data('.$id.');';

         $no++;
         $row = array();
         
         $row[] = $no;
         $row[] = $field->NamaProduk;
         $row[] = "Rp ".number_format($field->HargaJual);
         $row[] = $field->jumlahbeli;
         $row[] = "Rp ".number_format($field->totalharga);
         $row[] = '<button type="button" name="id" class="btn btn-danger btn-sm" onClick="delete_data(' . $id . ');">Delete</button>';

         $data[] = $row;
      }

      
      $draw = isset($_POST['draw']) ? $_POST['draw'] : null;

      $output = array(
         "draw" => $draw,
         "recordsTotal" => $this->tempo->count_rows(),
         "recordsFiltered" => $this->tempo->count_filtered(),
         "data" => $data,
      );
      echo json_encode($output);
   }

   public function totalharga()
   {
      $data = array('total' => 'Rp '.number_format($this->tempo->total()));
      echo json_encode($data);
   }

   public function form_tambah()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group('members')) {
			redirect('auth/login', 'refresh');
		} 

      $opt_produk     = $this->produk->as_dropdown('NamaProduk')->get_all();
   
      $row = array();
      if($this->input->post('subtransaksiID')){
         $id      = $this->input->post('subtransaksiID');
         $query   = $this->tempo
                  ->with_products('fields:HargaJual')
                  ->where('subtransaksiID', $id)->get(); 
         if($query){
            $row = array(
            'subtransaksiID' => $query->subtransaksiID,
            'ProdukID'     => $query->ProdukID,
            'ProdukID'     => $query->products->HargaJual,
            'jumlahbeli'     => $query->jumlahbeli,
            'totalharga'     => $query->totalharga
            //'total'        => $this->tempo->total()
            );
         }
         $row = (object) $row;
      }

      $kode = "".date('ymdhis')."";

      $data = array('hidden'=> form_hidden('aksi', !empty($row->ProdukID) ? 'update' : 'create'),
             'subtransaksiID' => form_input(array('name'=>'subtransaksiID', 'id'=>'datepicker', 'class'=>'form-control', 'value'=>!empty($row->subtransaksiID) ? $row->subtransaksiID : '')),
             'ProdukID' => form_dropdown('ProdukID', $opt_produk, !empty($row->ProdukID) ? $row->ProdukID : '', 'class="form-control chosen-select"'),
             'jumlahbeli' => form_input(array('name'=>'jumlahbeli', 'id'=>'datepicker', 'class'=>'form-control', 'value'=>!empty($row->jumlahbeli) ? $row->jumlahbeli : '')),
             'total' => 'Rp '.number_format($this->tempo->total())
             //'total' => heading($row->total,1)
            );

      echo json_encode($data);
   }


   public function save_transaksi()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group('members')) {
			redirect('auth/login', 'refresh');
		} 

      // $id = $this->input->post('subtransaksiID');

      $field = $this->tempo->as_object()->get_all();
      //$field->result();
      $row1 = array();
      // $no = isset($_POST['start']) ? $_POST['start'] : 0;
      $xhr = 1;
      $kode = "".date('ymdhis')."";
      foreach($field as $row)
      {
			$data = array();

         $data['subtransaksiID'] = $row->subtransaksiID;
         $data['ProdukID'] = $row->ProdukID;
         $data['transaksiID'] = $kode;
         $data['jumlahbeli'] = $row->jumlahbeli;
         $data['totalharga'] = $row->totalharga;
         $data['created_at'] = $row->created_at;

			$row1[] = $data;
      }

      $data1 = array('transaksiID' => $kode,
                     'totalharga' => $this->tempo->total(),
            
         );

      // echo "<pre>";
      // print_r($row1);
      // exit();

      if(!empty($row)){
         $this->penjualan->insert($data1);
         $this->tempo->setBatchImport($row1);
         $this->tempo->insertData('subtransaksi');
         $this->db->empty_table('tempo');
     }

   }

   public function save_tempo()
   {   
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group('members')) {
			redirect('auth/login', 'refresh');
		} 
  
      $rules1 = array(
               'cek' => array('field' => 'ProdukID', 'label' => 'ProdukID', 'rules' => 'trim|is_unique[tempo.ProdukID]|max_length[30]')            
               );

      $id1      = $this->input->post('ProdukID');
      $query   = $this->produk->where('ProdukID', $id1)->get();

      $harga = $query->HargaJual;
      $total = $this->input->post('jumlahbeli');

      $kode = "".date('ymdhis')."";

      $totalharga = $harga * $total;
         
      $row = array('subtransaksiID' => $kode,
               'ProdukID'        => $this->input->post('ProdukID'),
               'harga'           => $harga,
               'jumlahbeli'      => $this->input->post('jumlahbeli'),
               'totalharga'      => $totalharga
               
      );

      $ProdukID = array('ProdukID' => $query->ProdukID);
      
      $query1   = $this->tempo->where($ProdukID)->get();
      
      if(!empty($query1))
      {
         $sub = $query1->totalharga;
         $jumlah = $query1->jumlahbeli;
         $jum = $jumlah + $this->input->post('jumlahbeli');

         $tot = $harga * $jum;
      
      $row3 = array(
            'jumlahbeli'      => $jum,
            'totalharga'      => $tot
            
         );
      }

		$stok = $query->Stok;
		$terjual = $query->Terjual;

		$stokakhir = $stok - $total;
		$terjualakhir = $terjual + $total; 

		$row2 = array('Stok' => $stokakhir,
						  'Terjual' => $terjualakhir);

      if($stok < $this->input->post('jumlahbeli'))
      {
			return "fail";
			
      }
      else{

         $this->form_validation->set_rules('ProdukID', 'ProdukID', 'trim|required|is_unique[tempo.ProdukID]|max_length[12]');

         if ($this->form_validation->run() == true) {
            
            $this->tempo->insert($row);
            $this->produk->where('ProdukID', $id1)->update($row2);
         }
         else{
            $id = $this->input->post('ProdukID');

            $this->tempo->where('ProdukID', $id)->update($row3);
            $this->produk->where('ProdukID', $id1)->update($row2);
         }

      }

      $total = 'Rp '.number_format($this->tempo->total());
      
      echo json_encode(array('total' => $total));
   }

   public function delete()
   {
      if (!$this->ion_auth->logged_in()){            
         redirect('auth/login', 'refresh');
		} elseif (!$this->ion_auth->in_group('members')) {
			redirect('auth/login', 'refresh');
		} 
      
      $code = 0;
      $total = 0;

      $id = $this->input->post('subtransaksiID');

      $query = $this->tempo->where('subtransaksiID', $id)->get();
      $produkID = $query->ProdukID;
      
      $query1   = $this->produk->where('ProdukID', $produkID)->get();
      $stok = $query1->Stok;
		$total = $query->jumlahbeli;
		$terjual = $query1->Terjual;

		$stokakhir = $stok + $total;
		$terjualakhir = $terjual - $total;

		$row2 = array('Stok' => $stokakhir,
						  'Terjual' => $terjualakhir);

     
      $this->tempo->where('subtransaksiID', $id)->delete();
      $this->produk->where('ProdukID', $produkID)->update($row2);

      $error =  $this->db->error();
      if($error['code'] <> 0){
         $code = 1;
         $notifications = $error['code'].' : '.$error['message'];
      }
      else{
         $notifications = 'Success Delete Data';
         $total = 'Rp '.number_format($this->tempo->total());
      }

      $notifications = ($code == 0) ? notifications('success', $notifications) : notifications('error', $notifications);
      
      echo json_encode(array('message' => $notifications, 'code' => $code, 'total' => $total));
   }

}
