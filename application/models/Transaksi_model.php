<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {
	private $table;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "purchase_transaction";
		$this->select_default = '*, purchase_transaction.created_at AS created_at, purchase_transaction.updated_at AS updated_at, purchase_transaction.deleted_at AS deleted_at';
	}
	public function get_all(){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->select($this->select_default);
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier', 'left');
		$this->db->order_by("purchase_transaction.created_at", "desc");
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function get_product($id_product)
	{
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('id_product', $id_product);
		return $this->db->get('product')->row();
	}
	public function get_purchase_data($id_ptransaction, $id_product)
	{
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('id_product', $id_product);
		$this->db->where('id_ptransaction', $id_ptransaction);
		return $this->db->get('purchase_data')->row();
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
		$this->db->order_by('id_ptransaction', 'DESC');

		$query = $this->db->get($this->table,1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert($this->table, $data);
	}
	public function update($id,$data){
		$this->db->where('id_ptransaction', $id);
		$this->db->update($this->table, $data);
	}
	public function update_hpp($id,$data){
		$this->db->where('id_product', $id);
		$this->db->update('product', $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where($this->table,array('id_ptransaction' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_ptransaction', $id);
		$this->db->update($this->table, array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete($this->table, array('id_ptransaction' => $id));
	}
	public function get_detail($id,$array = false){
		$this->db->where('purchase_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('*, purchase_data.created_at AS created_at, purchase_data.updated_at AS updated_at, purchase_data.deleted_at AS deleted_at');
		$this->db->from('purchase_data');
		$this->db->join('purchase_transaction', 'purchase_data.id_ptransaction = purchase_transaction.id_ptransaction','right');
		$this->db->join('product', 'product.id_product = purchase_data.id_product', 'left');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier', 'left');
		$this->db->join('category', 'category.id_category = product.id_category', 'left');
		$this->db->where('purchase_data.id_ptransaction',$id);
		$query = $this->db->get();
		if($array){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}
	public function get_filter($filter = '',$is_array = false){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->select($this->select_default);
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier', 'left');
		$this->db->order_by("purchase_transaction.created_at", "desc");
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
	public function get_filter_csv($filter = ''){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('purchase_transaction.id_ptransaction AS "Kode Transaksi", supplier.id_supplier AS "Kode Supplier", supplier.supplier_name AS "Nama Supplier", supplier.supplier_phone AS "Telephon", supplier.supplier_address AS "Alamat Supplier", purchase_transaction.total_item AS "Banyak Barang", purchase_transaction.is_cash AS "Metode Pembayaran", purchase_transaction.total_price AS "Harga Total", purchase_transaction.created_at AS "Tanggal Transaksi"');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		$this->db->join('purchase_data', 'purchase_data.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('product', 'product.id_product = purchase_data.id_product');
		$this->db->join('category', 'category.id_category = product.id_category');

		$this->db->order_by("purchase_transaction.created_at", "desc");
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->order_by("created_at", "desc")->get_where($this->table,$filter);
		}else{
			$query = $this->db->order_by("created_at", "desc")->get($this->table);
		}
		return $query->num_rows();
	}
	public function insert_purchase_data($data){
		$this->db->insert('purchase_data', $data);
	}
	public function delete_purchase_data_trx_temp($id){
		$this->db->where('id_ptransaction', $id);
		$this->db->update('purchase_data', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete_purchase_data_trx($id_pdata){
		$this->db->delete('purchase_data', array('id_pdata' => $id_pdata));
	}

	/*
	 * Utang Disini
	 */
	public function count_total_filter_hutang($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$query = $this->db->order_by("created_at", "desc")->get_where($this->table,$filter);
		return $query->num_rows();
	}
	public function get_filter_hutang($filter = '',$limit_offset = array(),$is_array = false){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$this->db->select($this->select_default);
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier', 'left');
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
	public function get_filter_array($filter = ''){
		$this->db->select('purchase_transaction.id_ptransaction AS "Kode Transaksi", supplier.id_supplier AS "Kode Supplier", supplier.supplier_name AS "Nama Supplier", supplier.supplier_phone AS "Telephon", supplier.supplier_address AS "Alamat Supplier", purchase_transaction.total_item AS "Banyak Barang", purchase_transaction.total_price AS "Harga Total", purchase_transaction.created_at AS "Tanggal Transaksi"');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier', 'left');
		$this->db->where($filter);
		return $this->db->order_by($this->table.".created_at", "desc")->get($this->table)->result_array();
	}
}