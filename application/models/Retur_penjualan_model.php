<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_penjualan_model extends CI_Model {
	private $table;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "sales_retur";
		$this->table_data = "sales_retur_data";
		$this->select_default = '*, sales_retur.created_at AS created_at, sales_retur.updated_at AS updated_at, sales_retur.deleted_at AS deleted_at';
	}
	
	public function get_all(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->select($this->select_default);
		$this->db->order_by("created_at", "desc");
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
	public function get_all_array(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->order_by("created_at", "desc")->get($this->table);
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('id_sretur', 'DESC');

		$query = $this->db->get($this->table,1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert($this->table, $data);
	}
	public function insert_retur_data($data){
		$this->db->insert($this->table_data, $data);
	}
	public function update($id,$data){
		$this->db->where('id_sretur', $id);
		$this->db->update($this->table, $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where($this->table,array('id_sretur' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_sretur', $id);
		$this->db->update('sales_retur', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete($this->table, array('id_sretur' => $id));
	}
	public function delete_data_temp($id_sretur){
		$this->db->where('id_sretur', $id_sretur);
		$this->db->update('sales_retur_data', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete_data($id_sdata){
		$this->db->delete("sales_data", array('id_sdata' => $id_sdata));
	}
	public function get_detail($id_sdata){
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$sql = "SELECT *, sales_retur.created_at AS created_at, sales_retur.updated_at AS updated_at, sales_retur.deleted_at AS deleted_at FROM sales_retur 
				JOIN sales_data ON sales_retur.id_sdata = sales_data.id_sdata
				JOIN product ON product.id_product = sales_data.id_product 
				JOIN category ON category.id_category = product.id_category 
				WHERE sales_data.id_sdata = '".$id_sdata."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_detail_by_id($id){
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$sql = "SELECT *, sales_retur.created_at AS created_at, sales_retur.updated_at AS updated_at, sales_retur.deleted_at AS deleted_at FROM sales_retur 
				JOIN sales_retur_data ON sales_retur.id_sretur = sales_retur_data.id_sretur
				JOIN product ON product.id_product = sales_retur_data.id_product 
				JOIN category ON category.id_category = product.id_category 
			  	WHERE sales_retur.id_sretur = '".$id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_filter($filter = '',$is_array = false){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->select($this->select_default);
		$this->db->order_by("created_at", "desc");
		if(!empty($filter)){
			$this->db->where($filter);
			$query = $this->db->get($this->table);
		}else{
			$query = $this->db->get($this->table);
		}
		if($is_array){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where($this->table,$filter);
		}else{
			$query = $this->db->get($this->table);
		}
		return $query->num_rows();
	}
	public function get_all_not_returned(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get_where($this->table,array("is_return" => "0"));
		return $query->result();
	}
	public function get_filter_csv($filter = ''){
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('sales_retur.id_sretur AS "Kode Retur", sales_retur.id_stransaction AS "Kode Transaksi", customer.id_customer AS "Kode Pelanggan", customer.customer_name AS "Nama Pelanggan", customer.customer_phone AS "Telephon", customer.customer_address AS "Alamat Pelanggan", sales_retur.total_item AS "Total Barang", sales_retur.total_price AS "Total Harga", sales_retur.return_by AS "Bentuk Retur", sales_retur.created_at AS "Tanggal Retur"');

		$this->db->join('sales_transaction', 'sales_transaction.id_stransaction = sales_retur.id_stransaction');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		
		$this->db->order_by("sales_retur.created_at", "desc");
		if ($filter != '') {
			$this->db->where($filter);
		}
		
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
}