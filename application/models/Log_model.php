<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all($table, $detail = ''){
		$this->db->select('*, '.$table.'.deleted_at AS deleted_at, '.$table.'.created_at AS created_at, '.$table.'.updated_at AS updated_at');
		$this->db->where($table.'.deleted_at !=', '0000-00-00 00:00:00');
		if ($detail == "tunggakan") {
			$this->db->where('is_cash', '0');
			$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		}
		if ($detail == "utang") {
			$this->db->where('is_cash', '0');
			$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		}
		if ($detail == "penjualan") {
			$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		}
		if ($detail == "pembelian") {
			$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		}
		$query = $this->db->get($table);
		return $query->result();
	}
	public function get_detail($table, $id_name, $id){
		$this->db->where($table.'.deleted_at !=', '0000-00-00 00:00:00');
		$this->db->where($table.'.'.$id_name, $id);
		if ($table == "purchase_transaction") {
			$this->db->join('purchase_data', 'purchase_data.id_ptransaction = purchase_transaction.id_ptransaction');
			$this->db->join('product', 'product.id_product = purchase_data.id_product');
			$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
			$this->db->join('category', 'category.id_category = product.id_category');
		}
		if ($table == "purchase_retur") {
			$this->db->join('purchase_retur_data', 'purchase_retur_data.id_pretur = purchase_retur.id_pretur');
			$this->db->join('product', 'product.id_product = purchase_retur_data.id_product');
			$this->db->join('category', 'category.id_category = product.id_category');
		}
		if ($table == "sales_transaction") {
			$this->db->join('sales_data', 'sales_data.id_stransaction = sales_transaction.id_stransaction');
			$this->db->join('product', 'product.id_product = sales_data.id_product');
			$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
			$this->db->join('category', 'category.id_category = product.id_category');
		}
		if ($table == "sales_retur") {
			$this->db->join('sales_retur_data', 'sales_retur_data.id_sretur = sales_retur.id_sretur');
			$this->db->join('product', 'product.id_product = sales_retur_data.id_product');
			$this->db->join('category', 'category.id_category = product.id_category');
		}
		$query = $this->db->get($table);
		return $query->result();
	}
	public function get_all_array($table, $filter = false){
		$this->db->where('deleted_at !=', '0000-00-00 00:00:00');
		if(!empty($filter)) {
			$query = $this->db->get_where($table, $filter);
		}else{
			$query = $this->db->get($table);
		}
		return $query->result_array();
	}
	public function get_filter($table,$filter = ''){
		$this->db->where('deleted_at !=', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where($table,$filter);
		}else{
			$query = $this->db->get($table);
		}
		return $query->result();
	}
	public function get_filter_tunggakan($filter = '',$limit_offset = array(),$is_array = false){
		$this->db->where('sales_transaction.deleted_at !=', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$this->db->select("*, sales_transaction.created_at AS created_at, sales_transaction.updated_at AS updated_at, sales_transaction.deleted_at AS deleted_at");
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer', 'left');
		$this->db->where($filter);
		if($limit_offset){
			$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
		}
		$query = $this->db->order_by("sales_transaction".".created_at", "desc")->get("sales_transaction");

		if($is_array){
			$resopnse = $query->result_array();
		}else{
			$resopnse = $query->result();
		}
		return $resopnse;
	}
	public function count_total_filter_tunggakan($filter = array()){
		$this->db->where('deleted_at !=', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$query = $this->db->order_by("deleted_at", "desc")->get_where("sales_transaction",$filter);
		return $query->num_rows();
	}
	public function count_total($table){
		$this->db->where('deleted_at !=', '0000-00-00 00:00:00');
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	public function count_total_filter($table,$filter = array()){
		$this->db->where('deleted_at !=', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where($table,$filter);
		}else{
			$query = $this->db->get($table);
		}
		return $query->num_rows();
	}
	public function update_hpp($id,$data){
		$this->db->where('id_product', $id);
		$this->db->update('product', $data);
	}
	public function return_data($table, $id_name, $id){
		$this->db->where($id_name, $id);
		$this->db->update($table, array('deleted_at' => '0000-00-00 00:00:00'));
		if ($table == "purchase_transaction") {
			$this->db->update("purchase_data", array('deleted_at' => '0000-00-00 00:00:00'));
		}
		if ($table == "sales_transaction") {
			$this->db->update("sales_data", array('deleted_at' => '0000-00-00 00:00:00'));
		}
	}
	public function delete_data($table, $id_name, $id){
		$this->db->delete($table, array($id_name => $id));
	}
}