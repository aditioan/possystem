<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other_transaction_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    public function get_all(){
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $query = $this->db->get("other_transaction");
        return $query->result();
    }
    public function count_total(){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $query = $this->db->get("other_transaction");
        return $query->num_rows();
    }
    public function get_all_array($filter = false){
        $this->db->select('other_transaction.id_otransaction AS "Kode Transaksi", other_transaction.type AS "Jenis Transaksi", other_transaction.action AS "Aksi", other_transaction.description AS "Deskripsi", other_transaction.cash_trx AS "Besar Uang", other_transaction.created_at AS "Tanggal Transaksi", other_transaction.updated_at AS "Tanggal Diupdate"');
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        if($filter){
            $query = $this->db->get_where("other_transaction",$filter);
        }else{
            $query = $this->db->get("other_transaction");
        }
        return $query->result_array();
    }
    public function get_last_id(){
        $this->db->order_by('created_at', 'DESC');

        $query = $this->db->get("other_transaction",1,0);
        return $query->result();
    }
    public function insert($data){
        $this->db->insert('other_transaction', $data);
    }
    public function update($id,$data){
        $this->db->where('id_otransaction', $id);
        $this->db->update('other_transaction', $data);
    }
    public function get_by_id($id){
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        $response = false;
        $query = $this->db->get_where('other_transaction',array('id_otransaction' => $id));
        if($query && $query->num_rows()){
            $response = $query->result_array();
        }
        return $response;
    }
    public function delete_temp($id){
        $this->db->where('id_otransaction', $id);
        $this->db->update('other_transaction', array('deleted_at' => date('Y-m-d H:i:s')));
    }
    public function delete($id){
        $this->db->delete('other_transaction', array('id_otransaction' => $id));
    }
    public function get_filter($filter = '',$limit_offset = array()){
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('deleted_at', '0000-00-00 00:00:00');
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