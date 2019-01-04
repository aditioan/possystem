<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kongsinyasi_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$this->db->where('product.kongsinyasi !=', '0');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->join ('category', 'category.id_category = product.id_category');
        $query = $this->db->order_by("product.created_at", "desc")->get("product");
		return $query->result_array();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('kongsinyasi !=', '0');
		$query = $this->db->get("product");
		return $query->num_rows();
	}
	public function get_id_online(){
		$this->db->select('distinct(id_online)');
		$this->db->where('product.id_online !=', '');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
        $query = $this->db->get("product");
		return $query->result();
	}
	public function get_all_array($filter = ''){
		$this->db->select('product.id_product AS "Kode product", product.product_name AS "Nama product", product.product_phone AS "Telephon", product.product_address AS "Alamat product", product.created_at AS "Tanggal Pembuatan"');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('kongsinyasi !=', '0');
		if(!empty($filter)) {
			$query = $this->db->get_where("product",$filter);
		}else{
			$query = $this->db->get_where("product");
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->where('kongsinyasi !=', '0');
		$this->db->order_by('created_at', 'DESC');

		$query = $this->db->get("product",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('product', $data);
	}
	public function update($id,$data){
		$this->db->where('id_product', $id);
		$this->db->update('product', $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('product',array('id_product' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete($id){
		$this->db->where('id_product', $id);
		$this->db->update('product', array('product_qty' => '0', 'kongsinyasi' => '0'));
	}
	public function get_filter($filter = ''){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("product",$filter);
		}else{
			$query = $this->db->get("product");
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("product",$filter);
		}else{
			$query = $this->db->get("product");
		}
		return $query->num_rows();
	}
	public function get_pembelian($id_product){
		$this->db->select('*, purchase_transaction.created_at AS created_at, purchase_transaction.updated_at AS updated_at, purchase_transaction.deleted_at AS deleted_at');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('purchase_data', 'purchase_data.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('product', 'product.id_product = purchase_data.id_product');
		$this->db->join('product', 'product.id_product = purchase_transaction.id_product');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_product' => $id_product));
		return $query;
	}
	public function get_retur_pembelian($id_product){
		$this->db->select('*, purchase_retur.created_at AS created_at, purchase_retur.updated_at AS updated_at, purchase_retur.deleted_at AS deleted_at');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('purchase_retur', 'purchase_retur.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('purchase_retur_data', 'purchase_retur_data.id_pretur = purchase_retur.id_pretur');
		$this->db->join('product', 'product.id_product = purchase_retur_data.id_product');
		$this->db->join('product', 'product.id_product = purchase_transaction.id_product');
		return $this->db->get_where('purchase_transaction',array('purchase_transaction.id_product' => $id_product));
	}
	public function get_total_pembelian($id_product){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_product' => $id_product));
		return $query->row()->total_price;
	}
	public function get_total_utang($id_product){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_transaction.is_cash', '0');
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_product' => $id_product));
		return $query->row()->total_price;
	}
	public function get_total_retur_pembelian($id_product){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('purchase_retur', 'purchase_retur.id_ptransaction = purchase_transaction.id_ptransaction');
        $this->db->select_sum('purchase_retur.total_price');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_product' => $id_product));
		return $query->row()->total_price;
	}
}