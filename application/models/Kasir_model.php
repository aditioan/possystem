<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir_model extends CI_Model {
	private $table;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "sales_transaction";
		$this->select_default = 'sales_transaction.created_at AS created_at, sales_transaction.updated_at AS updated_at, sales_transaction.deleted_at AS deleted_at';
	}
	
	public function get_all(){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('*');
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer', 'left');
		$this->db->order_by("sales_transaction.created_at", "desc");
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->order_by("created_at", "desc")->get($this->table);
		return $query->num_rows();
	}
	public function get_all_array($filter = false){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if($filter){
			$query = $this->db->order_by("created_at", "desc")->get_where($this->table,$filter);
		}else{
			$query = $this->db->order_by("created_at", "desc")->get($this->table);
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('id_stransaction', 'DESC');

		$query = $this->db->get($this->table,1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert($this->table, $data);
	}
	public function update($id,$data){
		$this->db->where('id_stransaction', $id);
		$this->db->update($this->table, $data);
	}
	public function get_by_id($id){
		$response = false;
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get_where($this->table,array('id_stransaction' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_stransaction', $id);
		$this->db->update($this->table, array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete($this->table, array('id_stransaction' => $id));
	}
	public function get_detail($id){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$sql = "SELECT *, sales_transaction.created_at AS created_at, sales_transaction.updated_at AS updated_at, sales_transaction.deleted_at AS deleted_at 
				FROM sales_transaction 
				JOIN sales_data ON sales_transaction.id_sdata = sales_data.id_sdata 
				JOIN product ON product.id_product = sales_data.id_product 
				JOIN customer ON customer.id_customer = sales_transaction.id_customer 
				JOIN category ON category.id_category = product.id_category
				WHERE sales_data.id_sdata = '".$id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_filter_csv($filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('SELECT *, sales_transaction.created_at AS created_at, sales_transaction.updated_at AS updated_at, sales_transaction.deleted_at AS deleted_at');

		$this->db->join('sales_data', 'sales_transaction.id_sdata = sales_data.id_sdata');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		$this->db->join('product', 'product.id_product = sales_data.id_product');
		$this->db->join('category', 'category.id_category = product.id_category');
		
		$this->db->order_by("sales_transaction.created_at", "desc");
		
		$filter['type'] = '1';
		$this->db->where($filter);
		
		$query = $this->db->get($this->table);
		return $query->result_array();
	}

	public function get_filter($filter = '',$is_array = false){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('*');
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer', 'left');
		$this->db->order_by("sales_transaction.created_at", "desc");
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
	public function insert_purchase_data($data){
		$this->db->insert('sales_data', $data);
	}
	public function delete_purchase_data_trx_temp($id){
		$this->db->where('sales_id', $id);
		$this->db->update('sales_data', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete_purchase_data_trx($transaction_id){
		$this->db->delete('sales_data', array('id_sdata' => $transaction_id));
	}

	/*
	 * Tunggakan Disini
	 */
	public function count_total_filter_tunggakan($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$query = $this->db->order_by("created_at", "desc")->get_where($this->table,$filter);
		return $query->num_rows();
	}
	public function get_filter_tunggakan($filter = '',$limit_offset = array(),$is_array = false){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$this->db->select('*');
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer', 'left');
		$this->db->where($filter);
		if($limit_offset){
			$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
		}
		$query = $this->db->order_by($this->table.".created_at", "desc")->get($this->table);

		if($is_array){
			$resopnse = $query->result_array();
		}else{
			$resopnse = $query->result();
		}
		return $resopnse;
	}
}