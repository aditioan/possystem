<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$query = $this->db->get("customer");
		return $query->result();
	}
	public function get_all_pelanggan(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('status', '0');
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$query = $this->db->get("customer");
		return $query->result();
	}
	public function get_all_reseller(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('status', '1');
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$query = $this->db->get("customer");
		return $query->result();
	}
	public function get_all_dropshipper(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('status', '2');
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$query = $this->db->get("customer");
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("customer");
		return $query->num_rows();
	}
	public function get_all_array($filter = false){
		$this->db->select('customer.id_customer AS "Kode Pelanggan", customer.customer_name AS "Nama Pelanggan", customer.customer_category AS "Kategori Pelanggan", customer.calling AS "Panggilan Pelanggan", customer.status AS "Jenis Pelanggan", customer.customer_phone AS "Telephon", customer.customer_address AS "Alamat Pelanggan", customer.created_at AS "Tanggal Pembuatan"');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('id_customer !=', 'CUSTKASIR');
		if(!empty($filter)) {
			$query = $this->db->get_where("customer", $filter);
		}else{
			$query = $this->db->get("customer");
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('created_at', 'DESC');

		$query = $this->db->get("customer",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('customer', $data);
	}
	public function update($id,$data){
		$this->db->where('id_customer', $id);
		$this->db->update('customer', $data);
	}
	public function get_by_id($id){
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('customer',array('id_customer' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function get_by_status($status){
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('customer',array('status' => $status));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_customer', $id);
		$this->db->update('customer', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete('customer', array('id_customer' => $id));
	}
	public function get_filter($filter = '',$limit_offset = array()){
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("customer",$filter);
		}else{
			$query = $this->db->get("customer");
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		$this->db->where('id_customer !=', 'CUSTKASIR');
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$query = $this->db->get_where("customer",$filter);
		}else{
			$query = $this->db->get("customer");
		}
		return $query->num_rows();
	}
	public function get_penjualan($id_customer, $filter = ''){
		$this->db->select('*, sales_transaction.created_at AS created_at, sales_transaction.updated_at AS updated_at, sales_transaction.deleted_at AS deleted_at');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_data', 'sales_data.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('product', 'product.id_product = sales_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
		return $query;
	}
	public function get_penjualan_dropshipper($id_customer, $filter = ''){
		$this->db->select('*, sales_transaction.created_at AS created_at, sales_transaction.updated_at AS updated_at, sales_transaction.deleted_at AS deleted_at');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_data', 'sales_data.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('product', 'product.id_product = sales_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
		return $query;
	}
	public function get_retur_penjualan($id_customer, $filter = ''){
		$this->db->select('*, sales_retur.created_at AS created_at, sales_retur.updated_at AS updated_at, sales_retur.deleted_at AS deleted_at');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('customer.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_retur', 'sales_retur.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('sales_retur_data', 'sales_retur_data.id_sretur = sales_retur.id_sretur');
		$this->db->join('product', 'product.id_product = sales_retur_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		return $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
	}
	public function get_retur_penjualan_dropshipper($id_customer, $filter = ''){
		$this->db->select('*, sales_retur.created_at AS created_at, sales_retur.updated_at AS updated_at, sales_retur.deleted_at AS deleted_at');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('customer.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_retur', 'sales_retur.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('sales_retur_data', 'sales_retur_data.id_sretur = sales_retur.id_sretur');
		$this->db->join('product', 'product.id_product = sales_retur_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		return $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
	}
	public function get_total_penjualan($id_customer, $filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
		return $query->row()->total_price;
	}
	public function get_total_penjualan_dropshipper($id_customer, $filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
		return $query->row()->total_price;
	}
	public function get_total_tunggakan($id_customer, $filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_transaction.is_cash', '0');
		if(!empty($filter)){
			$this->db->where($filter);
		}
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
		return $query->row()->total_price;
	}
	public function get_total_tunggakan_dropshipper($id_customer, $filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_transaction.is_cash', '0');
		if(!empty($filter)){
			$this->db->where($filter);
		}
        $this->db->select_sum('total_price');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
		return $query->row()->total_price;
	}
	public function get_total_retur_penjualan($id_customer, $filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_retur', 'sales_retur.id_stransaction = sales_transaction.id_stransaction');
        $this->db->select_sum('sales_retur.total_price');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
		return $query->row()->total_price;
	}
	public function get_total_retur_penjualan_dropshipper($id_customer, $filter = ''){
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_retur', 'sales_retur.id_stransaction = sales_transaction.id_stransaction');
        $this->db->select_sum('sales_retur.total_price');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
		return $query->row()->total_price;
	}
	public function export_penjualan($id_customer, $filter = ''){
		$this->db->select('customer_name AS "Nama Pelanggan", customer_phone AS "Telp. Pelanggan", product_name AS "Nama Produk", category_name AS "Kategori Produk", data_qty AS "Jumlah Produk", price_item AS "Harga Jual", subtotal AS "Total", sales_transaction.created_at AS "Tanggal Transaksi"');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_data', 'sales_data.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('product', 'product.id_product = sales_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
		return $query;
	}
	public function export_penjualan_dropshipper($id_customer, $filter = ''){
		$this->db->select('customer_name AS "Nama Pelanggan", customer_phone AS "Telp. Pelanggan", product_name AS "Nama Produk", category_name AS "Kategori Produk", data_qty AS "Jumlah Produk", price_item AS "Harga Jual", subtotal AS "Total", sales_transaction.created_at AS "Tanggal Transaksi"');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_data', 'sales_data.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('product', 'product.id_product = sales_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		$query = $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
		return $query;
	}
	public function export_retur_penjualan($id_customer, $filter = ''){
		$this->db->select('customer_name AS "Nama Pelanggan", customer_phone AS "Telp. Pelanggan", product_name AS "Nama Produk", category_name AS "Kategori Produk", data_qty AS "Jumlah Produk", price_item AS "Harga Jual", subtotal AS "Total", sales_transaction.created_at AS "Tanggal Retur"');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('customer.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_retur', 'sales_retur.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('sales_retur_data', 'sales_retur_data.id_sretur = sales_retur.id_sretur');
		$this->db->join('product', 'product.id_product = sales_retur_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		return $this->db->get_where('sales_transaction',array('sales_transaction.id_customer' => $id_customer));
	}
	public function export_retur_penjualan_dropshipper($id_customer, $filter = ''){
		$this->db->select('customer_name AS "Nama Pelanggan", customer_phone AS "Telp. Pelanggan", product_name AS "Nama Produk", category_name AS "Kategori Produk", data_qty AS "Jumlah Produk", price_item AS "Harga Jual", subtotal AS "Total", sales_retur.created_at AS "Tanggal Retur"');
		$this->db->where('sales_transaction.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('customer.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->where($filter);
		}
		$this->db->join('sales_retur', 'sales_retur.id_stransaction = sales_transaction.id_stransaction');
		$this->db->join('sales_retur_data', 'sales_retur_data.id_sretur = sales_retur.id_sretur');
		$this->db->join('product', 'product.id_product = sales_retur_data.id_product');
		$this->db->join('category', 'product.id_category = category.id_category');
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer');
		return $this->db->get_where('sales_transaction',array('sales_transaction.id_dropshipper' => $id_customer));
	}
}