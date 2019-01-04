<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	public function get_all(){
		$this->db->select('*, product.created_at AS created_at, product.updated_at AS updated_at, product.deleted_at AS deleted_at');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->join ('category', 'category.id_category = product.id_category');
        $query = $this->db->order_by("product.created_at", "desc")->get("product");
		return $query->result_array();
	}
	public function get_id_online(){
		$this->db->select('distinct(id_online)');
		$this->db->where('product.id_online !=', '');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
        $query = $this->db->get("product");
		return $query->result();
	}
    public function get_persediaan_awal($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'persediaan');
        $this->db->select_sum('cash_trx');
        if(!empty($filter)){
            $query = $this->db->get_where("other_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->cash_trx;
            }
        }else{
            $query = $this->db->get("other_transaction")->row()->cash_trx;
        }
        return $query;
    }
    public function get_persediaan($filter = array()){
        $this->db->where('kongsinyasi', '0');
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->select('SUM(product_qty*hpp) AS total');
        if(!empty($filter)){
            $query = $this->db->get_where("product",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total;
            }
        }else{
            $query = $this->db->get("product")->row()->total;
        }
        return $query;
    }
    public function get_persediaan_tambah($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        if(!empty($filter)){
            $query = $this->db->get_where("purchase_data",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->result_array();
            }
        }else{
            $query = $this->db->get("purchase_data")->result_array();
        }
        return $query;
    }
    public function get_sales_data($id_product){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('data_qty');
        return $this->db->get("sales_data")->row()->data_qty;
    }
    public function get_pretur_data($id_product){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('data_qty');
        return $this->db->get("purchase_retur_data")->row()->data_qty;
    }
    public function get_hpp($id_product){
        $this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->where('product.deleted_at', '0000-00-00 00:00:00');
        $this->db->where('sales_data.id_product', $id_product);
        $this->db->join('product', 'product.id_product = sales_data.id_product');
        $this->db->select('SUM(data_qty*hpp) AS total');
        return $this->db->get("sales_data")->row()->total;
    }
    public function get_hpp_retur($id_product){
        $this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->where('product.deleted_at', '0000-00-00 00:00:00');
        $this->db->where('sales_retur_data.id_product', $id_product);
        $this->db->join('product', 'product.id_product = sales_retur_data.id_product');
        $this->db->select('SUM(data_qty*hpp) AS total');
        return $this->db->get("sales_retur_data")->row()->total;
    }
	public function get_all_restock(){
		$this->db->where('product_restock.deleted_at', '0000-00-00 00:00:00');
		$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
	  	$this->db->join('product', 'product.id_product = product_restock.id_product');
		$this->db->join ('category', 'category.id_category = product.id_category');
      	$query = $this->db->order_by("product_restock.created_at", "desc")->get("product_restock");
		return $query->result();
	}
	public function count_total(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("product");
		return $query->num_rows();
	}
	public function count_total_restock(){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$query = $this->db->get("product_restock");
		return $query->num_rows();
	}
	public function get_all_array($filter){
		$this->db->select('product.id_product AS "Kode Barcode", product.id_online AS "Kode Online", product.product_name AS "Nama Produk", product.product_desc AS "Deskripsi Produk", category.category_name AS "Kategori Produk", product.product_qty AS "Jumlah Sekarang", product.minimum_qty AS "Jumlah Minimum", product.product_unit AS "Satuan Produk", product.hpp AS "HPP", product.bonus AS "Bonus Produk", product.sale_price AS "Harga Jual", product.sale_price_type1 AS "Harga Jual Tipe 1", product.sale_price_type2 AS "Harga Jual Tipe 2", product.sale_price_type3 AS "Harga Jual Tipe 3", product.created_at AS "Tanggal Pembuatan"');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->join ('category', 'category.id_category = product.id_category');
		if($filter){
			$query = $this->db->order_by("product.created_at", "desc")->get_where("product",$filter);
		}else{
			$query = $this->db->order_by("product.created_at", "desc")->get("product");
		}
		return $query->result_array();
	}
	public function get_all_warning_array($filter){
		$this->db->select('product.id_product AS "Kode Produk", product.product_name AS "Nama Produk", product.product_desc AS "Deskripsi Produk", category.category_name AS "Kategori Produk", product.product_qty AS "Jumlah Sekarang", product.minimum_qty AS "Jumlah Minimum", product.product_unit AS "Satuan Produk", product.sale_price AS "Harga Jual", product.sale_price_type1 AS "Harga Jual Tipe 1", product.sale_price_type2 AS "Harga Jual Tipe 2", product.sale_price_type3 AS "Harga Jual Tipe 3", product.created_at AS "Tanggal Pembuatan"');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->join ('category', 'category.id_category = product.id_category');
		if($filter){
			$query = $this->db->order_by("product.created_at", "desc")->get_where("product",$filter);
		}else{
			$query = $this->db->order_by("product.created_at", "desc")->get_where("product", "product_qty < minimum_qty");
		}
		return $query->result_array();
	}
	public function get_all_restock_array($filter){
		$this->db->where('product_restock.deleted_at', '0000-00-00 00:00:00');
		if($filter){
			$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
			$this->db->join('product', 'product.id_product = product_restock.id_product');
			$this->db->join ('category', 'category.id_category = product.id_category');
			$query = $this->db->order_by("product_restock.created_at", "desc")->get_where("product_restock",$filter);
		}else{
			$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
			$this->db->join('product', 'product.id_product = product_restock.id_product');
			$this->db->join ('category', 'category.id_category = product.id_category');
			$query = $this->db->order_by("product_restock.created_at", "desc")->get_where("product_restock");
		}
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('id', 'DESC');

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
	public function get_by_online($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('product',array('id_online' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function get_penjualan($id){
		$this->db->select('*, sales_data.created_at AS created_at, sales_data.updated_at AS updated_at, sales_data.deleted_at AS deleted_at');
		$this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('product', 'product.id_product = sales_data.id_product');
		$query = $this->db->get_where('sales_data',array('sales_data.id_product' => $id));
		return $query;
	}
	public function get_total_penjualan($id){
		$this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('subtotal');
		$query = $this->db->get_where('sales_data',array('sales_data.id_product' => $id));
		return $query->row()->subtotal;
	}
	public function get_pembelian($id){
		$this->db->select('*, purchase_data.created_at AS created_at, purchase_data.updated_at AS updated_at, purchase_data.deleted_at AS deleted_at');
		$this->db->where('purchase_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('product', 'product.id_product = purchase_data.id_product');
		$query = $this->db->get_where('purchase_data',array('purchase_data.id_product' => $id));
		return $query;
	}
	public function get_total_pembelian($id){
		$this->db->where('purchase_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('subtotal');
		$query = $this->db->get_where('purchase_data',array('purchase_data.id_product' => $id));
		return $query->row()->subtotal;
	}
	public function get_retur_penjualan($id){
		$this->db->select('*, sales_retur_data.created_at AS created_at, sales_retur_data.updated_at AS updated_at, sales_retur_data.deleted_at AS deleted_at');
		$this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('product', 'product.id_product = sales_retur_data.id_product');
		$query = $this->db->get_where('sales_retur_data',array('sales_retur_data.id_product' => $id));
		return $query;
	}
	public function get_total_retur_penjualan($id){
		$this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('subtotal');
		$query = $this->db->get_where('sales_retur_data',array('sales_retur_data.id_product' => $id));
		return $query->row()->subtotal;
	}
	public function get_retur_pembelian($id){
		$this->db->select('*, purchase_retur_data.created_at AS created_at, purchase_retur_data.updated_at AS updated_at, purchase_retur_data.deleted_at AS deleted_at');
		$this->db->where('purchase_retur_data.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->join('product', 'product.id_product = purchase_retur_data.id_product');
		$query = $this->db->get_where('purchase_retur_data',array('purchase_retur_data.id_product' => $id));
		return $query;
	}
	public function get_total_retur_pembelian($id){
		$this->db->where('purchase_retur_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('subtotal');
		$query = $this->db->get_where('purchase_retur_data',array('purchase_retur_data.id_product' => $id));
		return $query->row()->subtotal;
	}
	public function get_by_id2($id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->get_where('product',array('id_product' => $id));
		if($query && $query->num_rows()){
			$response = $query->row_array();
		}
		return $response;
	}
	public function delete_temp($id){
		$this->db->where('id_product', $id);
		$this->db->update('product', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete($id){
		$this->db->delete('product', array('id_product' => $id));
	}
	public function delete_restock_temp($id){
		$this->db->where('id_restock', $id);
		$this->db->update('product_restock', array('deleted_at' => date('Y-m-d H:i:s')));
	}
	public function delete_restock($id){
		$this->db->delete('product_restock', array('id_restock' => $id));
	}
	public function get_filter($filter = ''){
		$this->db->select('*, product.created_at AS created_at, product.updated_at AS updated_at, product.deleted_at AS deleted_at');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->join ('category', 'category.id_category = product.id_category');
		if(!empty($filter)){
			$query = $this->db->get_where("product",$filter);
		}else{
			$query = $this->db->get("product");
		}
		return $query->result_array();
	}
	public function get_restock_filter($filter = ''){
		$this->db->where('product_restock.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
			$this->db->join('product', 'product.id_product = product_restock.id_product');
			$this->db->join ('category', 'category.id_category = product.id_category');
			$query = $this->db->order_by("product_restock.created_at", "desc")->get_where("product_restock",$filter);
		}else{
			$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
			$this->db->join('product', 'product.id_product = product_restock.id_product');
			$this->db->join ('category', 'category.id_category = product.id_category');
			$query = $this->db->order_by("product_restock.created_at", "desc")->get("product_restock");
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		$this->db->select('*, product.created_at AS created_at, product.updated_at AS updated_at, product.deleted_at AS deleted_at');
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$this->db->where('category.deleted_at', '0000-00-00 00:00:00');
		$this->db->join ('category', 'category.id_category = product.id_category');
		if(!empty($filter)){
			$query = $this->db->get_where("product",$filter);
		}else{
			$query = $this->db->get("product");
		}
		return $query->num_rows();
	}
	public function count_total_restock_filter($filter = array()){
		$this->db->where('product_restock.deleted_at', '0000-00-00 00:00:00');
		if(!empty($filter)){
			$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
			$this->db->join('product', 'product.id_product = product_restock.id_product');
			$this->db->join ('category', 'category.id_category = product.id_category');
			$query = $this->db->get_where("product_restock",$filter);
		}else{
			$this->db->select('*, product_restock.created_at AS created_at, product_restock.updated_at AS updated_at, product_restock.deleted_at AS deleted_at');
			$this->db->join('product', 'product.id_product = product_restock.id_product');
			$this->db->join ('category', 'category.id_category = product.id_category');
			$query = $this->db->get("product_restock");
		}
		return $query->num_rows();
	}
	public function get_by_category($category_id){
		$this->db->where('deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$query = $this->db->order_by("created_at", "desc")->get_where('product',array('id_category' => $category_id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function detail_by_id($id){
		$this->db->where('product.deleted_at', '0000-00-00 00:00:00');
		$response = false;
		$this->db->where('product.id_product',$id);
		$this->db->join('category', 'category.id_category = product.id_category', 'left');
		$query = $this->db->get('product');
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function update_qty($id,$data){
		$this->db->where('id_product', $id);
		$this->db->update('product', $data);
		return TRUE;
	}
	public function update_qty_add($id,$data){
		$this->db->set('product_qty', 'product_qty+'.$data['product_qty'], FALSE);
		$this->db->where('id_product', $id);
		$this->db->update('product');
		return TRUE;
	}
	public function update_qty_min($id,$data){
		$this->db->set('product_qty', 'product_qty-'.$data['product_qty'], FALSE);
		$this->db->where('id_product', $id);
		$this->db->update('product');
		return TRUE;
	}
	public function update_qty_plus($id,$data){
		$this->db->set('product_qty', 'product_qty+'.$data['product_qty'], FALSE);
		$this->db->where('id_product', $id);
		$this->db->update('product');
		return TRUE;
	}
	public function restock(){
		$id_product = $this->input->post('id_product');
		$this->db->where('id_product', $id_product);
		$product_qty = $this->db->get('product')->row()->product_qty;

		$data_restock = array(
			'id_product' => $id_product,
			'stock_qty' => $this->input->post('qty'),
			'qty_before' => $product_qty
			);
		$this->db->insert('product_restock', $data_restock);

		$data_product = array(
			'product_qty' => $product_qty + $this->input->post('qty'),
		);
		$this->db->where('id_product', $id_product);
		if ($this->db->update('product', $data_product) === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function process_qty($transaction = array()){
		$data = '';
		foreach($transaction as $k => $item){
			$data[$item->product_id] = $item->quantity;
		}
		return $data;
	}
	public function process_cart_qty($carts = array()){
		$data = '';
		foreach($carts as $k => $item){
			$data[$item['id']] = $item['qty'];
		}
		return $data;
	}
}