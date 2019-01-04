<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    public function get_all(){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->order_by("created_at", "desc");
        $query = $this->db->get("other_transaction");
        return $query->result();
    }
    public function get_period(){
        $this->db->where('end_date', '0000-00-00 00:00:00');
        $query = $this->db->get("period");
        return $query->row();
    }
    public function count_total($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        if(!empty($filter)){
            $query = $this->db->get_where("other_transaction",$filter);
        }else{
            $query = $this->db->get("other_transaction");
        }
        return $query->num_rows();
    }
    public function get_all_array($filter = false){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        if($filter){
            $query = $this->db->get_where("other_transaction",$filter);
        }else{
            $query = $this->db->get("other_transaction");
        }
        return $query->result_array();
    }
    public function get_last_id(){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->order_by('id_other_transaction', 'DESC');

        $query = $this->db->get("other_transaction",1,0);
        return $query->result();
    }
    public function get_last_trx(){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get("other_transaction",1,0);
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
    public function get_hpp($filter = array()){
        $this->db->where('sales_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->where('product.deleted_at', '0000-00-00 00:00:00');
        //$this->db->where('sales_transaction.is_cash', '1');
        $this->db->join('product', 'product.id_product = sales_data.id_product');
        //$this->db->join('sales_transaction', 'sales_transaction.id_stransaction = sales_data.id_stransaction');
        $this->db->select('SUM(data_qty*hpp) AS total');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_data",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total;
            }
        }else{
            $query = $this->db->get("sales_data")->row()->total;
        }
        return $query;
    }
    public function get_hpp_retur($filter = array()){
        $this->db->where('sales_retur_data.deleted_at', '0000-00-00 00:00:00');
        $this->db->where('product.deleted_at', '0000-00-00 00:00:00');
        //$this->db->where('sales_transaction.is_cash', '1');
        $this->db->join('product', 'product.id_product = sales_retur_data.id_product');
        //$this->db->join('sales_transaction', 'sales_transaction.id_stransaction = sales_retur_data.id_stransaction');
        $this->db->select('SUM(data_qty*hpp) AS total');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_retur_data",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total;
            }
        }else{
            $query = $this->db->get("sales_retur_data")->row()->total;
        }
        return $query;
    }
    public function get_first_modal($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->order_by('created_at', 'ASC');
        $this->db->where('action', '1');
        $this->db->where('type', 'modal');
        if(!empty($filter)){
            $query = $this->db->get_where("other_transaction",$filter,1,0);
            if ($query->num_rows() != 0) {
                $query = $query->row();
            }else{
                $query = FALSE;
            }
        }else{
            $query = $this->db->get("other_transaction",1,0)->row();
        }
        return $query;
    }
    public function get_modal_kurang($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '0');
        $this->db->where('type', 'modal');
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
    public function get_modal_tambah($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '1');
        $this->db->where('type', 'modal');
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
    public function get_other_transaction($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->order_by('created_at', 'DESC');
        if(!empty($filter)){
            $query = $this->db->get_where("other_transaction",$filter,1,0);
            if ($query->num_rows() != 0) {
                $query = $query->row()->cash_total;
            }else{
                $query = $query->num_rows();
            }
        }else{
            $query = $this->db->get("other_transaction",1,0)->row()->cash_total;
        }
        return $query;
    }
    public function get_purchase($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('is_cash', '1');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("purchase_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("purchase_transaction")->row()->total_price;
        }
        return $query;
    }
    public function get_hutang_pembelian($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('is_cash', '0');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("purchase_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("purchase_transaction")->row()->total_price;
        }
        return $query;
    }
    public function get_sales($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('is_cash', '1');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("sales_transaction")->row()->total_price;
        }
        return $query;
    }
    public function get_all_sales($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        //$this->db->where('is_cash', '1');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("sales_transaction")->row()->total_price;
        }
        return $query;
    }
    public function get_piutang($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('is_cash', '0');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("sales_transaction")->row()->total_price;
        }
        return $query;
    }
    public function get_perawatan($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'perawatan');
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
    public function get_sewa_kurang($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '0');
        $this->db->where('type', 'sewa');
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
    public function get_sewa_tambah($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '1');
        $this->db->where('type', 'sewa');
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
    public function get_peralatan($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '0');
        $this->db->where('type', 'peralatan');
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
    public function get_peralatan_awal($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '1');
        $this->db->where('type', 'peralatan');
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
    public function get_all_peralatan($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'peralatan');
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
    public function get_perlengkapan($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'perlengkapan');
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
    public function get_gaji($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'gaji');
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
    public function get_kas($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'kas');
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
    public function get_persediaan_sekarang($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->select('SUM((product_qty)*(sale_price)) AS total');
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
    public function get_pembelian($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        //$this->db->select('SUM((product_qty)*(sale_price)) AS total');
        if(!empty($filter)){
            $query = $this->db->get_where("purchase_data",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total;
            }
        }else{
            $query = $this->db->get("purchase_data")->result_array();
        }
        return $query;
    }
    // public function get_hpp($id_product, $filter = array()){
    //     $this->db->where('deleted_at', '0000-00-00 00:00:00');
    //     $this->db->where('id_product', $id_product);
    //     $this->db->select_avg('price_item');
    //     if(!empty($filter)){
    //         $query = $this->db->get_where("purchase_data",$filter);
    //         if ($query->num_rows() != 0) {
    //             $query = $query->row()->price_item;
    //         }
    //     }else{
    //         $query = $this->db->get("purchase_data")->row()->price_item;
    //     }
    //     return $query;
    // }
    public function get_pembelian_total($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("purchase_transaction",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("purchase_transaction")->row()->total_price;
        }
        return $query;
    }
    public function get_penjualan($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        //$this->db->select('SUM((product_qty)*(sale_price)) AS total');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_data",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total;
            }
        }else{
            $query = $this->db->get("sales_data")->result_array();
        }
        return $query;
    }
    public function get_hutang_usaha($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('type', 'hutang');
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
    public function get_sales_retur($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('return_by', '0');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("sales_retur",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("sales_retur")->row()->total_price;
        }
        return $query;
    }
    public function get_purchase_retur($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('return_by', '0');
        $this->db->select_sum('total_price');
        if(!empty($filter)){
            $query = $this->db->get_where("purchase_retur",$filter);
            if ($query->num_rows() != 0) {
                $query = $query->row()->total_price;
            }
        }else{
            $query = $this->db->get("purchase_retur")->row()->total_price;
        }
        return $query;
    }
    public function get_other_outcome($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '0');
        $this->db->where('type', 'lain-lain');
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
    public function get_other_income($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->where('action', '1');
        $this->db->where('type', 'lain-lain');
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
    // public function get_total_outcome($filter = array()){
    //     $this->db->where('deleted_at', '0000-00-00 00:00:00');
    //     $this->db->where('action', '0');
    //     $this->db->select_sum('cash_trx');
    //     if(!empty($filter)){
    //         $query = $this->db->get_where("other_transaction",$filter);
    //         if ($query->num_rows() != 0) {
    //             $query = $query->row()->cash_trx;
    //         }
    //     }else{
    //         $query = $this->db->get("other_transaction")->row()->cash_trx;
    //     }
    //     return $query;
    // }
    // public function get_total_income($filter = array()){
    //     $this->db->where('deleted_at', '0000-00-00 00:00:00');
    //     $this->db->where('type !=', 'modal');
    //     $this->db->where('action', '1');
    //     $this->db->select_sum('cash_trx');
    //     if(!empty($filter)){
    //         $query = $this->db->get_where("other_transaction",$filter,1,0);
    //         if ($query->num_rows() != 0) {
    //             $query = $query->row()->cash_trx;
    //         }
    //     }else{
    //         $query = $this->db->get("other_transaction",1,0)->row()->cash_trx;
    //     }
    //     return $query;
    // }
    public function get_data_chart($filter, $action){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        if ($action == '1') {
            $this->db->where('type !=', 'modal');
        }
        $this->db->where('action', $action);
        $this->db->select_sum('cash_trx');
        return $this->db->get_where("other_transaction",$filter)->row()->cash_trx;
    }
    public function insert($data){
        $this->db->insert('other_transaction', $data);
    }
    public function set_new_period(){
        $this->db->where('end_date', '0000-00-00 00:00:00');
        $this->db->update('period', array('end_date' => date('Y-m-d H:i:s')));
        $this->db->insert('period', array('start_date' => date('Y-m-d H:i:s')));
    }
    public function update($id,$data){
        $this->db->where('id_other_transaction', $id);
        $this->db->update('other_transaction', $data);
    }
    public function get_by_id($id){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $response = false;
        $query = $this->db->get_where('other_transaction',array('id_other_transaction' => $id));
        if($query && $query->num_rows()){
            $response = $query->result_array();
        }
        return $response;
    }
    public function delete_temp($id){
        $this->db->where('id_other_transaction', $id);
        $this->db->update('other_transaction', array('deleted_at' => date('Y-m-d H:i:s')));
    }
    public function delete_trx_temp($id){
        $this->db->where('id_transaction', $id);
        $this->db->update('other_transaction', array('deleted_at' => date('Y-m-d H:i:s')));
    }
    public function delete($id){
        $this->db->delete('other_transaction', array('id_other_transaction' => $id));
    }
    public function clean_otransaction(){
        $this->db->delete('other_transaction');
    }
    public function clean_stransaction(){
        $this->db->delete('sales_transaction');
    }
    public function clean_ptransaction(){
        $this->db->delete('purchase_transaction');
    }
    public function reset_modal(){
        $this->db->where('type', 'modal');
        $this->db->update('other_transaction', array('deleted_at' => date('Y-m-d H:i:s')));
    }
    public function get_filter($filter = ''){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $this->db->order_by('created_at', 'DESC');
        if(!empty($filter)){
            $query = $this->db->get_where("other_transaction",$filter);
        }else{
            $query = $this->db->get("other_transaction");
        }
        return $query->result();
    }
    public function count_total_filter($filter = array()){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        if(!empty($filter)){
            $query = $this->db->get_where("other_transaction",$filter);
        }else{
            $query = $this->db->get("other_transaction");
        }
        return $query->num_rows();
    }
}