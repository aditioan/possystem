<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("supplier");
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("supplier");
		return $query->num_rows();
	}
	public function get_all_array($filter = ''){
		$this->db->select('supplier.id_supplier AS "Kode Supplier", supplier.supplier_name AS "Nama Supplier", supplier.company_name AS "Nama Perusahaan", supplier.supplier_email AS "Email Supplier", supplier.supplier_phone AS "Telephon", supplier.supplier_wa AS "WA", supplier.supplier_line AS "LINE", supplier.supplier_address AS "Alamat Supplier", supplier.created_at AS "Tanggal Pembuatan"');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)) {
			$query = $this->db->get_where("supplier",$filter);
		}else{
			$query = $this->db->get_where("supplier");
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('created_at', 'DESC');

		$query = $this->db->get("supplier",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('supplier', $data);
	}
	public function update($id,$data){
		$this->db->where('id_supplier', $id);
		$this->db->update('supplier', $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('supplier',array('id_supplier' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_supplier', $id);
		$this->db->update('supplier', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete('supplier', array('id_supplier' => $id));
	}
	public function get_filter($filter = ''){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("supplier",$filter);
		}else{
			$query = $this->db->get("supplier");
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("supplier",$filter);
		}else{
			$query = $this->db->get("supplier");
		}
		return $query->num_rows();
	}
	public function get_pembelian($id_supplier, $filter = ''){
		$this->db->select('*, purchase_transaction.created_at AS created_at, purchase_transaction.updated_at AS updated_at, purchase_transaction.deleted_at AS deleted_at');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('purchase_data', 'purchase_data.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('product', 'product.id_product = purchase_data.id_product');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
		return $query;
	}
	public function get_retur_pembelian($id_supplier, $filter = ''){
		$this->db->select('*, purchase_retur.created_at AS created_at, purchase_retur.updated_at AS updated_at, purchase_retur.deleted_at AS deleted_at');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('supplier.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('purchase_retur', 'purchase_retur.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('purchase_retur_data', 'purchase_retur_data.id_pretur = purchase_retur.id_pretur');
		$this->db->join('product', 'product.id_product = purchase_retur_data.id_product');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		return $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
	}
	public function get_total_pembelian($id_supplier, $filter = ''){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
		return $query->row()->total_price;
	}
	public function get_total_utang($id_supplier, $filter = ''){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_transaction.is_cash', '0');
		if(!empty($filter)){
			$this->db->where($filter);
		}
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
		return $query->row()->total_price;
	}
	public function get_total_retur_pembelian($id_supplier, $filter = ''){
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('purchase_retur', 'purchase_retur.id_ptransaction = purchase_transaction.id_ptransaction');
        $this->db->select_sum('purchase_retur.total_price');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
		return $query->row()->total_price;
	}
	public function export_pembelian($id_supplier, $filter = ''){
		$this->db->select('supplier_name AS "Nama Supplier", supplier_phone AS "Telp. Supplier", product_name AS "Nama Produk", data_qty AS "Jumlah Produk", price_item AS "Harga Jual", subtotal AS "Total", purchase_transaction.created_at AS "Tanggal Pembelian"');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('purchase_data', 'purchase_data.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('product', 'product.id_product = purchase_data.id_product');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		$query = $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
		return $query;
	}
	public function export_retur_pembelian($id_supplier, $filter = ''){
		$this->db->select('supplier_name AS "Nama Supplier", supplier_phone AS "Telp. Supplier", product_name AS "Nama Produk", data_qty AS "Jumlah Produk", price_item AS "Harga Jual", subtotal AS "Total", purchase_retur.created_at AS "Tanggal Retur"');
		$this->db->where('purchase_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('purchase_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('supplier.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('purchase_retur', 'purchase_retur.id_ptransaction = purchase_transaction.id_ptransaction');
		$this->db->join('purchase_retur_data', 'purchase_retur_data.id_pretur = purchase_retur.id_pretur');
		$this->db->join('product', 'product.id_product = purchase_retur_data.id_product');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		return $this->db->get_where('purchase_transaction',array('purchase_transaction.id_supplier' => $id_supplier));
	}
}