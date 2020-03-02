<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tempo_model extends MY_Model
{
	protected $column_order = array(null, 'subtransaksiID','ProdukID','harga', 'jumlahbeli','totalharga'); 
    protected $column_search = array('subtransaksiID','products.NamaProduk','products.HargaJual','products.Stok','jumlahbeli','totalharga');
    protected $order = array('subtransaksiID' => 'asc');
    private $_batchImport;

	public function __construct()
	{
        $this->table       = 'tempo';
        $this->primary_key = 'subtransaksiID';
        $this->fillable    = $this->column_order;
        $this->timestamps  = TRUE;

        $this->has_one['products'] = array('Products_model','ProdukID','ProdukID');

		parent::__construct();
    }
    
    public function total()
    {
        $this->db->select_sum('totalharga');
        $query = $this->db->get('tempo');
        if($query->num_rows()>0)
        {
            return $query->row()->totalharga;
        }
        else
        {
            return 0;
        }
    }

    public function setBatchImport($batchImport)
    {
        $this->_batchImport = $batchImport;
    }

    public function insertData($mytable)
    {
        $data = $this->_batchImport;
        $this->db->insert_batch($mytable, $data);
    }

    public function tampil()
    {
        return $this->db->get('tempo');
    }

    /*public function stokakhir($subtransaksiID)
    {
        $q = $this->db->query("SELECT jumlahbeli FROM tempo WHERE subtransaksiID='$subtransaksiID'");
        $row = $q->result();
        $total = $row->jumlahbeli;

        return $total;
    }*/

    private function _get_datatables_query()
    {
        
        $this->db->select($this->column_search);

        $this->db->from($this->table);
        $this->db->join('products', 'products.ProdukID=tempo.ProdukID');

        $i = 0;
        
        if(!empty($_POST['search']['value']))
        {
            foreach ($this->column_search as $item)
            {
                if($_POST['search']['value'])
                {
                    
                    if($i===0)
                    {
                        $this->db->group_start(); 
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }

                    if(count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
                $i++;
            }
        }
        
        if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();

        $length = isset($_POST['length']) ? $_POST['length'] : 0;
        if($length != -1){
        	$start  = isset($_POST['start']) ? $_POST['start'] : 0;        	
        	$this->db->limit($length, $start);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

}
/* End of file '/Products_model.php' */
/* Location: ./application/models/Products_model.php */
