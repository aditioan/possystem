<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_purchase_model extends CI_Model {
	private $table;
	private $table_data;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "purchase_retur";
		$this->table_data = "purchase_retur_data";
		$this->select_default = '*, purchase_retur.created_at AS created_at, purchase_retur.updated_at AS updated_at, purchase_retur.deleted_at AS deleted_at';
	}
	public function get_all(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->select($this->select_default);
		$this->db->order_by("created_at", "desc");
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function get_retur_data($id_pretur, $id_product)
	{
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$this->db->where('id_product', $id_product);
		$this->db->where('id_pretur', $id_pretur);
		return $this->db->get('purchase_retur_data')->row();
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
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get($this->table,1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert($this->table, $data);
	}
	public function update($id,$data){
		$this->db->where('id_pretur', $id);
		$this->db->update($this->table, $data);
	}
	public function get_by_id($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where($this->table,array('id_pretur' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_pretur', $id);
		$this->db->update('purchase_retur', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete($this->table, array('id_pretur' => $id));
	}
	public function delete_data_temp($id_pretur){
		$this->db->where('id_pretur', $id_pretur);
		$this->db->update('purchase_retur_data', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete_data($id_pdata){
		$this->db->delete("purchase_data", array('$id_pdata' => $id_pdata));
	}
	public function delete_data_sales($id_sdata){
		$this->db->delete("sales_data", array('id_sdata' => $id_sdata));
	}//apa ini?
	public function get_detail($id_pdata){
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$sql = "SELECT *, purchase_retur.created_at AS created_at, purchase_retur.updated_at AS updated_at, purchase_retur.deleted_at AS deleted_at FROM purchase_retur 
				JOIN purchase_data ON purchase_retur.id_pdata = purchase_data.id_pdata 
				JOIN product ON product.id_product = purchase_data.id_product 
				JOIN category ON category.id_category = product.id_category 
				WHERE purchase_retur.id_pdata = '".$id_pdata."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_detail_by_id($id){
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$sql = "SELECT *, purchase_retur.created_at AS created_at, purchase_retur.updated_at AS updated_at, purchase_retur.deleted_at AS deleted_at FROM purchase_retur 
				JOIN purchase_retur_data ON purchase_retur.id_pretur = purchase_retur_data.id_pretur 
				JOIN product ON product.id_product = purchase_retur_data.id_product 
				JOIN category ON category.id_category = product.id_category 
			  	WHERE purchase_retur.id_pretur = '".$id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_detail_by_data_id($id){
		$this->db->where('purchase_retur_data.deleted_at', '0000-00-00 00:00:00');
		$sql = "SELECT *, purchase_retur.created_at AS created_at, purchase_retur.updated_at AS updated_at, purchase_retur.deleted_at AS deleted_at FROM purchase_retur 
				JOIN purchase_retur_data ON purchase_retur.id_pdata = sales_data.id_stransaction 
				JOIN product ON product.id_product = purchase_data.id_product 
				JOIN category ON category.id_category = product.id_category 
			  	WHERE purchase_retur_data.id_pretur = '".$id."'";
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
	public function insert_purchase_data($data){
		$this->db->insert($this->table_data, $data);
	}
	public function insert_retur_data($data){
		$this->db->insert($this->table_data, $data);
	}
	public function delete_purchase_data_trx_temp($id_pdata){
		$this->db->update($this->table_data, array('deleted_at' => date('Y-m-d H:i:s')));
		$this->db->delete($this->table_data, array('id_pdata' => $id_pdata));
	}
	public function delete_purchase_data_trx($id_pdata){
		$this->db->delete($this->table_data, array('id_pdata' => $id_pdata));
	}

	/*
	 * Tunggakan Disini
	 */
	public function count_total_filter_tunggakan($filter = array()){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$query = $this->db->get_where($this->table,$filter);
		return $query->num_rows();
	}
	public function get_filter_tunggakan($filter = '',$limit_offset = array(),$is_array = false){
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$filter['is_cash'] = 0;
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id_customer = sales_transaction.id_customer', 'left');
		$this->db->where($filter);
		if($limit_offset){
			$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
		}
		$query = $this->db->get($this->table);

		if($is_array){
			$resopnse = $query->result_array();
		}else{
			$resopnse = $query->result();
		}
		return $resopnse;
	}

	public function insert_retur_carts($purchase_retur_id,$carts){
		foreach($carts as $key => $cart){
			$retur_data = array(
				'transaction_id' => $purchase_retur_id,
				'product_id' => $cart['id'],
				'category_id' => $cart['category_id'],
				'quantity' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$this->insert_purchase_data($retur_data);

			///$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
		}
	}

	public function get_filter_csv($filter = ''){
		$this->db->where('purchase_retur.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('purchase_retur.id_pretur AS "Kode Retur", purchase_retur.id_ptransaction AS "Kode Transaksi", supplier.id_supplier AS "Kode Supplier", supplier.supplier_name AS "Nama Supplier", supplier.supplier_phone AS "Telephon", supplier.supplier_address AS "Alamat Supplier", purchase_retur.total_item AS "Total Barang", purchase_retur.total_price AS "Total Harga", purchase_retur.return_by AS "Bentuk Retur", purchase_retur.created_at AS "Tanggal Retur"');

		$this->db->join('purchase_transaction', 'purchase_transaction.id_ptransaction = purchase_retur.id_ptransaction');
		$this->db->join('supplier', 'supplier.id_supplier = purchase_transaction.id_supplier');
		
		$this->db->order_by("purchase_retur.created_at", "desc");
		if ($filter != '') {
			$this->db->where($filter);
		}
		
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
}